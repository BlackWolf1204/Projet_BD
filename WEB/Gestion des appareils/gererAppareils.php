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

    <a href="../Page_accueil/Page_accueil.php" class = "bouton-retour">Retour à l'accueil</a>

    <?php
    pageAccueilSiNonConnecte($ROOT);
    
    // requete pour la base
    $req = "SELECT idAppareil, idTypeAppareil, nomAppareil, libTypeAppareil
            FROM Appareil NATURAL JOIN TypeAppareil";
    
    if (!isset($estAdmin) || $estAdmin != true) {
        $req = $req." NATURAL JOIN (SELECT idPiece
                                FROM Piece NATURAL JOIN Appartement NATURAL JOIN Propriete NATURAL JOIN Proprietaire
                                WHERE idPersonne = $sessionId) AS PiecesUtilisateur";
    }

    // exécution de la requête
    $data = $bdd->query($req);
    // si erreur
    if ($data == NULL)
    die("Problème d'exécution de la requête des appareils<br>{$bdd->errorInfo()[2]}");
    
    echo "<table>
            <tbody>
                <tr class=\"titre\">
                    <td>État</td>
                    <td>Appareil</td>
                    <td>Type appareil</td>
                    <td>Ressource(s)/Substance(s) concernée(s)</td>
                    <td>Consommation/Production par heure</td>
                    <td></td>
                </tr>";

    foreach ($data as $ligne) {
        $idAppareil = $ligne['idAppareil'];
        $idTypeAppareil = $ligne['idTypeAppareil'];

        // requete pour la base : ressources consommées
        $req2 = "SELECT libTypeRessource, quantiteAllume
                FROM Consommer NATURAL JOIN TypeRessource
                WHERE idTypeAppareil = {$idTypeAppareil}";
        
        // requete pour la base : substances produites
        $req3 = "SELECT libTypeSubstance, quantiteAllume
                FROM Produire NATURAL JOIN TypeSubstance
                WHERE idTypeAppareil = {$idTypeAppareil}";

        $nbP = "SELECT COUNT(*) AS nbP
                FROM Produire
                WHERE idTypeAppareil = {$idTypeAppareil}";
        
        $nbC = "SELECT COUNT(*) AS nbC
                FROM Consommer
                WHERE idTypeAppareil = {$idTypeAppareil}";

        // exécution de la requête
        $data3 = $bdd->query($req3); // produire
        $data2 = $bdd->query($req2); // consommer
        $nbPL = $bdd->query($nbP);
        $nbCL = $bdd->query($nbC);
        // si erreur
        if ($data3 == NULL || $data2 == NULL || $nbPL ==  NULL || $nbCL == NULL)
        die("Problème d'exécution des requêtes \n");

        foreach ($nbPL as $nbPLignes) {
                foreach ($nbCL as $nbCLignes) {
                        $nb = (int)$nbPLignes['nbP']+(int)$nbCLignes['nbC'];
                }
        }

        $estAllume = false;
        $req = "SELECT COUNT(*) FROM HistoriqueConsommation WHERE idAppareil = $idAppareil AND dateOff IS NULL";
        $dataAllume = $bdd->query($req);
        $estAllume = $dataAllume->fetchColumn() > 0 ? 1 : 0;
        $contenuEtatAppareil = "<span class=\"bouton-ON-OFF\" idAppareil=$idAppareil etat=\"" . ($estAllume ? "ON" : "OFF") . "\" onclick=\"allumerEteindre(this)\"><span class=\"ON\">ON</span><span class=\"OFF\">OFF</span></span>";
        
        $numeroLigne = 0;
              
        foreach ($data2 as $ligne2) {
                $nomAppareil = $ligne['nomAppareil'];
                $libTypeAppareil = $ligne['libTypeAppareil'];
                echo "<tr>";
                if ($numeroLigne == 0) {
                        echo "<td rowspan = $nb>$contenuEtatAppareil</td>
                        <td rowspan = $nb>$nomAppareil</td>
                        <td rowspan = $nb>$libTypeAppareil</td>";
                }
                $libTypeRessource = $ligne2['libTypeRessource'];
                echo "<td>$libTypeRessource</td>
                        <td>{$ligne2['quantiteAllume']} k../h</td>";
                if ($numeroLigne == 0) {
                        echo "<td rowspan = $nb><a href='detailsAppareil.php?idAppareil=$idAppareil'>Détails</a></td>";
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
                        echo "<td rowspan = $nb><a href='detailsAppareil.php?idAppareil=$idAppareil'>Détails</a></td>";
                }
                echo "</tr>";
                $numeroLigne++;
        }
    }
    echo "</tbody>
        </table>";
    ?>
        </tbody>
    </table>
    <a href="../Page_accueil/Page_accueil.php">Ajouter appareil</a>
 
<?php require "../common/footer.php"; ?>

<script>
    function allumerEteindre(divSource) {
        // Envoyer une requête en GET à allumerEteindre.php
        var idAppareil = divSource.getAttribute("idAppareil");
        var estAllume = divSource.getAttribute("etat") == "ON";

        var nouvelEtat = !estAllume;
        var xhr = new XMLHttpRequest();
        xhr.open("GET", `allumerEteindre.php?idAppareil=${idAppareil}&etat=${nouvelEtat}`);
        xhr.onload = () => {
            if (xhr.status === 200) {
                const reponse = JSON.parse(xhr.responseText);
                estAllume = reponse.etat;
                divSource.setAttribute("etat", `${estAllume ? "ON" : "OFF"}`);
                if(reponse.erreur)
                    alert(reponse.message);
            }
            else {
                alert('La requête a échoué. Code HTTP : ' + xhr.status);
            }
        };
        xhr.send();
    }
</script>