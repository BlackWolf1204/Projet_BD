<?php
$ROOT = '../';
require_once '../common/main.php';
if (!$estConnecte) redirectPageConnexionExit($ROOT);

$erreur = '';

if (isset($_POST['supprimer'])) {
    if (!isset($_GET['idPropriete'])) redirectPageAccueilExit($ROOT);
    $idPropriete = $_POST['idPropriete'];
}
else if(isset($_GET['idPropriete'])) // on vérifie que l'id est bien un nombre et qu'il est défini dans l'url
{
    $idPropriete = $_GET['idPropriete'];
}
else
{
    redirectPageAccueilExit($ROOT);
}

if(!is_numeric($idPropriete))
{
    $erreur = "L'id de la propriété n'est pas valide.";
}

// Vérification que la propriété existe
if(empty($erreur)) {
    $req = $bdd->prepare("SELECT COUNT(*) FROM ProprieteAdresse WHERE idPropriete = ?");
    $req->execute(array($idPropriete));
    $nbProprietes = $req->fetchColumn();
    if ($nbProprietes == 0) // Si la propriété n'existe pas
    {
        $erreur = "La propriété n'existe pas.";
    }
}

// Vérifier que l'utilisateur a la propriété
if(empty($erreur) && !$estAdmin)
{
    $req = $bdd->prepare("SELECT COUNT(*) FROM ProprietaireActuel WHERE idPropriete = ? AND idProprietaire = ?");
    $req->execute(array($idPropriete, $sessionId));
    $nbProprietes = $req->fetchColumn();
    if ($nbProprietes == 0) // Si l'utilisateur n'a pas la propriété
        $erreur = "Vous n'avez pas la permission de supprimer cette propriété.";
}

if(empty($erreur) && isset($_POST['supprimer']))
{
    // Suppression de la propriété
    $req = $bdd->prepare("DELETE FROM Propriete WHERE idPropriete = ?");
    $req->execute(array($idPropriete));
    $erreur = "La propriété a été supprimée.";
}

$titre = "Page de suppression de propriété";
require $ROOT . 'common/header.php';
?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-8 offset-sm-2" align="center">
                <h2>Supprimer une propriété</h2>
                <br><br>
                
                <?php if(empty($erreur)) { ?>
                
                    <p>Êtes-vous sûr de vouloir supprimer cette propriété ?</p>
                    <br><br>
                    <form method="POST" action="">
                        <input type="hidden" name="idPropriete" value="<?= $idPropriete; ?>">
                        <input type="submit" name="supprimer" value="Supprimer la propriété">
                    </form>
                <?php } else echo "<p>$erreur</p>"; ?>

                <br><br>
                <a class="bouton" href="../Page_accueil/Page_accueil.php">Retour à l'accueil</a>
            </div>
        </div>
    </div>
<?php require $ROOT . 'common/footer.php'; ?>