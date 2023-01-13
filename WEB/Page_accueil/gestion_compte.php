
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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="icon" href="<?= $ROOT ?>common/images/favicon.ico" type="image/x-icon" />
        <!-- Ajout de style personnalisé -->
        <style> 
            body 
            {
                font-family: Arial, sans-serif; /* Change la police de caractères */
                color: #333; /* Change la couleur du texte, , #333 est le code couleur noir */
                background-color: #eee;/* Change la couleur de fond , #eee est le code couleur gris clair */
            }
            h2 {
                font-size: 36px; /* Change la taille de la police */
                text-align: center; /* Centre le texte */
                color: #00b894; /* Change la couleur du texte */
            }
            form {
                max-width: 500px; /* Limite la largeur du formulaire */
                margin: 0 auto; /* Centre le formulaire sur la page */
                background-color: #fff; /* Change la couleur de fond du formulaire */
                border: 1px solid #ddd; /* Ajoute une bordure au formulaire */
                padding: 20px; /* Ajoute de l'espace autour du contenu du formulaire */
            }
            input, select {
                width: 100%; /* Remplit toute la largeur de la colonne */
                padding: 12px 20px; /* Ajoute de l'espace à l'intérieur de l'élément */
                margin: 8px 0; /* Ajoute de l'espace en dessous de l'élément */
                box-sizing: border-box; /* Permet de prendre en compte la bordure dans la largeur de l'élément */
            }
            button {
                width: 100%; /* Remplit toute la largeur de la colonne */
                background-color: #00b894; /* Change la couleur de fond du bouton */
                color: #fff; /* Change la couleur du texte du bouton */
                padding: 14px 20px; /* Ajoute de l'espace à l'intérieur du bouton */
                margin: 8px 0; /* Ajoute de l'espace en dessous du bouton */
                border: none; /* Enlève la bordure du bouton */
                cursor: pointer; /* Change le curseur lorsque la souris passe sur le bouton */
            }
            button:hover {
                background-color: #00cec9; /* Change la couleur de fond du bouton au survol */
            }
            .bouton-retour {
                display: block; /* Affiche le bouton sur une nouvelle ligne */
                width: 15%; /* Remplit 15% de la largeur de la colonne */
                background-color: #00b894; /* Change la couleur de fond du bouton */
                color: #fff; /* Change la couleur du texte du bouton */
                padding: 14px 20px; /* Ajoute de l'espace à l'intérieur du bouton */
                margin: 20px; /* Ajoute de l'espace au-dessus et en-dessous du bouton */
                border: none; /* Enlève la bordure du bouton */
                cursor: pointer; /* Change le curseur lorsque la souris passe sur le bouton */
                text-align: center; /* Centre le texte du bouton */
                text-decoration: none; /* Enlève la décoration du texte du bouton (souligné, etc.) */
            } 
        </style>
    </head>
            <body>
                <a href="../Page_accueil/Page_accueil.php" class = "bouton-retour">Retour à l'accueil</a>
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
                        <a href="edition_profil.php">Editer mon profil</a>
                        <a href="Page_accueil.php">Retour à l'accueil</a>
                        
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



