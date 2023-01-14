<!-- Page d'edition de profil -->
<!-- on ajoutera la possibilité de faire la modification de l'identifiant sur l'edition de profil ! -->

<?php
$ROOT = "../";
require_once '../common/main.php';

if ($estConnecte) {
    $tableUser = $estAdmin ? "Administrateur" : "Utilisateur";

    $requser = $bdd->prepare("SELECT * FROM InfoPersonne NATURAL JOIN $tableUser WHERE InfoPersonne.idPersonne = ?");
    $result = $requser->execute(array($sessionId));
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
    $nbChangements = 0;
    $msgs = array();
    if (isset($_POST['newidentifiant']) and !empty($_POST['newidentifiant']) and $_POST['newidentifiant'] != $userinfo['identifiant']) {
        $newidentifiant = htmlspecialchars($_POST['newidentifiant']);
        $insertidentifiant = $bdd->prepare("UPDATE $tableUser SET identifiant = ? WHERE idPersonne = ?");
        $res = $insertidentifiant->execute(array($newidentifiant, $sessionId));
        if ($res)
            $nbChangements++;
        else
            $msgs[] = "Erreur lors de la modification de l'identifiant";
    }
    if (isset($_POST['newmail']) and !empty($_POST['newmail']) and $_POST['newmail'] != $userinfo['mail']) {
        $newmail = htmlspecialchars($_POST['newmail']);
        $insertmail = $bdd->prepare("UPDATE InfoPersonne SET mail = ? WHERE idPersonne = ?");
        $res = $insertmail->execute(array($newmail, $sessionId));
        if ($res)
            $nbChangements++;
        else
            $msgs[] = "Erreur lors de la modification de l'adresse mail";
    }

    if (isset($_POST['newmdp1']) and !empty($_POST['newmdp1']) and isset($_POST['newmdp2']) and !empty($_POST['newmdp2'])) {
        $mdp1 = sha1($_POST['newmdp1']);
        $mdp2 = sha1($_POST['newmdp2']);
        if ($mdp1 == $mdp2) {
            $insertmdp = $bdd->prepare("UPDATE $tableUser SET mdp = ? WHERE idPersonne = ?");
            $res = $insertmdp->execute(array($mdp1, $sessionId));
            if ($res)
                $nbChangements++;
            else
                $msgs[] = "Erreur lors de la modification du mot de passe";
        } else {
            $msgs[] = "Les deux mots de passe ne correspondent pas";
        }
    }

    if (isset($_POST['newnumtel']) and !empty($_POST['newnumtel']) and $_POST['newnumtel'] != $userinfo['numTel']) {
        $NumTel = htmlspecialchars($_POST['newnumtel']);
        $NumTel = preg_replace("#^(0[1-9]).?([0-9]{2}).?([0-9]{2}).?([0-9]{2}).?([0-9]{2})$#", "$1$2$3$4$5", $NumTel);
        $newnumtel = htmlspecialchars($_POST['newnumtel']);
        if (!preg_match("#^0[1-9][0-9]{8}$#", $NumTel)) {
            // Sans espaces, tirets ou parenthèses : 0102030405
            echo "Le numéro du portable est invalide : $NumTel";
        } else {
            $insertnumtel = $bdd->prepare("UPDATE InfoPersonne SET numTel = ? WHERE idPersonne = ?");
            $res = $insertnumtel->execute(array($newnumtel, $sessionId));
            if ($res)
                $nbChangements++;
            else
                $msgs[] = "Erreur lors de la modification du numéro de téléphone";
        }
    }
    if (isset($_POST['newgenre']) and !empty($_POST['newgenre']) and $_POST['newgenre'] != $userinfo['genre']) {
        $newgenre = htmlspecialchars($_POST['newgenre']);
        $insertgenre = $bdd->prepare("UPDATE InfoPersonne SET genre = ? WHERE idPersonne = ?");
        $res = $insertgenre->execute(array($newgenre, $sessionId));
        if ($res)
            $nbChangements++;
        else
            $msgs[] = "Erreur lors de la modification du genre";
    }
    if (isset($_POST['newnom']) and !empty($_POST['newnom']) and $_POST['newnom'] != $userinfo['nom']) {
        $newnom = htmlspecialchars($_POST['newnom']);
        $insertnom = $bdd->prepare("UPDATE InfoPersonne SET nom = ? WHERE idPersonne = ?");
        $res = $insertnom->execute(array($newnom, $sessionId));
        if ($res)
            $nbChangements++;
        else
            $msgs[] = "Erreur lors de la modification du nom";
    }
    if (isset($_POST['newprenom']) and !empty($_POST['newprenom']) and $_POST['newprenom'] != $userinfo['prenom']) {
        $newprenom = htmlspecialchars($_POST['newprenom']);
        $insertprenom = $bdd->prepare("UPDATE InfoPersonne SET prenom = ? WHERE idPersonne = ?");
        $res = $insertprenom->execute(array($newprenom, $sessionId));
        if ($res)
            $nbChangements++;
        else
            $msgs[] = "Erreur lors de la modification du prénom";
    }

    if ($nbChangements > 0) {
        // Rerécupérer les infos de l'utilisateur
        $requser = $bdd->prepare("SELECT * FROM InfoPersonne NATURAL JOIN $tableUser WHERE InfoPersonne.idPersonne = ?");
        $result = $requser->execute(array($sessionId));
        $userinfo = $requser->fetch();
        $msgs[] = "Vos informations ont été mises à jour";
    }
} else {
    echo "Vous n'êtes pas connecté !<br>Redirection vers la page d'accueil dans 2 secondes...";
    header("Refresh: 2; url={$ROOT}Page_accueil/Page_accueil.php");
}
?>

<!DOCTYPE html>
<html>
<title>Édition Profil </title>
    <meta charset="UTF-8">
    <!-- Ajout de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="icon" href="<?= $ROOT ?>common/images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?= $ROOT ?>common/style/main.css">
    <!-- Ajout de style personnalisé -->
    </head>
    <style> 
        form > label {
            margin-top: 1em;
        }
    </style>
    
    <body>
        <div align="center">
            <h2>Édition de mon profil</h2>
            <div align="left">
                <form method="POST" action="edition_profil.php">
                <label>Nom :</label>
                <input type="text" name="newnom" placeholder="Nom" value="<?php echo $userinfo['nom']; ?>" />
                <label>Prénom :</label>
                <input type="text" name="newprenom" placeholder="Prénom" value="<?php echo $userinfo['prenom']; ?>" />
                <label>Mail :</label>
                <input type="text" name="newmail" placeholder="Mail" value="<?php echo $userinfo['mail']; ?>" autocomplete="email" />
                <label>Nouveau mot de passe :</label>
                <input type="password" name="newmdp1" placeholder="Nouveau mot de passe" autocomplete="new-password" />
                <label>Confirmation - mot de passe :</label>
                <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" autocomplete="new-password" />
                <label>Numéro de téléphone :</label>
                <input type="text" name="newnumtel" placeholder="Numéro de téléphone" pattern="0[1-9][ \-]?[0-9]{2}[ \-]?[0-9]{2}[ \-]?[0-9]{2}[ \-]?[0-9]{2}" title="Format 01 23 45 67 89" value="<?php echo $userinfo['numTel']; ?>" />
                <label>Genre :</label>
                <select id="Genre" name="newgenre" value="<?= $Genre ?>" required>
                    <option value="H" <?php if ($userinfo['genre'] == 'H') echo 'selected'; ?>>Homme</option>
                    <option value="F" <?php if ($userinfo['genre'] == 'F') echo 'selected'; ?>>Femme</option>
                    <option value="A" <?php if ($userinfo['genre'] == 'A') echo 'selected'; ?>>Autres</option>
                </select>
                <label>Identifiant :</label>
                <input type="text" name="newidentifiant" placeholder="Identifiant" value="<?php echo $userinfo['identifiant']; ?>" disabled />
                <div class="doubleboutons">
                    <input type="submit" value="Mettre à jour mon profil !" />
                    <a href="<?= $ROOT ?>Page_accueil/Page_accueil.php" class="bouton">Retour à l'accueil</a>
                </div>

            </form>
            <!-- Afficher $msgs avec un join de \n -->
            <script>
                var msgs = <?= json_encode($msgs) ?>;
                if (msgs.length > 0) {
                    alert(msgs.join("\n"));
                }
            </script>
        </div>
    </div>
</body>