
<!-- Page de gestion de compte -->


<?php
$ROOT = "../";
require_once $ROOT . 'common/main.php';

if(!$estConnecte)
{
    header("Location: connexion.php");
    exit();
}

$requser = $bdd->prepare('SELECT * FROM InfoPersonne WHERE idPersonne = ?');
$requser->execute(array($sessionId));
$userinfo = $requser->fetch();

$titre = "Page profil";
require $ROOT . 'common/header.php';
?>

    <div class="mt-5 text-center"> <!-- centrage -->

        <!--on affiche le infos du profil nom, prenom , on met un bouton de modification a cote du mail, du numero de telephone et si on  clique dessus on peut modifier les champs -->

        <!-- Affichage des informations du profil -->
        <h2>Profil de <?php echo $userinfo['prenom']; ?></h2>
        <br /><br />
            <p>Nom : <?php echo $userinfo['nom']; ?></p>
            <p>Prénom : <?php echo $userinfo['prenom']; ?></p>
            <p>Genre : <?php echo $userinfo['genre']; ?></p>
            <p>Mail : <?php echo $userinfo['mail']; ?></p>
            <p>Date de naissance : <?php echo $userinfo['dateNais']; ?></p>
            <p>Numéro de téléphone : <?php echo $userinfo['numTel']; ?></p>
        <br /><br />
        <a class="bouton" href="edition_profil.php">Editer mon profil</a>
        <a class="bouton" href="Page_accueil.php">Retour à l'accueil</a>
        
    </div>
    <?php require_once "{$ROOT}common/footer.php"; ?>



