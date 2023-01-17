<?php
$ROOT = "../";
require_once("../common/main.php");
?>

<!DOCTYPE html>

 <html lang="fr">
 
 <head>
 
    <title>Page propriété</title>

    <?php require "../common/header.php"; ?>

    <h2>Votre/Vos propriété(s)</h2>

    <a href="../Page_accueil/Page_accueil.php" class = "bouton-retour">Retour à l'accueil</a>
    <table>
        <tbody>
            <tr class="titre">
                <td>Immeuble</td>
                <td colspan = "2">Adresse (+nom)</td>
                <td>Isolation</td>
                <td colspan = "2">Date acquisition de la propriété</td>
                <td rowspan = "3">Modifications</td>
            </tr>
            <tr>
                <td>Numéro appartement</td>
                <td>Type sécurité</td>
                <td>Locataire (Date de debut de location)</td>
                <td>Type appartement/maison</td>
                <td>Pièce(s)</td>
            </tr>
            <tr>
                <td>Numéro appartement</td>
                <td>Type sécurité</td>
                <td>Locataire (Date de début de location)</td>
                <td>Type appartement/maison</td>
                <td>Pièce(s)</td>
            </tr>
        </tbody>
    </table>

    <?php
    
    // requete pour la base
    $req = 'SELECT numeroRue, nomRue, codePostal, nomVille, degreIsolation, nomPropriete , idPropriete, DATE(dateDebutProp) AS dateDProp
            FROM ProprieteAdresse NATURAL JOIN Proprietaire';
    
    if (!isset($estAdmin) || $estAdmin != true) {
        $req = "$req WHERE idPersonne = {$_SESSION['Id']}";
    }

    // exécution de la requête
    $data = $bdd->query($req);
    // si erreur
    if ($data == NULL) {
        die($bdd->errorInfo()[2] . "<br>Problème d'exécution de la requête \n");
    }
    
    foreach ($data as $ligne) {
        // requete pour la base
        $req2 = "SELECT idAppartement, numAppart, libTypeAppart, nomSecurite
        FROM (((Appartement NATURAL JOIN Propriete) NATURAL JOIN TypeAppartement) NATURAL JOIN TypeSecurite) NATURAL JOIN Locataire 
        WHERE idPropriete =".$ligne['idPropriete'];

        $nb = "SELECT COUNT(*) AS nbLigne
        FROM Appartement
        WHERE idPropriete = {$ligne['idPropriete']}";

        // exécution de la requête
        $data2 = $bdd->query($req2);
        $nbL = $bdd->query($nb);
        // si erreur
        if ($data2 == NULL || $nbL == NULL)
        die("Problème d'exécution de la requête \n");

        foreach($nbL as $l) {
            $nbAppart = $l['nbLigne']+1;
        }

        echo "<table>
                <tbody>
                    <tr class=\"titre\">
                        <td>";

        if ($nbAppart == 1) echo "Maison";
        else echo "Immeuble";
        echo "  </td>
                <td colspan = \"2\">".$ligne['numeroRue']." ".$ligne['nomRue']." ".$ligne['codePostal']." ".$ligne['nomVille'];
        if ($ligne['nomPropriete'] != NULL) echo " ({$ligne['nomPropriete']})";
        echo "  </td>
                <td>{$ligne['degreIsolation']}</td>
                <td>{$ligne['dateDProp']}</td>
                <td rowspan = \"$nbAppart\"><a href='{$ROOT}proprietes/ajoutPropriete/ajoutPropriete.php'>Modifier<a></td>
            </tr>";   //changer Modification pour garder en memoire l'id de la propriété a modifier
        
        foreach ($data2 as $ligne2) {
            echo "<tr>
                    <td>{$ligne2['numAppart']}</td>
                    <td>{$ligne2['nomSecurite']}</td>";

            // requete pour la base
            $req3 = "SELECT DATE(datedebutloc) AS dateDLoc, nom, prenom
            FROM (Locataire NATURAL JOIN Utilisateur) NATURAL JOIN InfoPersonne
            WHERE idAppartement = {$ligne2['idAppartement']} AND dateFinLoc IS NULL";

            $nb = "SELECT COUNT(*) AS nbLignes
            FROM Locataire
            WHERE idAppartement = {$ligne2['idAppartement']} AND dateFinLoc IS NULL";

            // exécution de la requête
            $data3 = $bdd->query($req3);
            $nbL = $bdd->query($nb);
            // si erreur
            if ($data3 == NULL || $nbL == NULL)
            die("Problème d'exécution de la requête \n");

            foreach($nbL as $l) {
                $nbLocataire = $l['nbLignes'];
            }

            if ($nbLocataire == 1) {
                foreach ($data3 as $ligne3) {
                    echo "<td>{$ligne3['prenom']} {$ligne3['nom']} ({$ligne3['dateDLoc']})</td>";
                }
            }
            else if ($nbLocataire == 0) {
                echo "<td>Pas de locataire</td>";
            }
            else {
                echo "<td>Problème au niveau de la location de l'appartement</td>";
            }
            echo "  <td>{$ligne2['libTypeAppart']}</td>
                    <td>";
            
            // requete pour la base
            $req4 = "SELECT  libTypePiece
            FROM Piece NATURAL JOIN TypePiece 
            WHERE idAppartement = {$ligne2['idAppartement']}";

            $nb = "SELECT COUNT(*) AS nbLignes
            FROM Piece
            WHERE idAppartement = {$ligne2['idAppartement']}";

            // exécution de la requête
            $data4 = $bdd->query($req4);
            $nbL = $bdd->query($nb);
            // si erreur
            if ($data4 == NULL || $nbL == NULL)
            die("Problème d'exécution de la requête \n");

            foreach($nbL as $l) {
                $nbPiece = $l['nbLignes'];
            }

            $i = 0;
            foreach ($data4 as $ligne4) {
                echo $ligne4['libTypePiece'];
                if ($i < $nbPiece) {
                    echo ", ";
                }
                $i++;
            }
            echo "</td>";
        }



        echo "</tbody>
            </table>";
    }
    ?>
    
    </tbody>
    </table>
    <a href="../proprietes/ajoutPropriete/ajoutPropriete.php">Ajouter propiété</a>
 </body>

 <?php require "../common/footer.php"; ?>

</html>