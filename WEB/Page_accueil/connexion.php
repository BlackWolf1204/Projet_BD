<!-- Connexion.php --> 

<?php
$ROOT="../";
include("../common/main.php");


if(isset($_POST['connexion']))
{
    $mailconnect = htmlspecialchars($_POST['Mail_Connexion']);
    $mdpconnect = sha1($_POST['Mot_de_passe_Connexion']);

    if(!empty($mailconnect) AND !empty($mdpconnect))//techniquement le required devrait s'en charger mais on sait jamais
    {
        $requser = $bdd->prepare("SELECT * FROM InfoPersonne NATURAL JOIN Utilisateur WHERE (InfoPersonne.mail = ? OR Utilisateur.identifiant = ?) AND Utilisateur.mdp = ?");
        $requser->execute(array($mailconnect, $mailconnect, $mdpconnect));
        $userexist = $requser->rowCount();

        if($userexist == 1)
        {

            $userinfo = $requser->fetch();//fetch permet de récupérer les données de la requête

            $_SESSION['Id'] = $userinfo['idPersonne'];
            
            // Redirection vers la page d'accueil dans 2 secondes
            header("Refresh: 1; url={$ROOT}Page_accueil/Page_accueil.php");
        }
        else
        {
            $erreur = "Mauvais mail ou mot de passe !";
        }
    }
    else
    {
        $erreur = "Tous les champs doivent être complétés !";
    }
}


$titre = "Connexion";
require $ROOT . 'common/header.php';
?>

    <div class="container mt-5"> <!-- container c'est pour le centrage -->
    
        <div class="row">

            <div class="col-sm-8 offset-sm-2 text-center"><!-- col-sm-8 offset-sm-2 c'est pour le centrage avec un espace de 2 -->

                <!-- Formulaire de connexion -->
                <h2>Connexion</h2>
                <form method="POST" action="">

                    <div class="form-row"><!-- Div pour connecter avec le mail et le mot de passe -->

                        <div class="form-group col-md-6">
                            <input type="text" id="username" name="Mail_Connexion" class="form-control" placeholder="Mail ou identifiant" required, value="<?php if(isset($mailconnect)) { echo $mailconnect; } ?>" autocomplete="username">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="password" id="password" name="Mot_de_passe_Connexion" class="form-control" placeholder="Mot de passe" required autocomplete="password">
                        </div>
                    </div><!-- Fin de la div pour les champs mail et mot de passe -->


                    <div class="doubleboutons">
                        <button type="submit" id="login" name="connexion">Se Connecter</button>
                        <a href="<?= $ROOT ?>Page_accueil/Page_accueil.php" class="bouton">Retour à l'accueil</a>
                    </div>
                </form>
                <?php
                if(isset($erreur)) //a mettre apres le formulaire au milieu de la page
                {
                    echo '<div align="center"><font color="red">'.$erreur."</font></div>";
                }

                if(isset($userexist) AND $userexist == 1)
                {
                    echo '<div align="center"><font color="green">Vous êtes connecté !<br/>Redirection...</font></div>';
                    //On affiche une image de validation au premier plan (C:\xampp\htdocs\xampp\Projet_BD\Page_accueil\Validation.png)
                    echo "<img src='Validation.png' class='validation'/>";
                }
                ?>
            </div>
        </div>
    </div>

    <?php require($ROOT . 'common/footer.php'); ?>