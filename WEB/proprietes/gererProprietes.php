<?php
$ROOT = "../";
$titre = "Page propriétés";
require "../common/header.php";
pageAccueilSiNonConnecte($estConnecte, $ROOT);
?>

    <h2>Votre/Vos propriété(s)</h2>

    <a href="../Page_accueil/Page_accueil.php" class = "bouton-retour">Retour à l'accueil</a>
    <table class="with-space">
        <tbody>
            <tr class="titre">
                <td>Immeuble</td>
                <td colspan = "2">Nom (Adresse)</td>
                <td>Niveau d'isolation</td>
                <td>Propriétaire (Date de début de la propriété)</td>
                <td rowspan = "2">Détails et<br>modifications</td>
            </tr>
            <tr>
                <td>Numéro appartement</td>
                <td>Type d'appartement/maison</td>
                <td>Pièce(s)</td>
                <td>Type de sécurité</td>
                <td>Locataire (Date de début de la location)</td>
            </tr>

    <?php
    
    // requete pour la base
    $req = 'SELECT numeroRue, nomRue, codePostal, nomVille, degreIsolation, nomPropriete, idPropriete,
                    DATE(dateDebutProp) AS dateDebutProp, DATE(dateFinProp) AS dateFinProp, idProprietaire, nomProprietaire, prenomProprietaire
            FROM ProprieteAdresse NATURAL JOIN DernierProprietaire';
    
    if (!isset($estAdmin) || $estAdmin != true) {
        $req = "$req WHERE idProprietaire = $sessionId";
    }

    $req = "$req ORDER BY codePostal, nomRue, numeroRue";

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
        WHERE idPropriete = {$propriete['idPropriete']}
        ORDER BY numAppart";

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

        $descriptionPropriete = adressePropriete($propriete);
        echo "  </td>
                <td colspan = \"2\">".$descriptionPropriete ."</td>
                <td>{$propriete['degreIsolation']}</td>";

        if ($propriete['dateDebutProp'] != NULL){
            $dateDebutProp = date("d/m/Y", strtotime($propriete['dateDebutProp']));
            if($propriete['dateFinProp'] == NULL) echo "<td>" . lienInfoPersonne($propriete['idProprietaire'], $propriete['nomProprietaire'], $propriete['prenomProprietaire'], $ROOT) . " ($dateDebutProp)</td>";
            else {
                $dateFinProp = date("d/m/Y", strtotime($propriete['dateFinProp']));
                echo "<td>Sans propriétaire depuis le $dateFinProp</td>";
            }
        }
        else echo "<td>Sans propriétaire</td>";

        echo "  <td rowspan = \"$rowspan\"><a href='{$ROOT}proprietes/detailsPropriete.php?idPropriete={$propriete['idPropriete']}'>Détails<a></td>
            </tr>";
        
        foreach ($dataAppartements as $appartement) {
            echo "<tr>
                    <td>N<sup>o</sup> {$appartement['numAppart']}</td>
                    <td>{$appartement['libTypeAppart']}</td>
                    <td>";
            
            // Afficher les pièces de l'appartement
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

            echo "<td>{$appartement['nomSecurite']}</td>";

            // Afficher le locataire de l'appartement
            // requete pour la base
            $reqLocataire = "SELECT DATE(datedebutloc) AS datedebutloc, DATE(datefinloc) AS datefinloc, idLocataire, nomLocataire, prenomLocataire
            FROM DernierLocataire
            WHERE idAppartement = {$appartement['idAppartement']}";

            // exécution de la requête
            $dataLocataires = $bdd->query($reqLocataire);
            if(!$dataLocataires) {
                die("Problème d'exécution de la requête des locataires.<br>{$bdd->errorInfo()[2]}<br>");
            }
            // si erreur
            if ($dataLocataires == NULL)
            die("Problème d'exécution de la requête des locataires \n");
            
            $locataire = $dataLocataires->fetch();
            if ($locataire && $locataire['datedebutloc'] != NULL) {
                $locataire['datedebutloc'] = date("d/m/Y", strtotime($locataire['datedebutloc']));
                if($locataire['datefinloc'] == NULL) echo "<td>" . lienInfoPersonne($locataire['idLocataire'], $locataire['nomLocataire'], $locataire['prenomLocataire'], $ROOT)." ({$locataire['datedebutloc']})</td>";
                else {
                    $locataire['datefinloc'] = date("d/m/Y", strtotime($locataire['datefinloc']));
                    echo "<td>Sans locataire depuis le {$locataire['datefinloc']}</td>";
                }
            }
            else echo "<td>Sans locataire</td>";

        } // fin foreach appartements

        echo "</tr>";

    } // fin foreach proprietes
    ?>
    
    </tbody>
    </table>
    <a href="../proprietes/ajoutPropriete/ajoutPropriete.php">Ajouter propiété</a>

 <?php require "../common/footer.php"; ?>
