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
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Appareil</th>
                    <th>Type appareil</th>
                    <th>Ressource(s)/Substance(s) concernée(s)</th>
                    <th>Consommation/Production par heure</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>";
            
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
                        $nb = (int)$nbPLignes['nbP']+(int)$nbCLignes['nbC']+1;
                }
        }
        $nomAppareil = iconv('ISO-8859-1', 'UTF-8', $ligne['nomAppareil']);
        $libTypeAppareil = iconv('ISO-8859-1', 'UTF-8', $ligne['libTypeAppareil']);
        echo "<tr>
                <th rowspan = $nb>ON/OFF</th>
                <th rowspan = $nb>$nomAppareil</th>
                <th rowspan = $nb>$libTypeAppareil</th>
                <th></th>
                <th></th>
                <th rowspan = $nb><a href='../Page_accueil/Page_accueil.php'>Modification</a></th>
              </tr>";   //changer Modification pour garder en memoire l'id de l'appareil a modifier
        
        foreach ($data2 as $ligne2) {
                $libTypeRessource = iconv('ISO-8859-1', 'UTF-8', $ligne2['libTypeRessource']);
                echo "<tr>
                        <th>$libTypeRessource</th>
                        <th>{$ligne2['quantiteAllume']} kW</th>
                      </tr>";       
        }

        foreach ($data3 as $ligne3) {
                $libTypeSubstance = iconv('ISO-8859-1', 'UTF-8', $ligne3['libTypeSubstance']);
                echo "<tr>
                        <th>$libTypeSubstance</th>
                        <th>{$ligne3['quantiteAllume']} kW</th>
                      </tr>";       
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