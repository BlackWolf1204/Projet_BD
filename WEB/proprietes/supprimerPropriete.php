<?php

require_once '../common/main.php';

if (!$estConnecte) {
    header("Location: connexion.php");
    exit();
}

if (!$estAdmin) {
    header("Location: ../Page_accueil/Page_accueil.php");
    exit();
}

if (!isset($_GET['Id']) || !is_numeric($_GET['Id']))// on vérifie que l'id est bien un nombre et qu'il est défini dans l'url
 {
    header("Location: ../Page_accueil/Page_accueil.php");
    exit();
}

$idPropriete = $_GET['Id'];

// Vérification que la propriété existe
$req = $bdd->prepare("SELECT COUNT(*) FROM ProprieteAdresse WHERE idPropriete = ?");
$req->execute(array($idPropriete));
$nbProprietes = $req->fetchColumn();
if ($nbProprietes == 0) // Si la propriété n'existe pas
{
    header("Location: ../Page_accueil/Page_accueil.php");
    exit();
}

if (isset($_POST['supprimer'])) {
    $req = $bdd->prepare("DELETE FROM ProprieteAdresse WHERE idPropriete = ?");
    $req->execute(array($idPropriete));
    header("Location: ../Page_accueil/Page_accueil.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Page de suppression de propriété</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../common/style/main.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-8 offset-sm-2" align="center">
                <h2>Supprimer une propriété</h2>
                <br><br>
                <p>Êtes-vous sûr de vouloir supprimer cette propriété ?</p>
                <br><br>
                <form method="POST" action="">
                    <input type="submit" name="supprimer" value="Supprimer la propriété">
                </form>
                <br><br>
                <a class="bouton" href="../Page_accueil/Page_accueil.php">Retour à l'accueil</a>
            </div>
        </div>
    </div>
</body>
</html>