<!DOCTYPE html>

 <html lang="fr">
 
 <head>
 
    <title>Page consomation</title>

    <?php require "../common/header.php"; ?>

    <h2>Votre consommation et production</h2>

    <a href="../Page_accueil/Page_accueil.php">Retour</a>

    <?php

    // requete pour la base
    $req = 'SELECT idAppartement, numAppart, numeroRue, nomRue, codePostal, ville, nomPropriete, TIME_TO_SEC(datedebutprop) AS debutProp, TIME_TO_SEC(datefinprop) AS finProp
    FROM Appartement NATURAL JOIN Propriete NATURAL JOIN Proprietaire';   //restreindre aux appartements de l'utilisateur

    // exécution de la requête
    $data = $bdd->query($req);
    // si erreur
    if ($data == NULL)
    die("Problème d'exécution de la requête \n");

    foreach ($data as $ligne) {
        echo "<div class=\"appart\">
                <h3>";
        
        if ($ligne->numAppart != NULL) echo "$ligne->numAppart";
        if ($ligne->nomPropriete != NULL) echo "$ligne->nomPropriete";
        else echo "$ligne->numeroRue $ligne->nomRue $ligne->codePostal $ligne->ville";
        echo "</h3>";

        // requete pour la base
        $req2 = "SELECT libTypeRessource, valCritiqueConsoAppart, valIdealConsoAppart, quantiteAllume, TIME_TO_SEC(CURRENT_TIME) AS dCurrent
                FROM TypeRessouce NATURAL JOIN Consommer NATURAL JOIN TypeApparail NATURAL JOIN Appareil NATURAL JOIN Piece NATURAL JOIN Appartement
                GROUP BY libTypeRessource, valCritiqueConsoAppart, valIdealConsoAppart
                HAVING idAppartement = $ligne->idAppartement";
                
        ### peut regarder une description de la ressource si survole son nom ? ###

        // exécution de la requête
        $data2 = $bdd->query($req2);
        // si erreur
        if ($data2 == NULL)
        die("Problème d'exécution de la requête \n");

        $req3 = "SELECT TIME_TO_SEC(dateOff) AS dOff, TIME_TO_SEC(dateOn) AS dOn
                FROM Historique NATURAL JOIN Appareil
                WHERE idAppareil = $ligne->idAppareil";

        // exécution de la requête
        $data3 = $bdd->query($req3);
        // si erreur
        if ($data3 == NULL)
        die("Problème d'exécution de la requête \n");

        $somme = 0;

        foreach ($data3 as $ligne3) {
            if ($ligne3->dOff != NULL)
                $somme = $ligne3->dOff - $ligne3->dOn;
            else 
                $somme = $ligne2->dCurrent - $ligne3->dOn;
        }

        $somme = $somme*$ligne2->quantiteAllume/(60*60);
        if ($ligne->finProp != NULL) {
            $somme = $somme/((int)($ligne->finProp/(60*60*24))-(int)($ligne->debutProp/(60*60*24)))
        }
        else {            
            $somme = $somme/((int)($ligne->finProp/(60*60*24))-(int)($ligne->debutProp/(60*60*24)))
        }

        echo "<table>
                <thead>
                    <tr>
                        <th>Ressource</th>
                        <th>Votre consommation par jour</th>
                        <th>Consommation idéale par jour</th>
                        <th>Consommation critique par jour</th>
                        <th>Avis</th>
                    </tr>
                </thead>
                <tbody>";

        foreach ($data2 as $ligne2) {
            echo "<tr>
                    <th>$ligne2->libTypeRessource</th>
                    <th>$somme k..../j</th>
                    <th>$ligne2->valIdealConsoAppart</th>
                    <th>$ligne2->valCritiqueConsoAppart</th>";

            if ($ligne2->valIdealConsoAppart+5 >= $ligne2->sumQuantite) echo "<th class=\"vert\">C'est très bien!</th>";
            else if ($ligne2->valCritiqueConsoAppart-5 > $ligne2->sumQuantite) echo "<th class=\"orange\">C'est moyen</th>";
            else echo "<th class=\"rouge\">C mauvais!</th>";
            echo "</tr>";
        }
        echo "</tbody>
            </table>";
        
        // requete pour la base
        $req2 = "SELECT libTypeSubstance, valCritiqueProdAppart, valIdealProdAppart, SUM(quantiteAllume) AS sumQuantite
                FROM TypeSubstance NATURAL JOIN Produire NATURAL JOIN TypeApparail NATURAL JOIN Appareil NATURAL JOIN Piece NATURAL JOIN Appartement
                GROUP BY libTypeRessource, valCritiqueConsoAppart, valIdealProdAppart
                HAVING idAppartement = $ligne->idAppartement";

        ### changer base de donnée pour avoir historique des on/off et pouvoir calculer le temps de marche ###
        ### peut regarder une description de la substance si survole son nom ? ###

        // exécution de la requête
        $dat2a = $bdd->query($req2);
        // si erreur
        if ($data2 == NULL)
        die("Problème d'exécution de la requête \n");

        echo "<table>
                <thead>
                    <tr>
                        <th>Substance(s) nocive(s)</th>
                        <th>Votre production par jour</th>
                        <th>Produciton idéale par jour</th>
                        <th>Production critique par jour</th>
                        <th>Avis</th>
                    </tr>
                </thead>
                <tbody>";

        foreach ($data2 as $ligne2) {
            echo "<tr>
                    <th>$ligne2->libTypeSubstance</th>
                    <th>A calculer</th>
                    <th>$ligne2->valIdealProdAppart</th>
                    <th>$ligne2->valCritiquePrdoAppart</th>";

            if ($ligne2->valIdealProdAppart+5 >= $ligne2->sumQuantite) echo "<th class=\"vert\">C'est très bien!</th>";
            else if ($ligne2->valCritiqueProdAppart-5 > $ligne2->sumQuantite) echo "<th class=\"orange\">C'est moyen</th>";
            else echo "<th class=\"rouge\">C mauvais!</th>";
            echo "</tr>";
        }
        echo "</tbody>
            </table>";
    }
    ?>
        </tbody>
    </table>
 </body>
 
 <?php require "../common/footer.php"; ?>

</html>