
 <!DOCTYPE html><!-- déclaration du type de document HTML -->

 <html lang="fr"><!-- déclaration de la langue de la page -->
 
 <head><!-- début de l'entête de la page -->

    <title>Page d'acceuil</title><!-- déclaration du titre de la page -->

    <?php require "../common/header.php"?>

<!-- entré dans body -->

    <style>
        /* Ajout de style personnalisé */
        body {
            font-family: Arial, sans-serif; /* Change la police de caractères */
            color: #333; /* Change la couleur du texte, #333 est le code couleur noir */
            background-color: #eee; /* Change la couleur de fond, #eee est le code couleur gris clair */
        }
        p {
            font-size: 18px; /* Change la taille de la police */
            text-align: justify; /* Justifie le texte */
            margin: 20px 0; /* Ajoute de l'espace au-dessus et en-dessous du paragraphe */
        }

        .bouton {
            display: block; /* Affiche le bouton sur une nouvelle ligne */
            width: 90%; /* Remplit 90% de la largeur de la colonne */
            background-color: #00b894; /* Change la couleur de fond du bouton */
            color: #fff; /* Change la couleur du texte du bouton */
            padding: 14px 20px; /* Ajoute de l'espace à l'intérieur du bouton */
            margin: 20px auto; /* Ajoute de l'espace au-dessus et en-dessous du bouton */
            border: none; /* Enlève la bordure du bouton */
            cursor: pointer; /* Change le curseur lorsque la souris passe sur le bouton */
            text-align: center; /* Centre le texte du bouton */
            text-decoration: none; /* Enlève la décoration du texte du bouton (souligné, etc.) */
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
        .vanta-canvas {
            position: unset !important;
        }
    </style>
    <script src="p5.min.js"></script>
    <script src="vanta.topology.min.js"></script>

    <div class="vantatopologymin" id="vantatopologymin_1"></div>
    <div class="body-right">
        <h2>BIENVENUE SUR NOTRE SITE</h2>
        
        <p><b>De nos jours il est important de faire des économies d'énergie, ce site vous permettra de contrôler l'ensemble de vos appartements...</b></p>
        <a href="../administration/gererConso.php" class="bouton">Regarder sa consommation/production</a>
        <a href="../administration/gererAppareil.php" class="bouton">Gérer ses appareils</a>
        <a href="../administration/gererPropriete.php" class="bouton">Gérer sa/ses propriété(s)</a>
        <a href="../proprietes/ajoutPropriete/ajoutPropriete.php" class="bouton">Ajouter une propriété</a>
        <!-- <a href="statistiques.php" class="bouton">Statistiques</a>  seulement pour admins -->
    </div>
    <!-- fin du corps de la page -->
    <!-- juste en dessous du body on ajoute le script pour l'effet d'image dynamique de fond -->
    <div class="vantatopologymin" id="vantatopologymin_2"></div>

    <script>
        // Ajout de l'effet d'image dynamique de fond
        vantaConfig = {
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: 77.00,
            minWidth: 100.00,
            scale: 1.00,
            scaleMobile: 1.00
        }
        VANTA.TOPOLOGY({ ...vantaConfig, el: "#vantatopologymin_1" });
        VANTA.TOPOLOGY({ ...vantaConfig, el: "#vantatopologymin_2" });
    </script>       

<?php require "../common/footer.php"; ?>

</html><!-- fin de la page -->

    
    
    

 