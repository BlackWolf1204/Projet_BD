<!-- Inscription.php --> 

<!--Notes du 22/12/22: ajouter des required pour les champs obligatoires et un pattern pour le numéro de téléphone (pattern="[0-9]{10}")-->
<!-- Notes du 23/12/22: J'ai remarqué que l'ID dans la base de données est n'est jamais remis à 0, dans les cas ou on supprimes tous les comptes, il faut le faire manuellement dans la base de données , je sais pas si cela va poser un prob -->$_COOKIE
<?php
session_start();//On démarre la session
// On se connecte à la base de données interne qui se trouve dans le dossier Page_accueil (C:\xampp\htdocs\xampp\Projet_BD\Page_accueil\comptes.sql)
$bdd = new PDO('mysql:host=127.0.0.1;dbname=comptes;charset=utf8', 'root', '');

if(isset($_POST['inscription'])) 
{

    $Nom = htmlspecialchars($_POST['Nom']);//htmlspecialchars c'est pour sécuriser les données
    $Prenom = htmlspecialchars($_POST['Prenom']);
    $Genre = htmlspecialchars($_POST['Genre']); // a la base sur phpmyadmin je l'avais declaré de la façon suivante ( `Genre` enum('H','F','Autres') NOT NULL), mais je l'ai changé en varchar(10) et ça marche 
    
    $Date_naissance = htmlspecialchars($_POST['Date_naissance']);
    $Num_tel = htmlspecialchars($_POST['Num_tel']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $mdp = sha1($_POST['mdp']);//sha1 c'est pour crypter le mot de passe
    $mdp2 = sha1($_POST['mdp2']);

    

    if(!empty($_POST['Nom']) AND !empty($_POST['Prenom']) AND !empty($_POST['Genre']) AND !empty($_POST['Date_naissance']) AND !empty($_POST['Num_tel']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
    {
        
        $Nomlength = strlen($Nom);
        if($Nomlength <= 255) 
        {
            if($mail == $mail2) 
            {
                if(filter_var($mail, FILTER_VALIDATE_EMAIL)) 
                {
                    $reqmail = $bdd->prepare("SELECT * FROM info_comptes WHERE Mail = ?");
                    $reqmail->execute(array($mail));
                    $mailexist = $reqmail->rowCount();
                    if($mailexist == 0) 
                    {
                        if($mdp == $mdp2) 
                        {
                            $insertmbr = $bdd->prepare("INSERT INTO info_comptes(Nom, Prenom, Genre, DateNaissance, NumTel, Mail, MotDePasse) VALUES(?, ?, ?, ?, ?, ?, ?)");
                            $insertmbr->execute(array($Nom, $Prenom, $Genre, $Date_naissance, $Num_tel, $mail, $mdp));
                            $erreur = "Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";// Techniquement ce n'est pas une erreur, mais c'est plus simple de l'appeler comme ça 
                        } 
                        else 
                        {
                            $erreur = "Vos mots de passes ne correspondent pas !";
                        }
                    } 
                   
                    
                    else 
                    {
                        $erreur = "Adresse mail déjà utilisée !";
                    }
                } 
                else 
                {
                    $erreur = "Votre adresse mail n'est pas valide !";
                }
            } 
            else 
            {
                $erreur = "Vos adresses mail ne correspondent pas !";
            }
        } 
        else 
        {
            $erreur = "Votre nom ne doit pas dépasser 255 caractères !";//On sait jamais si qqun veut mettre un nom de 256 caractères :D
        }
    }
     else 
    {
        $erreur = "Tous les champs doivent être complétés !";
    }
}

?>
<html>
  <head>
    <title> Page Inscription </title>
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
      </style>

        </head>
        <body>
            <!-- Ajout d'un "style de fond" -->
            <div style="background-image: url('https://www.example.com/image.jpg'); background-size: cover; height: 100vh;">
            <div class="container mt-5"> <!-- container c'est pour le centrage -->

                <div class="row">

                <div class="col-sm-8 offset-sm-2"><!-- col-sm-8 offset-sm-2 c'est pour le centrage avec un espace de 2 -->

                    <!-- Formulaire d'inscription -->

                    <h2>Inscription</h2>
                    <form method="POST" action="">

                    <div class="form-row"><!-- Div pour les champs Nom et Prénom -->
                        <div class="form-group col-md-6">
                        <label for="Nom">Nom</label>
                        <input type="text" class="form-control" id="Nom" name="Nom" placeholder="Votre nom",value="<?php if(isset($Nom)) { echo $Nom; } ?>">
                        </div>
                        <div class="form-group col-md-6">
                        <label for="Prenom">Prénom</label>
                        <input type="text" class="form-control" id="Prenom" name="Prenom" placeholder="Votre prénom",value="<?php if(isset($Prenom)) { echo $Prenom; } ?>">
                        </div>

                    </div><!-- Fin de la div pour les champs Nom et Prénom -->

                    <div class="form-row"><!-- Div pour les champs Genre et Date de naissance -->
                        <div class="form-group col-md-6">
                        <label for="Genre">Genre</label>
                        <!-- `Genre` enum('Homme','Femme','Autres') NOT NULL, -->
                        <select id="Genre" name="Genre" value="<?php if(isset($Genre)) { echo $Genre; } ?>">
                            <option selected>Choisir...</option>
                            <option value="H" <?php if(isset($Genre) && $Genre == 'Homme') { echo 'selected'; } ?>>Homme</option>
                            <option value="F" <?php if(isset($Genre) && $Genre == 'Femme') { echo 'selected'; } ?>>Femme</option>
                            <option value="Autres" <?php if(isset($Genre) && $Genre == 'Autres') { echo 'selected'; } ?>>Autres</option>
                        </select>
                        </div>
                        <div class="form-group col-md-6">
                        <label for="Date_naissance">Date de naissance</label>
                        <input type="date" class="form-control" id="Date_naissance" name="Date_naissance",value="<?php if(isset($Date_naissance)) { echo $Date_naissance; } ?>">  
                    </div><!-- Fin de la div pour les champs Genre et Date de naissance -->
              </div>
              <div class="form-row"><!-- Div pour les champs mail et mail2 -->

                <div class="form-group col-md-6">
                  <label for="mail">Mail</label>
                  <input type="email" class="form-control" id="mail" name="mail" placeholder="Votre mail",value="<?php if(isset($mail)) { echo $mail; } ?>">
                </div>

                <div class="form-group col-md-6">
                  <label for="mail2">Confirmation du mail</label>
                  <input type="email" class="form-control" id="mail2" name="mail2" placeholder="Confirmez votre mail",value="<?php if(isset($mail2)) { echo $mail2; } ?>">
                </div>

                

              </div><!-- Fin de la div pour les champs Email et Email2 -->

              <div class="form-row"><!-- Div pour les champs  Mot de passe et Confirmation du mot de passe -->

                <div class="form-group col-md-6">
                  <label for="mdp">Mot de passe</label>
                  <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Votre mot de passe",value="<?php if(isset($mdp)) { echo $mdp; } ?>">
                </div>

                <div class="form-group col-md-6">
                  <label for="mdp2">Confirmation du mot de passe</label>
                  <input type="password" class="form-control" id="mdp2" name="mdp2" placeholder="Confirmez votre mot de passe",value="<?php if(isset($mdp2)) { echo $mdp2; } ?>">
                </div>


              </div><!-- Fin de la div pour les champs Mot de passe et Confirmation du mot de passe -->

              <div class="form-row"><!-- Div pour le champs numéro de téléphone -->

          
                <div class="form-group col-md-6">
                  <label for="Num_tel">Numéro de téléphone</label>
                  <input type="tel" class="form-control" id="Num_tel" name="Num_tel" placeholder="ex: 06 00 00 00 00",value="<?php if(isset($Num_tel)) { echo $Num_tel; } ?>">
                </div>


              </div><!-- Fin de la div pour les champs numéro de téléphone -->

              <button type="submit" name="inscription">S'inscrire</button><!-- Bouton d'envoi du formulaire d'inscription -->

            </form>
            <?php
            if(isset($erreur)) //a mettre apres le formulaire au milieu de la page
            {
                echo '<div align="center"><font color="red">'.$erreur."</font></div>";
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>




