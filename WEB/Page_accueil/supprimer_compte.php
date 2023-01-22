

<?php
$ROOT = "../";
require_once '../common/main.php';

if(!$estConnecte) redirectPageConnexionExit($ROOT);

$erreur = '';

if(isset($_POST['supprimer']))
{
    $supprimer = $bdd->prepare('DELETE FROM InfoPersonne WHERE idPersonne = ?');
    $supprimer->execute(array($sessionId));
    //on va egalement le deconnecter
    session_destroy();
    $erreur = "Votre compte a été supprimé.";
}

$title = "Page de suppression de compte";
require $ROOT . 'common/header.php';
?>

<div class="container mt-5"> <!-- container c'est pour le centrage -->
    <div class="row">
    <div class="col-sm-8 offset-sm-2" align="center"><!-- col-sm-8 offset-sm-2 c'est pour le centrage avec un espace de 2 -->
        <h2>Supprimer mon compte</h2>
        <br /><br />
        <?php if(!empty($erreur)) { ?>
            <p><?= $erreur; ?></p>
        <?php } else { ?>
            <p>Êtes-vous sûr de vouloir supprimer votre compte ?</p>
            <br /><br />
            <form method="POST" action="">
                <input type="hidden" name="idPersonne" value="<?= $sessionId; ?>">
                <input type="submit" name="supprimer" value="Supprimer mon compte">
            </form>
        <?php } ?>

        <br /><br />
        <a class="bouton" href="gestion_compte.php">Retour à mon profil</a>
    </div>
    </div>
</div>

<?php require $ROOT . 'common/footer.php'; ?>

