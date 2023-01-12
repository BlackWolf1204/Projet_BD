
<!-- Connexion administrateur.php --> 

<!-- 
      le probleme quue j'ai actuellement c'est que dans les fait comme on prerempli la table administrateur,
       les données dans infoPersonne sont vides donc il faudrait etre egalment preremplir dans la table infoPersonne, 
        le Id nous permetra de faire la liaison entre les deux tables mais dans l'ideée c'est pas pratique,
        
        (pour rappel voici le code de la table),  : 
            CREATE TABLE Administrateur(
            idPersonne INT,
            identifiant VARCHAR(50) ,
            mdp VARCHAR(50) ,
            PRIMARY KEY(idPersonne),
            FOREIGN KEY(idPersonne) REFERENCES InfoPersonne(idPersonne)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8; -->

       

<?php
$ROOT="../";
include("../common/main.php");


if(isset($_POST['connexion']))

{
    $mailconnect = htmlspecialchars($_POST['Mail_Connexion']);
    $mdpconnect = sha1($_POST['Mot_de_passe_Connexion']);

    if(!empty($mailconnect) AND !empty($mdpconnect))//techniquement le required devrait s'en charger mais on sait jamais
    {
        $requser = $bdd->prepare("SELECT * FROM InfoPersonne NATURAL JOIN Administrateur WHERE (InfoPersonne.mail = ? OR Administrateur.identifiant = ?) AND Administrateur.mdp = ?");
        $requser->execute(array($mailconnect, $mailconnect, $mdpconnect));
        $userexist = $requser->rowCount();

        if($userexist == 1)
        {

            $userinfo = $requser->fetch();//fetch permet de récupérer les données de la requête

            $_SESSION['Id'] = $userinfo['idPersonne'];
            $_SESSION['Identifiant'] = $userinfo['identifiant'];
            $_SESSION['MotDePasse'] = $userinfo['mdp'];

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
    <title> Connexion Administrateur</title>
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
          <a href="../Page_accueil/Page_accueil.php">Retour</a>
            <!-- Ajout d'un "style de fond" -->
            <div class="container mt-5"> <!-- container c'est pour le centrage -->
           
                <div class="row">

                <div class="col-sm-8 offset-sm-2"><!-- col-sm-8 offset-sm-2 c'est pour le centrage avec un espace de 2 -->

                    <!-- Formulaire de connexion -->

                    <h2>Connexion Administrateur</h2>
                    <form method="POST" action="">

                    <div class="form-row"><!-- Div pour connecter avec le mail et le mot de passe -->

                        <div class="form-group col-md-6">
                            <input type="text" id="admin_username" name="Mail_Connexion" class="form-control" placeholder="Mail ou identifiant" required, value="<?php if(isset($mailconnect)) { echo $mailconnect; } ?>" autocomplete="username">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="password" id="admin_password" name="Mot_de_passe_Connexion" class="form-control" placeholder="Mot de passe" required autocomplete="password">
                       </div>
                    </div><!-- Fin de la div pour les champs mail et mot de passe -->


              <button type="submit" id="login" name="connexion">Se Connecter</button><!-- Bouton d'envoi du formulaire de connexion -->
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



