

<?php
$ROOT = "../";
require_once '../common/main.php';

if($estConnecte)

{
    $requser = $bdd->prepare('SELECT * FROM InfoPersonne WHERE idPersonne = ?');
    $requser->execute(array($_SESSION['Id']));
    $userinfo = $requser->fetch();
    if(isset($_POST['supprimer']))
    {
        $supprimer = $bdd->prepare('DELETE FROM InfoPersonne WHERE idPersonne = ?');
        $supprimer->execute(array($_SESSION['Id']));
        //on va egalment le deconnecter
        session_destroy();
        header("Location: ../Page_accueil/Page_accueil.php");
    }

?>
    <html>
    <head>
        <title> Page Suppression </title>
        <meta charset="UTF-8">
        <!-- Ajout de Bootstrap -->
        <link rel="icon" href="<?= $ROOT ?>common/images/Green_house.ico" type="image/x-icon" />
        <link rel="stylesheet" href="<?= $ROOT ?>common/style/main.css">
    </head>
            <body>
                <!-- Ajout d'un "style de fond" -->
                <div class="container mt-5"> <!-- container c'est pour le centrage -->
                    <div class="row">
                    <div class="col-sm-8 offset-sm-2" align="center"><!-- col-sm-8 offset-sm-2 c'est pour le centrage avec un espace de 2 -->
                        <h2>Supprimer mon compte</h2>
                        <br /><br />
                        <p>Êtes-vous sûr de vouloir supprimer votre compte ?</p>
                        <br /><br />
                        <form method="POST" action="">
                            <input type="submit" name="supprimer" value="Supprimer mon compte">
                        </form>
                        <br /><br />
                        <a class="bouton" href="gestion_compte.php">Retour à mon profil</a>
                    </div>
                    </div>
                </div>
            </body>
    </html>



<?php
}
else {
    header("Location: connexion.php");
}
?>

