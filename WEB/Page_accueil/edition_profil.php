<!-- Page d'edition de profil -->
<!-- on ajoutera la possibilité de faire la modification de l'identifiant sur l'edition de profil ! -->

<?php
session_start();


$bdd = new PDO('mysql:host=127.0.0.1;dbname=MaisonEco;charset=utf8', 'root', '');

if(isset($_SESSION['Id']))
{

    $getid = intval($_SESSION['Id']);
    $requser = $bdd->prepare('SELECT * FROM InfoPersonne JOIN Utilisateur ON InfoPersonne.idPersonne = Utilisateur.idPersonne WHERE InfoPersonne.idPersonne = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();  

    /*

    CREATE TABLE Utilisateur(
    idPersonne INT,
    identifiant VARCHAR(50) ,
    mdp VARCHAR(50) ,
    PRIMARY KEY(idPersonne),
    FOREIGN KEY(idPersonne) REFERENCES InfoPersonne(idPersonne)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    CREATE TABLE Administrateur(
    idPersonne INT,
    identifiant VARCHAR(50) ,
    mdp VARCHAR(50) ,
    PRIMARY KEY(idPersonne),
    FOREIGN KEY(idPersonne) REFERENCES InfoPersonne(idPersonne)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    */

    // on modifie l'identifiant de l'utilisateur et de l'administrateur si il est connecté en tant qu'administrateur
    if(isset($_POST['newidentifiant']) AND !empty($_POST['newidentifiant']) AND $_POST['newidentifiant'] != $userinfo['identifiant'])
    {
        $newidentifiant = htmlspecialchars($_POST['newidentifiant']);
        $insertidentifiant = $bdd->prepare("UPDATE Utilisateur SET identifiant = ? WHERE idPersonne = ?");
        $insertidentifiant->execute(array($newidentifiant, $getid));
        header('Location: edition_profil.php?id='.$_SESSION['Id']);
    }
    if(isset($_POST['newidentifiant']) AND !empty($_POST['newidentifiant']) AND $_POST['newidentifiant'] != $userinfo['identifiant'])
    {
        $newidentifiant = htmlspecialchars($_POST['newidentifiant']);
        $insertidentifiant = $bdd->prepare("UPDATE Administrateur SET identifiant = ? WHERE idPersonne = ?");
        $insertidentifiant->execute(array($newidentifiant, $getid));
        header('Location: edition_profil.php?id='.$_SESSION['Id']);
    }

    if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2']))
    {
        $mdp1 = sha1($_POST['newmdp1']);
        $mdp2 = sha1($_POST['newmdp2']);
        if($mdp1 == $mdp2)
        {
            $insertmdp = $bdd->prepare("UPDATE Utilisateur SET mdp = ? WHERE idPersonne = ?");
            $insertmdp->execute(array($mdp1, $getid));
            header('Location: edition_profil.php?id='.$_SESSION['Id']);

        }
        else
        {
            $msg = "Vos deux mots de passee ne correspondent pas !";
        }
    }

    if(isset($_POST['newnumtel']) AND !empty($_POST['newnumtel']) AND $_POST['newnumtel'] != $userinfo['numTel'])
    {
        $newnumtel = htmlspecialchars($_POST['newnumtel']);
        $insertnumtel = $bdd->prepare("UPDATE InfoPersonne SET numTel = ? WHERE idPersonne = ?");
        $insertnumtel->execute(array($newnumtel, $getid));

        header('Location: edition_profil.php?id='.$_SESSION['Id']);
    }
    if(isset($_POST['newgenre']) AND !empty($_POST['newgenre']) AND $_POST['newgenre'] != $userinfo['genre'])
    {
        $newgenre = htmlspecialchars($_POST['newgenre']);
        $insertgenre = $bdd->prepare("UPDATE InfoPersonne SET genre = ? WHERE idPersonne = ?");
        $insertgenre->execute(array($newgenre, $getid));

        header('Location: edition_profil.php?id='.$_SESSION['Id']);
    }
    if(isset($_POST['newnom']) AND !empty($_POST['newnom']) AND $_POST['newnom'] != $userinfo['nom'])
    {
        $newnom = htmlspecialchars($_POST['newnom']);
        $insertnom = $bdd->prepare("UPDATE InfoPersonne SET nom = ? WHERE idPersonne = ?");
        $insertnom->execute(array($newnom, $getid));
        header('Location: edition_profil.php?id='.$_SESSION['Id']);
    }
    if(isset($_POST['newprenom']) AND !empty($_POST['newprenom']) AND $_POST['newprenom'] != $userinfo['prenom'])
    {
        $newprenom = htmlspecialchars($_POST['newprenom']);
        $insertprenom = $bdd->prepare("UPDATE InfoPersonne SET prenom = ? WHERE idPersonne = ?");
        $insertprenom->execute(array($newprenom, $getid));
        header('Location: edition_profil.php?id='.$_SESSION['Id']);
    }
}
else
{
    $msg = "Votre Compte a bien été mis a jour !";

   header("Location: Page_accueil.php");
}
?>

<!DOCTYPE html>
<html>
<title> Edition Profil </title>
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
        <div align="center">
            <h2>Edition de mon profil</h2>
            <div align="left">
                <form method="POST" action="">
                <label>Nom :</label>
                    <input type="text" name="newnom" placeholder="Nom" value="<?php echo $userinfo['nom']; ?>" /><br /><br />
                    <label>Prénom :</label>
                    <input type="text" name="newprenom" placeholder="Prénom" value="<?php echo $userinfo['prenom']; ?>" /><br /><br />
                    <label>Mail :</label>
                    <input type="text" name="newmail" placeholder="Mail" value="<?php echo $userinfo['mail']; ?>" /><br /><br />
                    <label>Mot de passe :</label>
                    <input type="password" name="newmdp1" placeholder="Mot de passe"/><br /><br />
                    <label>Confirmation - mot de passe :</label>
                    <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" /><br /><br />
                    <label>Numéro de téléphone :</label>
                    <input type="text" name="newnumtel" placeholder="Numéro de téléphone" value="<?php echo $userinfo['numTel']; ?>" /><br /><br />
                    <label>Genre :</label>
                    <input type="text" name="newgenre" placeholder="Genre" value="<?php echo $userinfo['genre']; ?>" /><br /><br />
                    <label>Identifiant :</label>
                    <input type="text" name="newidentifiant" placeholder="Identifiant" value="<?php echo $userinfo['identifiant']; ?>" /><br /><br />
                    <input type="submit" value="Mettre à jour mon profil !" />

                </form>
                <?php if(isset($msg)) { echo $msg; } ?>
            </div>
        </div>
    </body>