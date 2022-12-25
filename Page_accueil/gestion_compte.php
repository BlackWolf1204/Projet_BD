



<?php
session_start();//On démarre la session
// On se connecte à la base de données interne qui se trouve dans le dossier Page_accueil (C:\xampp\htdocs\xampp\Projet_BD\Page_accueil\comptes.sql)
$bdd = new PDO('mysql:host=127.0.0.1;dbname=comptes;charset=utf8', 'root', '');

if(isset($_GET['id']) AND $_GET['id'] > 0)
{
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM info_comptes WHERE Id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
?>
    <html>
    <head>
        <title> Page Profil </title>
        <meta charset="UTF-8">
        <!-- Ajout de Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
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
        </style>
    </head>
            <body>
                <!-- Ajout d'un "style de fond" -->
                <div style="background-image: url('https://www.example.com/image.jpg'); background-size: cover; height: 100vh;">
                <div class="container mt-5"> <!-- container c'est pour le centrage -->

                    <div class="row">
                    <div class="col-sm-8 offset-sm-2"><!-- col-sm-8 offset-sm-2 c'est pour le centrage avec un espace de 2 -->

                    <!--on affiche le infos du profil nom, prenom , on met un bouton de modification a cote du mail, du numero de telephone et si on  clique dessus on peut modifier les champs -->
                        <h2>Profil de <?php echo $userinfo['Prenom']; ?></h2>
                        <br /><br />
                        <p>Nom : <?php echo $userinfo['Nom']; ?></p>
                        <p>Prénom : <?php echo $userinfo['Prenom']; ?></p>
                        <p>Genre : <?php echo $userinfo['Genre']; ?></p>
                        <p>Mail : <?php echo $userinfo['Mail']; ?></p>
                        <p>Date de naissance : <?php echo $userinfo['Date_Naissance']; ?></p>
                        <p>Numéro de téléphone : <?php echo $userinfo['Num_Tel']; ?></p>

                        <br /><br />
                        <a href="edition_profil.php">Editer mon profil</a>
                        <br /><br />
                        <a href="deconnexion.php">Se déconnecter</a>
                    </div>
                    </div>
                </div>
                </div>
            </body>
    </html>
<?php
}
?>



