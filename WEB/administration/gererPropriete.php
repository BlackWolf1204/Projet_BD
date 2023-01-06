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

    <a href="../Page_accueil/Page_accueil.php">Retour</a>

    <table>
        <tbody>
            <tr>
                <td>Immeuble</td>
                <td colspan = "2">Adresse (+nom)</td>
                <td>Isolation</td>
                <td colspan = "2">Date acquisition de la propriété</td>
                <td rowspan = "3">Modifier</td>
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
                <td>Locataire (Date Debut)</td>
                <td>Type appartement/maison</td>
                <td>Pièce(s)</td>
            </tr>
        </tbody>
    </table>

    <?php
    
    // requete pour la base
    $req = 'SELECT idPropriete, numeroRue, nomRue, codePostal, ville, degreIsolation, nomPropriete 
            FROM Propriete ';   //restreindre aux propriétés de l'utilisateur

    // exécution de la requête
    $data = $bdd->query($req);
    // si erreur
    if ($data == NULL)
    die("Problème d'exécution de la requête \n");
    
    foreach ($data as $ligne) {
        // requete pour la base
        $req2 = "SELECT numAppart, libTypeAppart, nomSecurite, DATE_FORMAT(datedebutprop, %d %b %Y)
        FROM (((Appartment NATURAL JOIN Proprietaire) NATURAL JOIN TypeAppartement) NATURAL JOIN TypeSecurite) NATURAL JOIN Locataire 
        WHERE idPropriete = $ligne->idPropriete";

        // exécution de la requête
        $data2 = $bdd->query($req2);
        // si erreur
        if ($data2 == NULL)
        die("Problème d'exécution de la requête \n");

        echo "<table>
                <tbody>
                    <tr>
                        <th>";

        $nbAppart = mysql_num_rows($data2);
        if ($nbAppart == 1) echo "Maison";
        else echo "Immeuble";
        echo "  </th>
                <th colspan = \"2\">$ligne->numeroRue $ligne->nomRue $ligne->codepostal $ligne->ville";
        if ($ligne->nomPropriete != NULL) echo"($ligne->nomPropriete)";
        echo "  </th>
                <th>$ligne->degreIsolation</th>
                <th>$ligne->datedebutprop</th>
                <th rowspan = \"$nbAppart\"><a href='../ajoutPropriete.php'>Modifier<a></th>
            </tr>";   //changer Modification pour garder en memoire l'id de la propriété a modifier
        
        foreach ($data2 as $ligne2) {
            echo "<tr>
                    <td>$ligne2->numAppart</td>
                    <td>$ligne2->nomSecurite</td>";

            // requete pour la base
            $req3 = "SELECT DATE_FORMAT(datedebutloc, %d %b %Y), nom, prenom
            FROM (Locataire NATURAL JOIN Utilisateur) NATURAL JOIN InfoPersonne
            WHERE idAppartement = $ligne->idAppartement AND dateFinLoc IS NULL";

            // exécution de la requête
            $data3 = $bdd->query($req3);
            // si erreur
            if ($data3 == NULL)
            die("Problème d'exécution de la requête \n");

            if (mysql_num_rows($data3) == 1) {
                foreach ($data3 as $ligne3) {
                    echo "<td>$ligne3->prenom $ligne3->nom ($ligne3->datedebutloc)</td>";
                }
            }
            else if (mysql_num_rows($data3) == 0) {
                echo "<td>Pas de locataire</td>";
            }
            else {
                echo "<td>Problème au niveau de la location de l'appartement</td>";
            }
            echo "  <td>$ligne->libTypeAppart</td>
                    <td>";
            
            // requete pour la base
            $req4 = "SELECT  libTypePiece
            FROM (Appartment NATURAL JOIN Piece) NATURAL JOIN TypePiece 
            WHERE idPropriete = $ligne->idPropriete";

            // exécution de la requête
            $data4 = $bdd->query($req4);
            // si erreur
            if ($data4 == NULL)
            die("Problème d'exécution de la requête \n");

            $i = 0;
            foreach ($data4 as $ligne4) {
                echo "$ligne4->libTypePiece";
                if ($i < mysql_num_rows($data4)) {
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
<!----------------------------------------------------------------
    <table style="width: 90%;">
    <tbody>
    <tr style = "background: skyblue">
    <td>Immeuble</td>
    <td colspan = "2">Adresse (+nom)</td>
    <td>Isolation</td>
    <td colspan = "2">Date acquisition de la propriété</td>
    <td rowspan = "3">Modifier</td>
    </tr>
    <tr style = "background: lightgrey">
    <td>Numéro appartement</td>
    <td>Type sécurité</td>
    <td>Locataire (Date de debut de location)</td>
    <td>Type appartement/maison</td>
    <td>Pièce(s)</td>
    </tr>
    <tr>
    <td>Numéro appartement</td>
    <td>Type sécurité</td>
    <td>Locataire (Date Debut)</td>
    <td>Type appartement/maison</td>
    <td>Pièce(s)</td>
    </tr>
    </tbody>
    </table>

---------------------------------------------------------------->
        </tbody>
    </table>
    <a href="ajoutPropriete.php">Ajouter propiété</a>
 </body>

 <?php require "../common/footer.php"; ?>