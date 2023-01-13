<?php
$ROOT = "../";
require_once("../common/main.php");
?>

<!DOCTYPE html>

 <html lang="fr">
 
 <head>
 
    <title>Page appareil</title>

    <?php require "../common/header.php"; ?>

    <h2>Vos appareils</h2>

    <a href="../Page_accueil/Page_accueil.php">Retour</a>

    <?php
    
    // requete pour la base
    $req = 'SELECT idAppareil, idTypeAppareil, nomAppareil, libTypeAppareil 
            FROM Appareil NATURAL JOIN TypeAppareil';   //restreindre aux appareils de l'utilisateur
    
    ### peut regarder description de l'appareil si survole son nom ? ###

    // exécution de la requête
    $data = $bdd->query($req);
    // si erreur
    if ($data == NULL)
    die("Problème d'exécution de la requête \n");
    
    echo "<table>
            <tbody>
                <tr class=\"titre\">
                    <td>Status</td>
                    <td>Appareil</td>
                    <td>Type appareil</td>
                    <td>Ressource(s)/Substance(s) concernée(s)</td>
                    <td>Consommation/Production par heure</td>
                    <td></td>
                </tr>";

    foreach ($data as $ligne) {
        // requete pour la base : ressources consommées
        $req2 = "SELECT libTypeRessource, quantiteAllume
                FROM Consommer NATURAL JOIN TypeRessource
                WHERE idTypeAppareil = {$ligne['idTypeAppareil']}";   //quantiteAllume est la quantite par heure ?
        
        // requete pour la base : substances produites
        $req3 = "SELECT libTypeSubstance, quantiteAllume
                FROM Produire NATURAL JOIN TypeSubstance
                WHERE idTypeAppareil = {$ligne['idTypeAppareil']}";   //quantiteAllume est la quantite par heure ?

        $nbP = "SELECT COUNT(*) AS nbP
                FROM Produire
                WHERE idTypeAppareil = {$ligne['idTypeAppareil']}";
        
        $nbC = "SELECT COUNT(*) AS nbC
                FROM Consommer
                WHERE idTypeAppareil = {$ligne['idTypeAppareil']}";

        // exécution de la requête
        $data3 = $bdd->query($req3); // produire
        $data2 = $bdd->query($req2); // consommer
        $nbPL = $bdd->query($nbP);
        $nbCL = $bdd->query($nbC);
        // si erreur
        if ($data3 == NULL || $data2 == NULL || $nbPL ==  NULL || $nbCL == NULL)
        die("Problème d'exécution de la requête \n");

        foreach ($nbPL as $nbPLignes) {
                foreach ($nbCL as $nbCLignes) {
                        $nb = (int)$nbPLignes['nbP']+(int)$nbCLignes['nbC'];
                }
        }
        
        $numeroLigne = 0;
              
        foreach ($data2 as $ligne2) {
                $nomAppareil = $ligne['nomAppareil'];
                $libTypeAppareil = $ligne['libTypeAppareil'];
                echo "<tr>";
                if ($numeroLigne == 0) {
                        echo "<td rowspan = $nb>ON/OFF</td>
                        <td rowspan = $nb>$nomAppareil</td>
                        <td rowspan = $nb>$libTypeAppareil</td>";
                }
                $libTypeRessource = $ligne2['libTypeRessource'];
                echo "<td>$libTypeRessource</td>
                        <td>{$ligne2['quantiteAllume']} k../h</td>";
                if ($numeroLigne == 0) {
                        echo "<td rowspan = $nb><a href='../Page_accueil/Page_accueil.php'>Modification</a></td>";   //changer Modification pour garder en memoire l'id de l'appareil a modifier
                } 
                echo "</tr>";
                $numeroLigne++;
        }

        foreach ($data3 as $ligne3) {
                $nomAppareil = $ligne['nomAppareil'];
                $libTypeAppareil = $ligne['libTypeAppareil'];
                echo "<tr>";
                if ($numeroLigne == 0) {
                        echo "<td rowspan = $nb>ON/OFF</td>
                        <td rowspan = $nb>$nomAppareil</td>
                        <td rowspan = $nb>$libTypeAppareil</td>";
                }
                $libTypeSubstance = $ligne3['libTypeSubstance'];
                echo "<td>$libTypeSubstance</td>
                        <td>{$ligne3['quantiteAllume']} k../h</td>"; 
                if ($numeroLigne == 0) {
                        echo "<td rowspan = $nb><a href='../Page_accueil/Page_accueil.php'>Modification</a></td>";   //changer Modification pour garder en memoire l'id de l'appareil a modifier
                }
                echo "</tr>";
                $numeroLigne++; 
        }
    }
    echo "</tbody>
        </table>";
    ?>
<!----------------------------------------------------------------
<tr>
        <th>appareil numero 1</th>
        <th>type de l'appareil</th>
        <th>ON/OFF</th>
        <th><a href='../Page_accueil/Page_accueil.php'>Modification<a></th>
</tr>
<tr>
        <th></th>
        <th></th>
        <th>Ressource</th>
        <th>quantite Ressource</th>
</tr>
<tr>
        <th></th>
        <th></th>
        <th>Ressource</th>
        <th>quantite Ressource</th>
</tr>
<tr>
        <th></th>
        <th></th>
        <th>substance</th>
        <th>quantite Substance</th>
</tr>
<tr>
        <th></th>
        <th></th>
        <th>substance</th>
        <th>quantite Substance</th>
</tr>
---------------------------------------------------------------->
        </tbody>
    </table>
    <a href="../Page_accueil/Page_accueil.php">Ajouter appareil</a>
 </body>
 
 <?php require "../common/footer.php"; ?>

</html>