<?php
$ROOT = "../";
$titre = "Green House";
require $ROOT . 'common/header.php';
?>

<!-- entré dans body -->

    <style>

        
        /* Ajout de style personnalisé */
        .body_accueil {
            font-family: Arial, sans-serif; /* Change la police de caractères */
            color: #333; /* Change la couleur du texte, #333 est le code couleur noir */
            background-color: #eee; /* Change la couleur de fond, #eee est le code couleur gris clair */
        }

        .bouton_Nav {
            display: block; /* Affiche le bouton sur une nouvelle ligne */
            width: 90%; /* Remplit 90% de la largeur de la colonne */
            margin: 20px auto; /* Ajoute de l'espace au-dessus et en-dessous du bouton */
        }

        /* Styles pour la classe body-right */
        .body-right {
            background-color: var(--primary-color);
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .vantatopologymin {
            height: 77px;
            position: initial !important;
        }
        .vanta-canvas 
        {
            position: unset !important;
        }

        #image-appareil {
            opacity:0.35;
            border: 5px solid white;
            object-fit: fill;
            width: 84%;
            margin: auto;
        }
        </style>
      
    
        <!--on affiche les boutons de navigation UNIQUEMENT si l'utilisateur est connecté, on va donc vérifier si la variable de session $_SESSION['id'] existe-->


        <?php if($estConnecte) { ?>
            <!--on affiche Bienvenue suivi du  de l'utilisateur au mileu de la page -->
            <h1 style="text-align: center;">Bienvenue <?= $Prenom ?> !</h1>
            <a href="../administration/gererConso.php" class="bouton_Nav bouton">Regarder sa consommation/production</a>
            <a href="../Gestion des appareils/gererAppareils.php" class="bouton_Nav bouton">Gérer ses appareils</a>
            <a href="../proprietes/gererProprietes.php" class="bouton_Nav bouton">Gérer sa/ses propriété(s)</a>
            <a href="../proprietes/ajoutPropriete/ajoutPropriete.php" class="bouton_Nav bouton">Ajouter une propriété</a>
            <!--on affciche le bouton statistiques UNIQUEMENT si l'utilisateur est un admin, on va donc vérifier si la variable de session $estAdmin est validée-->
        <?php } else { ?>
            <!-- on affiche une image de fond avec un texte qui explique le site , l'image sera d'une opacite plus legere pour que le texte soit lisible -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <!-- pour mettre de la bordure sur l'image, on peut utiliser la classe img-thumbnail -->
                    <img id="image-appareil" class="d-block" src="<?= $ROOT ?>common/images/appareil.webp" alt="Green House">
                    <div class="carousel-caption center"><!-- les parametre de object-fit sont : fill, contain, cover, none, scale-down -->
                        <h1 style="color: Green; font-size: 50px; font-weight: bold; text-shadow: 0px 0px 35px #000000;">Green House</h1>
                        <p style="color: White; font-size: 30px; font-weight: bold; text-shadow: 0px 0px 25px #000000;">Contrôler votre consommation d'energies </p>
                        <p style="color: White; font-size: 30px; font-weight: bold; text-shadow: 0px 0px 25px #000000;">afin de réduire vos émissions de substances nocives </p>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if($estAdmin) { ?>
            <a href="../administration/statistiques.php" class="bouton_Nav bouton">Statistiques</a>
        <?php } ?>
   
    </div>
    
<?php require $ROOT . 'common/footer.php'; ?>