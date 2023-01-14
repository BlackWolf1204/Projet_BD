
<!-- Page de gestion de compte -->


<?php
$ROOT = "../";
require_once '../common/main.php';

if($estConnecte)

{
    $requser = $bdd->prepare('SELECT * FROM InfoPersonne WHERE idPersonne = ?');
    $requser->execute(array($sessionId));
    $userinfo = $requser->fetch();
?>


    <html>
    <head>
        <title> Page Profil </title>
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



