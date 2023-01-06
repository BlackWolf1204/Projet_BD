<?php 

/*CREATE TABLE TypeAppareil(
   idTypeAppareil INT,
   libTypeAppareil VARCHAR(50) ,
   PRIMARY KEY(idTypeAppareil)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; */

session_start();//On démarre la session




?>




<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title> Ajouter un apparreil</title>
   <style>
      body 
      {
        font-family: Arial, sans-serif; /* Change la police de caractères */
        color: #333; /* Change la couleur du texte, , #333 est le code couleur noir */
        background-color: #eee;/* Change la couleur de fond , #eee est le code couleur gris clair */
      }
      h3 {
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
   </style>
</head>
<body>
    <!-- Ajout d'un "style de fond" -->
    <div style="background-image: url('https://www.example.com/image.jpg'); background-size: cover; height: 100vh;">
                <div class="container mt-5"> <!-- container c'est pour le centrage -->

                    <div class="row">
                    <div class="col-sm-8 offset-sm-2"><!-- col-sm-8 offset-sm-2 c'est pour le centrage avec un espace de 2 -->
                    <!--on affiche le infos d'appareil nom,  -->
                    <h3>Profil de <?php echo $userinfo['Prenom']; ?></h3>
                        <br /><br />
                        <p>Nom d'appareil : <?php echo $userinfo['Nom']; ?></p>
                        <p>Type d'appareil : <?php echo $userinfo["Type d'appareil"]; ?></p>
                        <p>Description : <?php echo $userinfo['Description']; ?></p>

                        <br /><br />
                        <a href="Supprimer.php">Supprimer</a>
</body>
</html>