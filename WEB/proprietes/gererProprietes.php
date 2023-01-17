<?php
$ROOT = "../";
require_once("../common/main.php");
?>

<!DOCTYPE html>

 <html lang="fr">
 
 <head>
 
    <title>Page propriété</title>

    <style>
        tr.space > td {
            padding: 5px;
        }
    </style>

    <?php require "../common/header.php"; ?>

    <h2>Votre/Vos propriété(s)</h2>

    <a href="../Page_accueil/Page_accueil.php" class = "bouton-retour">Retour à l'accueil</a>
    <table class="with-space">
        <tbody>
            <tr class="titre">
                <td>Immeuble</td>
                <td colspan = "2">Adresse (nom)</td>
                <td>Niveau d'isolation</td>
                <td colspan = "1">Date d'acquisition de la propriété</td>
                <td rowspan = "2">Modifications</td>
            </tr>
            <tr>
                <td>Numéro appartement</td>
                <td>Type de sécurité</td>
                <td>Locataire (Date de début de la location)</td>
                <td>Type d'appartement/maison</td>
                <td>Pièce(s)</td>
            </tr>

    <?php
    
    // requete pour la base
    $req = 'SELECT numeroRue, nomRue, codePostal, nomVille, degreIsolation, nomPropriete , idPropriete, DATE(dateDebutProp) AS dateDProp
            FROM ProprieteAdresse NATURAL JOIN Proprietaire';
    
    if (!isset($estAdmin) || $estAdmin != true) {
        $req = "$req WHERE idPersonne = {$_SESSION['Id']}";
    }

    // exécution de la requête
    $dataProprietes = $bdd->query($req);
    // si erreur
    if ($dataProprietes == NULL) {
        die($bdd->errorInfo()[2] . "<br>Problème d'exécution de la requête \n");
    }
    
    foreach ($dataProprietes as $propriete) {
        echo "<tr class=\"space\"><td colspan=\"6\" class=\"ignore-border\">&nbsp;</td></tr>";

        // requete pour la base
        $reqApparts = "SELECT idAppartement, numAppart, libTypeAppart, nomSecurite
        FROM ((Appartement NATURAL JOIN TypeAppartement) NATURAL JOIN TypeSecurite)
        WHERE idPropriete = {$propriete['idPropriete']}";

        // exécution de la requête
        $dataAppartements = $bdd->query($reqApparts);
        if (!$dataAppartements) {
            die("Problème d'exécution de la requête des appartements.<br>{$bdd->errorInfo()[2]}<br>");
        }
        
        $nbAppart = $dataAppartements->rowCount();
        $rowspan = $nbAppart + 1;
        
        echo "
                    <tr class=\"titre\">
                        <td>";

        if ($nbAppart == 1) echo "Maison";
        else echo "Immeuble";
        echo "  </td>
                <td colspan = \"2\">".$propriete['numeroRue']." ".$propriete['nomRue']." ".$propriete['codePostal']." ".$propriete['nomVille'];
        if ($propriete['nomPropriete'] != NULL) echo " ({$propriete['nomPropriete']})";
        echo "  </td>
                <td>{$propriete['degreIsolation']}</td>
                <td>{$propriete['dateDProp']}</td>
                <td rowspan = \"$rowspan\"><a href='{$ROOT}proprietes/ajoutPropriete/ajoutPropriete.php'>Modifier<a></td>
            </tr>";   //changer Modification pour garder en memoire l'id de la propriété a modifier
        
        foreach ($dataAppartements as $appartement) {
            echo "<tr>
                    <td>{$appartement['numAppart']}</td>
                    <td>{$appartement['nomSecurite']}</td>";

            // requete pour la base
            $reqLocataire = "SELECT DATE(datedebutloc) AS dateDLoc, nom, prenom
            FROM (Locataire NATURAL JOIN Utilisateur) NATURAL JOIN InfoPersonne
            WHERE idAppartement = {$appartement['idAppartement']} AND dateFinLoc IS NULL";

            // exécution de la requête
            $dataLocataires = $bdd->query($reqLocataire);
            $nbLocataire = $dataLocataires->rowCount();
            // si erreur
            if ($dataLocataires == NULL)
            die("Problème d'exécution de la requête des locataires \n");

            if ($nbLocataire == 1) {
                $locataire = $dataLocataires->fetch();
                echo "<td>{$locataire['prenom']} {$locataire['nom']} ({$locataire['dateDLoc']})</td>";
            }
            else if ($nbLocataire == 0) {
                echo "<td>Pas de locataire</td>";
            }
            else {
                echo "<td>Problème au niveau de la location de l'appartement (plusieurs locataires)</td>";
            }
            echo "  <td>{$appartement['libTypeAppart']}</td>
                    <td>";
            
            // requete pour la base
            $reqPieces = "SELECT  libTypePiece
            FROM Piece NATURAL JOIN TypePiece 
            WHERE idAppartement = {$appartement['idAppartement']}";

            // exécution de la requête
            $dataPieces = $bdd->query($reqPieces);
            $nbPiece = $dataPieces->rowCount();
            
            // si erreur
            if ($dataPieces == NULL || $nbPiece == NULL)
            die("Problème d'exécution de la requête \n");

            $iPiece = 0;
            foreach ($dataPieces as $piece) {
                echo $piece['libTypePiece'];
                if ($iPiece < $nbPiece - 1) {
                    echo ", ";
                }
                $iPiece++;
            } // fin foreach pieces
            echo "</td>";
        } // fin foreach appartements

        echo "</tr>";

    } // fin foreach proprietes
    ?>
    
    </tbody>
    </table>
    <a href="../proprietes/ajoutPropriete/ajoutPropriete.php">Ajouter propiété</a>
 </body>

 <?php require "../common/footer.php"; ?>

</html>