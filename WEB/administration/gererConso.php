<!DOCTYPE html>

 <html lang="fr">
 
 <head>
 
    <title>Page consomation</title>

    <?php require "../common/header.php"; ?>

    <h2>Votre consommation et production</h2>

    <a href="../Page_accueil/Page_accueil.php">Retour</a>

    <?php

    // requete pour la base
    $req = 'SELECT idAppartement, numAppart, numeroRue, nomRue, codePostal, nomVille, nomPropriete,
                    DATEDIFF(DATE(datefinprop),DATE(datedebutprop)) AS dayDebutFin,
                    DATEDIFF(DATE(NOW()),DATE(datedebutprop)) AS dayDebutCurrent
    FROM Appartement NATURAL JOIN ProprieteAdresse NATURAL JOIN Proprietaire';   //restreindre aux appartements de l'utilisateur

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
            $nomPropriete = $ligne['nomPropriete'];
            echo "$nomPropriete ";
        }
        echo "{$ligne['numeroRue']} {$ligne['nomRue']} {$ligne['codePostal']} {$ligne['nomVille']}</h3>";

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
                <tbody>
                    <tr class=\"titre\">
                        <td>Ressource</td>
                        <td>Votre consommation par jour</td>
                        <td>Consommation idéale par jour</td>
                        <td>Consommation critique par jour</td>
                        <td>Avis</td>
                    </tr>";

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
                    $jour += ($ligne['dayDebutCurrent'] - $ligne3['dayOn'])*24;
                    $somme += ($ligne2['hourCurrent'] - $ligne3['hourOn']);
            }
    
            $somme = ($somme+$jour)*$ligne2['quantiteAllume'];
            if ($ligne['dayDebutFin'] != NULL) {
                $somme = $somme/((int)$ligne['dayDebutFin']*24);
            }
            else {            
                $somme = $somme/((int)$ligne['dayDebutCurrent']*24);
            }
            $libTypeRessource = $ligne2['libTypeRessource'];
            echo "<tr>
                    <td>$libTypeRessource</td>
                    <td>".round($somme,3)." kW</td>
                    <td>{$ligne2['valIdealeConsoAppart']}</td>
                    <td>{$ligne2['valCritiqueConsoAppart']}</td>";

            if ($ligne2['valIdealeConsoAppart']+5 >= $somme) echo "<td class=\"vert\">C'est très bien!</td>";
            else if ($ligne2['valCritiqueConsoAppart']-5 > $somme) echo "<td class=\"orange\">C'est moyen</td>";
            else echo "<td class=\"rouge\">C mauvais!</td>";
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
                <tbody>
                    <tr class=\"titre\">
                        <td>Substance(s) nocive(s)</td>
                        <td>Votre production par jour</td>
                        <td>Produciton idéale par jour</td>
                        <td>Production critique par jour</td>
                        <td>Avis</td>
                    </tr>";

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
                    <td>{$ligne2['libTypeRessource']}</td>
                    <td>".round($somme,3)." k..../j</td>
                    <td>{$ligne2['valIdealeConsoAppart']}</td>
                    <td>{$ligne2['valCritiqueConsoAppart']}</td>";

            if ($ligne2['valIdealeProdAppart']+5 >= $somme) echo "<td class=\"vert\">C'est très bien!</td>";
            else if ($ligne2['valCritiqueProdAppart']-5 > $somme) echo "<td class=\"orange\">C'est moyen</td>";
            else echo "<td class=\"rouge\">C mauvais!</td>";
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