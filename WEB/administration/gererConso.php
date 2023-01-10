<!DOCTYPE html>

 <html lang="fr">
 
 <head>
 
    <title>Page consomation</title>

    <?php require "../common/header.php"; ?>

    <h2>Votre consommation et production</h2>

    <a href="../Page_accueil/Page_accueil.php">Retour</a>

    <?php

    // requete pour la base
    $req = 'SELECT idAppartement, numAppart, numeroRue, nomRue, codePostal, ville, nomPropriete,
                    DATEDIFF(DATE(datefinprop),DATE(datedebutprop)) AS dayDebutFin,
                    DATEDIFF(DATE(NOW()),DATE(datedebutprop)) AS dayDebutCurrent
    FROM Appartement NATURAL JOIN Propriete NATURAL JOIN Proprietaire';   //restreindre aux appartements de l'utilisateur

    // exécution de la requête
    $data = $bdd->query($req);
    // si erreur
    if ($data == NULL)
    die("Problème d'exécution de la requête \n");

    foreach ($data as $ligne) {
        echo "<div class=\"appart\">
                <h3>";
        
        if ($ligne['numAppart'] != NULL) echo "Appartement {$ligne['numAppart']} ";
        if ($ligne['nomPropriete'] != NULL) {
            $nomPropriete = iconv('ISO-8859-1', 'UTF-8', $ligne['nomPropriete']);
            echo "$nomPropriete ";
        }
        echo "{$ligne['numeroRue']} {$ligne['nomRue']} {$ligne['codePostal']} {$ligne['ville']}</h3>";

        // requete pour la base
        $req2 = "SELECT idAppareil, libTypeRessource, valCritiqueConsoAppart, valIdealeConsoAppart, quantiteAllume, HOUR(CURRENT_TIME) AS hourCurrent
                FROM TypeRessource NATURAL JOIN Consommer NATURAL JOIN TypeAppareil NATURAL JOIN Appareil NATURAL JOIN Piece
                WHERE idAppartement = {$ligne['idAppartement']}
                GROUP BY libTypeRessource, valCritiqueConsoAppart, valIdealeConsoAppart";
                
        ### peut regarder une description de la ressource si survole son nom ? ###

        // exécution de la requête
        $data2 = $bdd->query($req2);
        // si erreur
        if ($data2 == NULL)
        die("Problème d'exécution de la requête \n");

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
            $req3 = "SELECT DAY(dateOff) AS dayOff, HOUR(TIME(dateOff)) AS hourOff, DAY(dateOn) AS dayOn, HOUR(TIME(dateOn)) AS hourOn
                    FROM HistoriqueConsommation NATURAL JOIN Appareil
                    WHERE idAppareil = {$ligne2['idAppareil']}";
    
            // exécution de la requête
            $data3 = $bdd->query($req3);
            // si erreur
            if ($data3 == NULL)
            die("Problème d'exécution de la requête \n");

            $somme = 0;
            $jour = 0;
    
            foreach ($data3 as $ligne3) {
                if ($ligne3['dayOff'] != NULL) {
                    $jour += ($ligne3['dayOff'] - $ligne3['dayOn'])*24;
                    $somme += ($ligne3['hourOff'] - $ligne3['hourOn']);
                }
                else 
                    $jour += ($ligne['dayCurrent'] - $ligne3['dayOn'])*24;
                    $somme += ($ligne2['hourCurrent'] - $ligne3['hourOn']);
            }
    
            $somme = ($somme+$jour)*$ligne2['quantiteAllume'];
            if ($ligne['dayDebutFin'] != NULL) {
                $somme = $somme/((int)$ligne['dayDebutFin']*24);
            }
            else {            
                $somme = $somme/((int)$ligne['dayDebutCurrent']*24);
            }
            $libTypeRessource = iconv('ISO-8859-1', 'UTF-8', $ligne2['libTypeRessource']);
            echo "<tr>
                    <th>$libTypeRessource</th>
                    <th>".round($somme,3)." k..../h</th>
                    <th>{$ligne2['valIdealeConsoAppart']}</th>
                    <th>{$ligne2['valCritiqueConsoAppart']}</th>";

            if ($ligne2['valIdealeConsoAppart']+5 >= $somme) echo "<th class=\"vert\">C'est très bien!</th>";
            else if ($ligne2['valCritiqueConsoAppart']-5 > $somme) echo "<th class=\"orange\">C'est moyen</th>";
            else echo "<th class=\"rouge\">C mauvais!</th>";
            echo "</tr>";
        }
        echo "</tbody>
            </table>";
        
        // requete pour la base
        $req2 = "SELECT libTypeSubstance, valCritiqueProdAppart, valIdealeProdAppart
                FROM TypeSubstance NATURAL JOIN Produire NATURAL JOIN TypeAppareil NATURAL JOIN Appareil NATURAL JOIN Piece NATURAL JOIN Appartement
                WHERE idAppartement = {$ligne['idAppartement']}
                GROUP BY libTypeSubstance, valCritiqueProdAppart, valIdealeProdAppart";

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
            $req3 = "SELECT DAY(dateOff) AS dayOff, HOUR(TIME(dateOff)) AS hourOff, DAY(dateOn) AS dayOn, HOUR(TIME(dateOn)) AS hourOn
                    FROM HistoriqueConsommation NATURAL JOIN Appareil
                    WHERE idAppareil = {$ligne2['idAppareil']}";
    
            // exécution de la requête
            $data3 = $bdd->query($req3);
            // si erreur
            if ($data3 == NULL)
            die("Problème d'exécution de la requête \n");
    
            $somme = 0;
            $jour = 0;
    
            foreach ($data3 as $ligne3) {
                if ($ligne3['dayOff'] != NULL) {
                    $jour += ($ligne3['dayOff'] - $ligne3['dayOn'])*24;
                    $somme += ($ligne3['hourOff'] - $ligne3['hourOn']);
                }
                else 
                    $jour += ($ligne['dayCurrent'] - $ligne3['dayOn'])*24;
                    $somme += ($ligne2['hourCurrent'] - $ligne3['hourOn']);
            }
    
            $somme = ($somme+$jour)*$ligne2['quantiteAllume'];
            if ($ligne['dayDebutFin'] != NULL) {
                $somme = $somme/((int)$ligne['dayDebutFin']*24);
            }
            else {            
                $somme = $somme/((int)$ligne['dayDebutCurrent']*24);
            }
            echo "<tr>
                    <th>{$ligne2['libTypeRessource']}</th>
                    <th>".round($somme,3)." k..../j</th>
                    <th>{$ligne2['valIdealeConsoAppart']}</th>
                    <th>{$ligne2['valCritiqueConsoAppart']}</th>";

            if ($ligne2['valIdealeProdAppart']+5 >= $somme) echo "<th class=\"vert\">C'est très bien!</th>";
            else if ($ligne2['valCritiqueProdAppart']-5 > $somme) echo "<th class=\"orange\">C'est moyen</th>";
            else echo "<th class=\"rouge\">C mauvais!</th>";
            echo "</tr>";
        }
        echo "</tbody>
            </table>
            </div>";
    }
    ?>
        </tbody>
    </table>
 </body>
 
 <?php require "../common/footer.php"; ?>

</html>