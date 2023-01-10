<!-- Connexion.php --> 
<!--Notes 23/12/2022 : Probleme avec l'affichage de l'image de validation, il faut que je trouve une solution pour l'afficher au premier plan, apresc'est que en option)-->
<!--Notes 06/01/2022 : Pour l'instant , on ne peut se connecter "que en tatn q'utilisateur" -->

<?php
$ROOT="../";
include("../common/main.php");
session_start();//On démarre la session


if(isset($_POST['connexion']))

{
    $mailconnect = htmlspecialchars($_POST['Mail_Connexion']);
    $mdpconnect = sha1($_POST['Mot_de_passe_Connexion']);

    if(!empty($mailconnect) AND !empty($mdpconnect))//techniquement le required devrait s'en charger mais on sait jamais
    {
        $requser = $bdd->prepare("SELECT * FROM InfoPersonne JOIN Utilisateur ON InfoPersonne.idPersonne = Utilisateur.idPersonne WHERE InfoPersonne.mail = ? AND Utilisateur.mdp = ?");
        $requser->execute(array($mailconnect, $mdpconnect));
        $userexist = $requser->rowCount();

        if($userexist == 1)
        {

            $userinfo = $requser->fetch();//fetch permet de récupérer les données de la requête

            $_SESSION['Id'] = $userinfo['idPersonne'];
            $_SESSION['Mail'] = $userinfo['mail'];
            $_SESSION['MotDePasse'] = $userinfo['mdp'];
            $_SESSION['NumTel'] = $userinfo['numTel'];
            $_SESSION['Genre'] = $userinfo['genre'];
            $_SESSION['DateNaissance'] = $userinfo['dateNais'];
            $_SESSION['Nom'] = $userinfo['nom'];
            $_SESSION['Prenom'] = $userinfo['prenom'];
            
            //On affiche une image de validation au premier plan (C:\xampp\htdocs\xampp\Projet_BD\Page_accueil\Validation.png)
            
            // on attend 2 secondes avant de rediriger
            sleep(2);

            //Si tout est bon on redirige vers la page d'accueil avec l'id de l'utilisateur vu que c'est unique
            //Sinon pour la version finale
            header("Location: Page_accueil.php");
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


?>
<html>
  <head>
    <title> Connexion </title>
    <meta charset="UTF-8">
    <!-- Ajout de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    
    <!-- Ajout de style personnalisé -->
    </head>
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
        <body>
            <!-- Ajout d'un "style de fond" -->
            <div style="background-image: url('https://www.example.com/image.jpg'); background-size: cover; height: 100vh;">
            <div class="container mt-5"> <!-- container c'est pour le centrage -->
           
                <div class="row">

                <div class="col-sm-8 offset-sm-2"><!-- col-sm-8 offset-sm-2 c'est pour le centrage avec un espace de 2 -->

                    <!-- Formulaire de connexion -->

                    <h2>Connexion</h2>
                    <form method="POST" action="">

                    <div class="form-row"><!-- Div pour connecter avec le mail et le mot de passe -->

                        <div class="form-group col-md-6">
                            <input type="email" name="Mail_Connexion" class="form-control" placeholder="Mail" required, value="<?php if(isset($mailconnect)) { echo $mailconnect; } ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="password" name="Mot_de_passe_Connexion" class="form-control" placeholder="Mot de passe" required>
                       </div>
                    </div><!-- Fin de la div pour les champs mail et mot de passe -->


              <button type="submit" name="connexion">Se Connecter</button><!-- Bouton d'envoi du formulaire de connexion -->
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




