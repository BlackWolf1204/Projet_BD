<!DOCTYPE html>

 <html lang="fr">
 
 <head>
 
    <title>Page consomation</title>

    <?php require "../common/header.php"; ?>

    <h2>Votre consommation et production</h2>

    <a href="../Page_accueil/Page_accueil.php" class = "bouton-retour">Retour à l'accueil</a>

    <?php

    pageAccueilSiNonConnecte($ROOT);

    // requete pour la base
    $reqApparts = 'SELECT Appartement.idAppartement, numAppart, numeroRue, nomRue, codePostal, nomVille, nomPropriete,
                    datedebutprop, datefinprop,
                    datedebutloc, dateFinLoc, nbHabitants,
                    (UNIX_TIMESTAMP(IFNULL(dateFinLoc,NOW())) - UNIX_TIMESTAMP(datedebutloc)) AS tempsDureeLocation,
                    idProprietaire, nomProprietaire, prenomProprietaire,
                    idLocataire, nomLocataire, prenomLocataire
            FROM Appartement NATURAL JOIN ProprieteAdresse
            LEFT OUTER JOIN DernierProprietaire ON ProprieteAdresse.idPropriete = DernierProprietaire.idPropriete
            LEFT OUTER JOIN LocataireActuel ON Appartement.idAppartement = LocataireActuel.idAppartement';

    if (!isset($estAdmin) || $estAdmin != true) {
        $reqApparts = "$reqApparts WHERE idProprietaire = $sessionId";
    }

    // exécution de la requête
    $dataApparts = $bdd->query($reqApparts);
    // si erreur
    if ($dataApparts == NULL)
    die("Problème d'exécution de la requête des appartements : {$bdd->errorInfo()[2]} \n");

    $nbLignes = 0;
    foreach ($dataApparts as $appartement) {
        $nbLignes++;

        // La durée de la location depuis le début de la location jusqu'à la fin de la location (ou jusqu'à maintenant) en heures
        $heuresDureeLocation = $appartement['tempsDureeLocation'] / 3600;

        
        echo "<div class=\"appart\">
        <h3>";
        
        if ($appartement['numAppart'] != NULL) echo "Appartement {$appartement['numAppart']} - ";
        echo adressePropriete($appartement) . "</h3>";
        
        if($appartement['idProprietaire'] != NULL) {
            $lienProp = lienInfoPersonne($appartement['idProprietaire'], $appartement['nomProprietaire'], $appartement['prenomProprietaire'], $ROOT);
            $textePeriodeProprietaire = periodeDateDuAu($appartement['datedebutprop'], $appartement['datefinprop']);
            echo "<p>Propriétaire : $lienProp $textePeriodeProprietaire.</p>";
        }
        else {
            echo "<p>Sans propriétaire.</p>";
        }
        
        if($appartement['datedebutloc'] == NULL) {
            echo "<p>Appartement non loué</p>";
            echo "</div>";
            continue;
        }
        $dateDebut = $appartement['datedebutloc'];
        $dateFin = $appartement['dateFinLoc'];
        $textPeriodeLocation = periodeDateDuAu($dateDebut, $dateFin);
        if($dateFin == NULL) $dateFin = date('Y-m-d');
        $lienLocataire = lienInfoPersonne($appartement['idLocataire'], $appartement['nomLocataire'], $appartement['prenomLocataire'], $ROOT);
        echo "<p>Locataire : $lienLocataire $textPeriodeLocation.</p>";
        $nbJoursLocation = round($heuresDureeLocation / 24, 0);
        $texteHabitants = ($appartement['nbHabitants'] > 1) ? "habitants" : "habitant";
        echo "<p>Données sur la période de location ($nbJoursLocation jours) et pour {$appartement['nbHabitants']} $texteHabitants.</p>";
        
        // CONSOMMATION de ressources

        // requete pour la base
        $reqConso = "SELECT idAppareil, libTypeRessource, valCritiqueConsoAppart, valIdealeConsoAppart, quantiteAllume,
                    SUM((UNIX_TIMESTAMP(IFNULL(dateOff, NOW())) - UNIX_TIMESTAMP(dateOn))) AS dureeAllume
                FROM TypeRessource NATURAL JOIN Consommer NATURAL JOIN TypeAppareil NATURAL JOIN Appareil NATURAL JOIN Piece NATURAL JOIN HistoriqueConsommation
                WHERE idAppartement = {$appartement['idAppartement']} AND dateOn >= '$dateDebut' AND dateOn <= '$dateFin'
                GROUP BY typeRessource";

        ### peut regarder une description de la ressource si survole son nom ? ###

        // exécution de la requête
        $dataConso = $bdd->query($reqConso);
        // si erreur
        if ($dataConso == NULL)
        die("Problème d'exécution de la requête de consommation : {$bdd->errorInfo()[2]}\n");

        echo "<table class=\"with-space\">
                <tbody>
                    <tr class=\"titre\">
                        <td>Ressource</td>
                        <td>Consommation par jour en moyenne</td>
                        <td>Consommation idéale par jour</td>
                        <td>Consommation critique par jour</td>
                        <td>Avis</td>
                    </tr>";

        foreach ($dataConso as $ligneConso) {
            // Consommation d'une ressource

            $consommation = ($ligneConso['dureeAllume'] / 3600) * $ligneConso['quantiteAllume'] / $heuresDureeLocation / $appartement['nbHabitants'];
            $libTypeRessource = $ligneConso['libTypeRessource'];
            $unite = "kWh / jour / habitant";
            
            echo "<tr>
                    <td>$libTypeRessource</td>
                    <td>" . str_replace(".", ",", round($consommation, 3)) . " $unite</td>
                    <td>" . $ligneConso['valIdealeConsoAppart'] . " $unite</td>
                    <td>" . $ligneConso['valCritiqueConsoAppart'] . " $unite</td>";

            if ($ligneConso['valIdealeConsoAppart']+5 >= $consommation) echo "<td class=\"vert\">C'est très bien!</td>";
            else if ($ligneConso['valCritiqueConsoAppart']-5 > $consommation) echo "<td class=\"orange\">C'est moyen</td>";
            else echo "<td class=\"rouge\">C'est mauvais!</td>";
            echo "</tr>";
        }
        
        echo "<tr class=\"space\"><td colspan=\"6\" class=\"ignore-border\">&nbsp;</td></tr>";

        
        // PRODUCTION de substances
        
        // requete pour la base
        $reqProd = "SELECT libTypeSubstance, valCritiqueProdAppart, valIdealeProdAppart, idAppareil, quantiteAllume,
                SUM((UNIX_TIMESTAMP(IFNULL(dateOff, NOW())) - UNIX_TIMESTAMP(dateOn))) AS dureeAllume
                FROM TypeSubstance NATURAL JOIN Produire NATURAL JOIN TypeAppareil NATURAL JOIN Appareil NATURAL JOIN Piece NATURAL JOIN HistoriqueConsommation
                WHERE idAppartement = {$appartement['idAppartement']} AND dateOn >= '$dateDebut' AND dateOn <= '$dateFin'
                GROUP BY typeSubstance";

        ### changer base de donnée pour avoir historique des on/off et pouvoir calculer le temps de marche ###
        ### peut regarder une description de la substance si survole son nom ? ###

        // exécution de la requête
        $dataProd = $bdd->query($reqProd);
        // si erreur
        if ($dataProd == NULL)
        die("Problème d'exécution de la requête de production : {$bdd->errorInfo()[2]}\n");

        echo "      <tr class=\"titre\">
                        <td>Substance nocive</td>
                        <td>Production par jour</td>
                        <td>Produciton idéale par jour</td>
                        <td>Production critique par jour</td>
                        <td>Avis</td>
                    </tr>";

        foreach ($dataProd as $ligneProd) {
            $heuresAllume = $ligneProd['dureeAllume'] / 3600;
    
            $production = $heuresAllume * $ligneProd['quantiteAllume'] / $heuresDureeLocation / $appartement['nbHabitants'];

            $unite = " kg/j";
            switch($ligneProd['libTypeSubstance']) {
                case "dioxyde de carbone":
                    $unite = " kg / jour / habitant";
                    break;
                case "chaleur":
                    $unite = " kJ / jour / habitant";
                    break;
            }

            echo "<tr>
                    <td>{$ligneProd['libTypeSubstance']}</td>
                    <td>" . str_replace(".", ",", round($production, 3)) . "$unite</td>
                    <td>" . $ligneProd['valIdealeProdAppart'] . $unite . "</td>
                    <td>" . $ligneProd['valCritiqueProdAppart'] . $unite . "</td>";

            if ($ligneProd['valIdealeProdAppart']+5 >= $production) echo "<td class=\"vert\">C'est très bien!</td>";
            else if ($ligneProd['valCritiqueProdAppart']-5 > $production) echo "<td class=\"orange\">C'est moyen</td>";
            else echo "<td class=\"rouge\">C'est mauvais!</td>";
            echo "</tr>";
        }
        echo "</tbody>
            </table>
            </div>";
    }
    ?>

    <?php
        if ($nbLignes == 0) {
            echo "<p>Vous n'avez pas d'appartement</p>";
        }
    ?>
 
 <?php require "../common/footer.php"; ?>
