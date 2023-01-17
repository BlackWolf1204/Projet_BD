<!DOCTYPE html>

 <html lang="fr">
 
 <head>
 
    <title>Page consomation</title>

    <?php require "../common/header.php"; ?>

    <h2>Votre consommation et production</h2>

    <a href="../Page_accueil/Page_accueil.php" class = "bouton-retour">Retour à l'accueil</a>

    <?php

    // requete pour la base
    $reqApparts = 'SELECT idAppartement, numAppart, numeroRue, nomRue, codePostal, nomVille, nomPropriete,
                    DATE(datefinprop) AS datefinprop, DATE(datedebutprop) AS datedebutprop,
                    (UNIX_TIMESTAMP(datefinprop) - UNIX_TIMESTAMP(datedebutprop)) AS tempsDureeLocation,
                    (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(datedebutprop)) AS tempsDepuisDebutLocation
            FROM Appartement NATURAL JOIN ProprieteAdresse NATURAL JOIN Proprietaire';

    if (!isset($estAdmin) || $estAdmin != true) {
        $reqApparts = "$reqApparts WHERE idPersonne = {$_SESSION['Id']}";
    }

    // exécution de la requête
    $dataApparts = $bdd->query($reqApparts);
    // si erreur
    if ($dataApparts == NULL)
    die("Problème d'exécution de la requête des appartements : {$bdd->errorInfo()[2]} \n");

    $timestampNow = time();

    $nbLignes = 0;
    foreach ($dataApparts as $appartement) {
        $nbLignes++;

        // La durée de la location depuis le début de la location jusqu'à la fin de la location (ou jusqu'à maintenant) en heures
        $heuresDureeLocation = 0;
        if ($appartement['tempsDureeLocation'] != NULL) {
            $heuresDureeLocation = $appartement['tempsDureeLocation'] / 3600;
        }
        else {
            $heuresDureeLocation = $appartement['tempsDepuisDebutLocation'] / 3600;
        }

        $textPeriodeLocation = "";
        if($appartement['tempsDureeLocation'] != NULL) {
            $textPeriodeLocation = "du {$appartement['datedebutprop']} au {$appartement['datefinprop']}";
        }
        else {
            $textPeriodeLocation = "du {$appartement['datedebutprop']} au {$timestampNow}";
        }

        echo "<div class=\"appart\">
                <h3>";
        
        if ($appartement['numAppart'] != NULL) echo "Appartement {$appartement['numAppart']} - ";
        echo adressePropriete($appartement) . "</h3>";

        echo "<p>Données sur la période $textPeriodeLocation</p>";

        // CONSOMMATION de ressources

        // requete pour la base
        $reqConso = "SELECT idAppareil, libTypeRessource, valCritiqueConsoAppart, valIdealeConsoAppart, quantiteAllume,
                    SUM((UNIX_TIMESTAMP(IFNULL(dateOff, NOW())) - UNIX_TIMESTAMP(dateOn))) AS dureeAllume
                FROM TypeRessource NATURAL JOIN Consommer NATURAL JOIN TypeAppareil NATURAL JOIN Appareil NATURAL JOIN Piece NATURAL JOIN HistoriqueConsommation
                WHERE idAppartement = {$appartement['idAppartement']} AND dateOn >= '{$appartement['datedebutprop']}' AND dateOn <= '{$appartement['datefinprop']}'
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

            $consommation = ($ligneConso['dureeAllume'] / 3600) * $ligneConso['quantiteAllume'] / $heuresDureeLocation;
            $libTypeRessource = $ligneConso['libTypeRessource'];
            
            echo "<tr>
                    <td>$libTypeRessource</td>
                    <td>" . $consommation = str_replace(".", ",", round($consommation, 3)) . " kWh/j</td>
                    <td>{$ligneConso['valIdealeConsoAppart']} kWh/j</td>
                    <td>{$ligneConso['valCritiqueConsoAppart']} kWh/j</td>";

            if ($ligneConso['valIdealeConsoAppart']+5 >= $consommation) echo "<td class=\"vert\">C'est très bien!</td>";
            else if ($ligneConso['valCritiqueConsoAppart']-5 > $consommation) echo "<td class=\"orange\">C'est moyen</td>";
            else echo "<td class=\"rouge\">C mauvais!</td>";
            echo "</tr>";
        }
        
        echo "<tr class=\"space\"><td colspan=\"6\" class=\"ignore-border\">&nbsp;</td></tr>";

        
        // PRODUCTION de substances
        
        // requete pour la base
        $reqProd = "SELECT libTypeSubstance, valCritiqueProdAppart, valIdealeProdAppart, idAppareil, quantiteAllume,
                SUM((UNIX_TIMESTAMP(IFNULL(dateOff, NOW())) - UNIX_TIMESTAMP(dateOn))) AS dureeAllume
                FROM TypeSubstance NATURAL JOIN Produire NATURAL JOIN TypeAppareil NATURAL JOIN Appareil NATURAL JOIN Piece NATURAL JOIN HistoriqueConsommation
                WHERE idAppartement = {$appartement['idAppartement']} AND dateOn >= '{$appartement['datedebutprop']}' AND dateOn <= '{$appartement['datefinprop']}'
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
    
            $production = $heuresAllume * $ligneProd['quantiteAllume'] / $heuresDureeLocation;
            echo "<tr>
                    <td>{$ligneProd['libTypeSubstance']}</td>
                    <td>" . $consommation = str_replace(".", ",", round($production, 3)) . " kWh/j</td>
                    <td>{$ligneProd['valIdealeProdAppart']} kWh/j</td>
                    <td>{$ligneProd['valCritiqueProdAppart']} kWh/j</td>";

            if ($ligneProd['valIdealeProdAppart']+5 >= $production) echo "<td class=\"vert\">C'est très bien!</td>";
            else if ($ligneProd['valCritiqueProdAppart']-5 > $production) echo "<td class=\"orange\">C'est moyen</td>";
            else echo "<td class=\"rouge\">C mauvais!</td>";
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
 </body>
 
 <?php require "../common/footer.php"; ?>

</html>