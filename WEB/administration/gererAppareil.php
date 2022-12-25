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

    <?php
    
    // requete pour la base
    $req = 'SELECT idType, nomAppareil, libTypeAppareil 
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
                    <th>Appareil</th>
                    <th>Type appareil</th>
                    <th>Ressource(s)/Substance(s) consommée(s)</th>
                    <th>Consommation/Production par heure</th>
                </tr>
            </thead>
            <tbody>";
    foreach ($data as $ligne) {
        echo "<tr>
                <th>$ligne->nomAppareil</th>
                <th>$ligne->libTypeAppareil</th>
                <th>ON/OFF</th>
                <th><a href='../Page_accueil/Page_accueil.html'>Modification<a></th>
              </tr>";   //changer Modification pour garder en memoire l'id de l'appareil a modifier
        
        // requete pour la base
        $req2 = "SELECT libTypeRessource, quantiteAllume
                FROM TypeAppareil NATURAL JOIN Consommer NATURAL JOIN TypeRessource
                WHERE idType = $ligne->idTypeAppareil";   //quantiteAllume est la quantite par heure ?

        // exécution de la requête
        $data2 = $bdd->query($req2);
        // si erreur
        if ($data2 == NULL)
        die("Problème d'exécution de la requête \n");

        foreach ($data2 as $ligne2) {
                echo "<tr>
                        <th></th>
                        <th></th>
                        <th>$ligne2->libTypeRessource</th>
                        <th>$ligne2->quantiteAllume</th>
                      </tr>";       
        }

        // requete pour la base
        $req3 = "SELECT libTypeSubstance, quantiteAllume
                FROM TypeAppareil NATURAL JOIN Produire NATURAL JOIN TypeSubstance
                WHERE idType = $ligne->idTypeAppareil";   //quantiteAllume est la quantite par heure ?

        // exécution de la requête
        $data3 = $bdd->query($req3);
        // si erreur
        if ($data3 == NULL)
        die("Problème d'exécution de la requête \n");

        foreach ($data as $ligne3) {
                echo "<tr>
                        <th></th>
                        <th></th>
                        <th>$ligne3->libTypeSubstance</th>
                        <th>$ligne3->quantiteAllume</th>
                      </tr>";       
        }
    }
    ?>
<!----------------------------------------------------------------
    <tr>
                <th>appareil numero 1</th>
                <th>type de l'appareil</th>
                <th>ON/OFF</th>
                <th><a href='../Page_accueil/Page_accueil.html'>Modification<a></th>
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