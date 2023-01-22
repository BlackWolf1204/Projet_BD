<!-- Inscription.php -->

<!--Notes du 22/12/22: ajouter des required pour les champs obligatoires et un pattern pour le numéro de téléphone (pattern="[0-9]{10}")-->
<!-- Notes du 23/12/22: J'ai remarqué que l'ID dans la base de données est n'est jamais remis à 0, dans les cas ou on supprimes tous les comptes, il faut le faire manuellement dans la base de données , je sais pas si cela va poser un prob -->

<?php
$ROOT = "../";
require_once '../common/main.php';

if (isset($_POST['inscription'])) {
    $erreur = NULL;
    if (empty($_POST['Nom']) || empty($_POST['Prenom']) || empty($_POST['DateNais']) || empty($_POST['Genre']) || empty($_POST['Mail']) || empty($_POST['Mail2']) || empty($_POST['NumTel']) || empty($_POST['Mdp']) || empty($_POST['Mdp2'])) {
        $erreur = "Tous les champs doivent être complétés !";
        if (empty($_POST['Nom'])) {
            $erreur = "Le nom est vide";
        } else if (empty($_POST['Prenom'])) {
            $erreur = "Le prénom est vide";
        } else if (empty($_POST['DateNais'])) {
            $erreur = "La date de naissance est vide";
        } else if (empty($_POST['Genre'])) {
            $erreur = "Le genre est vide";
        } else if (empty($_POST['Mail'])) {
            $erreur = "Le mail est vide";
        } else if (empty($_POST['Mail2'])) {
            $erreur = "La confirmation du mail est vide";
        } else if (empty($_POST['NumTel'])) {
            $erreur = "Le numéro de téléphone est vide";
        } else if (empty($_POST['Mdp'])) {
            $erreur = "Le mot de passe est vide";
        } else if (empty($_POST['Mdp2'])) {
            $erreur = "La confirmation du mot de passe est vide";
        }
    } else {
        $Nom = htmlspecialchars($_POST['Nom']);
        $Prenom = htmlspecialchars($_POST['Prenom']);
        $DateNais = htmlspecialchars($_POST['DateNais']);
        $Genre = htmlspecialchars($_POST['Genre']);
        $Mail = htmlspecialchars($_POST['Mail']);
        $Mail2 = htmlspecialchars($_POST['Mail2']);
        $NumTel = htmlspecialchars($_POST['NumTel']);
        $NumTel = preg_replace("#^(0[1-9]).?([0-9]{2}).?([0-9]{2}).?([0-9]{2}).?([0-9]{2})$#", "$1$2$3$4$5", $NumTel);
        $Mdp = htmlspecialchars($_POST['Mdp']);
        $Mdp2 = htmlspecialchars($_POST['Mdp2']);
    }

    if (empty($erreur)) {
        if ($Mail != $Mail2) {
            $erreur = "Le mail ne correspond pas.";
        } else if (!preg_match("#^0[1-9][0-9]{8}$#", $NumTel)) {
            // Sans espaces, tirets ou parenthèses : 0102030405
            $erreur = "Le numéro du portable est invalide : $NumTel";
        }
        // on veut maintenant vérifier que la taillé est >8
        else if (strlen($Mdp) <= 8) {
            $erreur = "Le mot de passe doit contenir au moins 8 caractères !";
        } else if (strlen($Nom) > 50) {
            $erreur = "Le nom est trop long !";
        } else if (strlen($Prenom) > 50) {
            $erreur = "Le prénom est trop long !";
        } else if (!filter_var($Mail, FILTER_VALIDATE_EMAIL)) {
            $erreur = "Le mail n'est pas valide !";
        }
    }

    if (empty($erreur)) {
        $HashMdp = sha1($Mdp);
        $HashMdp2 = sha1($Mdp2);
        //on verifie que les mots passe ont au moins 8 caractères
        if (strlen($Mdp) < 8 || strlen($Mdp) > 50) {
            $erreur = "Le mot de passe n'a pas le bon format ! (entre 8 et 50 caractères)";
        } else if ($HashMdp != $HashMdp2) {
            $erreur = "Les mots de passe ne correspondent pas !";
        }
    }

    if (empty($erreur)) {
        // Vérifier que l'email n'est pas utilisé   
        $reqmail = $bdd->prepare("SELECT * FROM InfoPersonne WHERE mail = ?");
        $reqmail->execute(array($Mail));
        $mailexist = $reqmail->rowCount();

        if ($mailexist > 0) {
            $erreur = "Adresse mail déjà utilisée !";
        }
    }

    if (empty($erreur)) {
        // Générer un identifiant au format : prenomXXX
        // (lower case et sans espace)
        $prenomLowerCase = str_replace(' ', '', mb_strtolower($Prenom));
        $echecs = 0;
        do {
            if ($echecs >= 100) {
                $erreur = "Erreur lors de la création de votre identifiant !";
                $identifiant = NULL;
                break;
            }
            $randomNumber = rand(100, 999); // identifiant aléatoire
            $identifiant = $prenomLowerCase . $randomNumber;
            // Vérifier que l'identifiant n'existe pas déjà
            $reqId = $bdd->prepare("SELECT * FROM Utilisateur WHERE identifiant = ?");
            $res = $reqId->execute(array($identifiant));
            if (!$res) {
                $erreur = "Erreur lors de la création de votre identifiant !";
                break;
            }
            $echecs++;
        } while ($reqId->rowCount() > 0);
    }

    if (empty($erreur)) {
        $bdd->beginTransaction();
        $insertmbr = $bdd->prepare("INSERT INTO InfoPersonne(nom, dateNais, genre, mail, numTel, prenom) VALUES(?, ?, ?, ?, ?, ?)"); //-> On insère les données dans la base de données
        $res = $insertmbr->execute(array($Nom, $DateNais, $Genre, $Mail, $NumTel, $Prenom));
        if (!$res) {
            $bdd->rollback();
            $erreur = "Erreur lors de la création de votre compte !<br>" . $insertmbr->errorInfo()[2];
        } else {
            $idPersonne = $bdd->lastInsertId();
            // date now
            $now = new DateTime();
            $dateCreation = $now->format('Y-m-d H:i:s');

            $insertmbr = $bdd->prepare("INSERT INTO Utilisateur(idPersonne,identifiant,mdp,dateCreation) VALUES(?,?,?,?)");
            $res = $insertmbr->execute(array($idPersonne, $identifiant, $HashMdp, $dateCreation));
            if (!$res) {
                $bdd->rollback();
                $erreur = "Erreur lors de la création de votre compte utilisateur !<br>" . $insertmbr->errorInfo()[2];
            } else {
                $bdd->commit();
                $erreur = "Votre compte a bien été créé !<br/>Votre identifiant est $identifiant ou $Mail<br/><a href=\"connexion.php\">Me connecter</a>";
            }
        }
    }
} else {
    $Nom = "";
    $Prenom = "";
    $DateNais = "";
    $Genre = "";
    $Mail = "";
    $Mail2 = "";
    $NumTel = "";
    $Mdp = "";
    $Mdp2 = "";
}

$titre = "Page Inscription";
require($ROOT . 'common/header.php');
?>
    <style>
        input.hidden {
            position: absolute;
            opacity: 0;
        }
    </style>
    <script>
        function verifMail() {
            // Vérifier que le mail est le même
            var mail1 = document.getElementById("Mail");
            var mail2 = document.getElementById("Mail2");
            if (mail1.value != mail2.value) {
                mail2.style.border = "1px solid red";
                return false;
            } else {
                mail2.style.border = null;
                return true;
            }
        }

        function verifMdp() {
            // Vérifier que le mail est le même
            var mdp1 = document.getElementById("Mdp");
            var mdp2 = document.getElementById("Mdp2");
            if (mdp1.value != mdp2.value) {
                mdp2.style.border = "1px solid red";
                return false;
            } else {
                mdp2.style.border = null;
                return true;
            }
        }

        function checkforblank() {
            // Vérifier que tous les champs sont valides
            if (!verifMail() || !verifMdp()) {
                return false;
            }
            var genre = document.getElementById("Genre");
            // vérifier que le champ sélectionné a une valeur
            if (genre.selectedIndex == 0) {
                genre.style.border = "1px solid red";
                return false;
            } else {
                genre.style.border = null;
            }

            return true;
        }

        function genreAutocomplete(genre) {
            let selected = 0; // 0 Choisir, 1 Homme, 2 Femme, 3 Autres
            switch (genre) {
                case 'M.':
                case 'M':
                case 'H':
                    selected = 1;
                    break;
                case 'Mme':
                case 'Mlle':
                case 'F':
                    selected = 2;
                    break;
                case 'Autre':
                case 'Other':
                case 'Autres':
                case 'Others':
                case 'A':
                    selected = 3;
                default:
                    selected = 0;
            }
            document.getElementById("Genre").selectedIndex = selected;
        }

        function birthdayAutocomplete(bday) {
            let date = new Date(bday);
            console.log(bday, date);
            document.getElementById("DateNais").value = date.toISOString().split('T')[0];
        }
    </script>

    <!-- Ajout d'un "style de fond" -->
    <div class="container mt-5"> <!-- container c'est pour le centrage -->

        <div class="row">

            <div class="col-sm-8 offset-sm-2"><!-- col-sm-8 offset-sm-2 c'est pour le centrage avec un espace de 2 -->

                <!-- Formulaire d'inscription -->

                <h2>Inscription</h2>
                <form method="POST" action="" onsubmit="return checkforblank()">
                    <div class="form-row"><!-- Div pour les champs Nom et Prénom -->
                        <div class="form-group col-md-6">
                            <label for="Nom">Nom</label>
                            <input type="text" class="form-control" id="Nom" name="Nom" autocomplete="family-name" required placeholder="Votre nom" value="<?= $Nom; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Prenom">Prénom</label>
                            <input type="text" class="form-control" id="Prenom" name="Prenom" autocomplete="given-name" required placeholder="Votre prénom" value="<?= $Prenom; ?>">
                        </div>

                    </div><!-- Fin de la div pour les champs Nom et Prénom -->

                    <div class="form-row"><!-- Div pour les champs Genre et Date de naissance -->
                        <div class="form-group col-md-6">
                            <label for="Genre">Genre</label>
                            <!-- `Genre` enum('Homme','Femme','Autres') NOT NULL, -->
                            <input type="text" name="honorific-prefix" class="hidden" autocomplete="honorific-prefix" oninput="genreAutocomplete(this.value);">
                            <select id="Genre" name="Genre" value="<?= $Genre ?>" required>
                                <option selected>Choisir...</option>
                                <option value="H" <?php if ($Genre == 'H') echo 'selected'; ?>>Homme</option>
                                <option value="F" <?php if ($Genre == 'F') echo 'selected'; ?>>Femme</option>
                                <option value="A" <?php if ($Genre == 'A') echo 'selected'; ?>>Autres</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="DateNais">Date de naissance</label>
                            <input type="text" name="bday" class="hidden" autocomplete="bday" oninput="birthdayAutocomplete(this.value);">
                            <input type="date" class="form-control" id="DateNais" name="DateNais" required value="<?= $DateNais ?>" min="1900-01-01" max="3000-01-01">

                        </div><!-- Fin de la div pour les champs Genre et Date de naissance -->
                    </div>
                    <div class="form-row"><!-- Div pour les champs mail et mail2 -->
                        <div class="form-group col-md-6">
                            <label for="Mail">Mail</label>
                            <input type="email" class="form-control" id="Mail" name="Mail" autocomplete="email" required placeholder="Votre mail" value="<?= $Mail ?>" oninput="verifMail()">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="mail2">Confirmation du mail</label>
                            <input type="email" class="form-control" id="Mail2" name="Mail2" autocomplete="email" required placeholder="Confirmez votre mail" value="<?= $Mail2 ?>" oninput="verifMail()">
                        </div>

                    </div><!-- Fin de la div pour les champs Email et Email2 -->

                    <div class="form-row"><!-- Div pour les champs  Mot de passe et Confirmation du mot de passe -->

                        <div class="form-group col-md-6">
                            <label for="Mdp">Mot de passe</label>
                            <input type="password" class="form-control" id="Mdp" name="Mdp" autocomplete="new-password" required placeholder="Votre mot de passe" value="<?= $Mdp ?>" oninput="verifMdp()">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="Mdp2">Confirmation du mot de passe</label>
                            <input type="password" class="form-control" id="Mdp2" name="Mdp2" autocomplete="new-password" required placeholder="Confirmez votre mot de passe" value="<?= $Mdp2 ?>" oninput="verifMdp()">
                        </div>


                    </div><!-- Fin de la div pour les champs Mot de passe et Confirmation du mot de passe -->

                    <div class="form-row"><!-- Div pour le champs numéro de téléphone -->


                        <div class="form-group col-md-6">
                            <label for="NumTel">Numéro de téléphone</label>
                            <input type="tel" class="form-control" id="NumTel" name="NumTel" required placeholder="ex: 06 00 00 00 00" pattern="0[1-9][ \-]?[0-9]{2}[ \-]?[0-9]{2}[ \-]?[0-9]{2}[ \-]?[0-9]{2}" value="<?= $NumTel ?>">
                        </div>


                    </div><!-- Fin de la div pour les champs numéro de téléphone -->

                    <div class="doubleboutons">
                        <a href="../Page_accueil/Page_accueil.php" class="bouton-retour">Retour à l'accueil</a>
                        <button type="submit" name="inscription">S'inscrire</button><!-- Bouton d'envoi du formulaire d'inscription -->
                    </div>

                </form>
                <?php
                if (isset($erreur)) //a mettre apres le formulaire au milieu de la page
                {
                    echo '<div align="center"><font color="red">' . $erreur . "</font></div>";
                }
                ?>
            </div>
        </div>
    </div>
<?php require($ROOT . 'common/footer.php'); ?>