<?php 

/*CREATE TABLE Appareil(
  idAppareil INT AUTO_INCREMENT,
  nomAppareil VARCHAR(20)  NOT NULL,
  emplacement VARCHAR(50) ,
  idTypeAppareil INT NOT NULL,
  idPiece INT NOT NULL,
  PRIMARY KEY(idAppareil),
  FOREIGN KEY(idTypeAppareil) REFERENCES TypeAppareil(idTypeAppareil),
  FOREIGN KEY(idPiece) REFERENCES Piece(idPiece)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;*/
session_start();//On démarre la session
if (isset($_POST['Appareil'])) {
  $erreur = NULL;
  if (!empty($_POST)) {
    require('../common/main.php');
    if (empty($_POST['nomAppareil']) || empty($_POST['TypeAppareil']) || empty($_POST['emplacement']) ) {
      $erreur = "Tous les champs doivent être complétés !";
      if (empty($_POST['nomAppareil'])) {
          $erreur = "Le nom est vide";
      } else if (empty($_POST['TypeAppareil'])) {
          $erreur = "Le type d'appareil est vide";
      } else if (empty($_POST['emplacement'])) {
          $erreur = "l'emplacement de l'appareil est vide";
      }
      // store form data in variables
      $nomAppareil = htmlspecialchars($_POST['nomAppareil']);
      $TypeAppareil = htmlspecialchars($_POST['TypeAppareil']);
      $emplacement = htmlspecialchars($_POST['emplacement']);

      // Requête SQL
      $sql = "INSERT INTO Appareil (nomAppareil, TypeAppareil,emplacement) VALUES ('$nomAppareil', '$TypeAppareil','$emplacement')";
    }
  } 
}else {
  $nomAppareil ="";
  $TypeAppareil ="";
  $emplacement ="";
}
?>




<!DOCTYPE html>
<html lang="fr">
  <head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title> Page d'ajout</title>
   <script>

   </script>
   
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
   </style>
</head>
<body>
    <!-- Ajout d'un "style de fond" -->
       <div class="container mt-5"> <!-- container c'est pour le centrage -->

            <div class="row">

                  <div class="col-sm-8 offset-sm-2"><!-- col-sm-8 offset-sm-2 c'est pour le centrage avec un espace de 2 -->
                        <!--on affiche le infos d'appareil nom,  -->
                        <!--<h2>Profil de <?= $Prenom ?></h2>-->
                      <h2>Ajouter un appareil </h2>
                      <form action="Appareil.php" method="post"> 
                          <!-- Non d'appareil --> 
                         <div>
                             <label for="nomApareil">Nom d'appareril</label>
                             <input type="text" name="nomAppareil" placeholder="ex: Lampe">
                         </div>
                         <!-- Type d'appareil --> 
                         <div>
                             <label for="TypeAppareil">Type d'appareril</label>
                              <select name="TypeAppareil">
                                 <option value="A">choisissez le type de votre appareil</option>
                                 <option value="B">chauffage éléctrique</option>
			                         	 <option value="C">réfrigérateur</option>
			                           <option value="D">lampe</option>
                                 <option value="E">aspirateur</option>
                                 <option value="F">plaques de cuisson</option>
                                 <option value="G">télévision</option> 
                                 <option value="H">chauffage au gaz</option> 
                              </select>
                          </div>
                          <!-- Description --> 
                          <div>
                             <label for="emplacement">Description</label>
                             <input type="text" name="emplacement" placeholder="Indiquez l'emplacement de votre appareil">
                          </div>
                    
                          <div  class="doubleboutons">
                             <button href="../Page_accueil/Page_accueil.php" class="bouton-retour">Retour à l'accueil</button>
                             <button type="submit" value="Ajouter"> Ajouter</button>
                          </div>
                      </form>
          <?php require "../common/footer.php"; ?>
</body>
</html>