
 <!DOCTYPE html><!-- déclaration du type de document HTML -->

 <html lang="fr"><!-- déclaration de la langue de la page -->
 
 <head><!-- début de l'entête de la page -->

    <title>Green House</title><!-- déclaration du titre de la page -->

    
    <?php require "../common/header.php"?>

<!-- entré dans body -->

    <style>

        
        /* Ajout de style personnalisé */
        .body_accueil {
            font-family: Arial, sans-serif; /* Change la police de caractères */
            color: #333; /* Change la couleur du texte, #333 est le code couleur noir */
            background-color: #eee; /* Change la couleur de fond, #eee est le code couleur gris clair */
        }

        .bouton_Nav{
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
        .vanta-canvas 
        {
            position: unset !important;
        }
        </style>
      
    
        <!--on affiche les boutons de navigation UNIQUEMENT si l'utilisateur est connecté, on va donc vérifier si la variable de session $_SESSION['id'] existe-->


        <?php if($estConnecte) { ?>
            <!--on affiche Bienvenue suivi du  de l'utilisateur au mileu de la page -->
            <h1>Bienvenue <?php echo $_SESSION['Prenom']; ?> !</h1>
            <a href="../administration/gererConso.php" class="bouton_Nav">Regarder sa consommation/production</a>
            <a href="../administration/gererAppareil.php" class="bouton_Nav">Gérer ses appareils</a>
            <a href="../administration/gererPropriete.php" class="bouton_Nav">Gérer sa/ses propriété(s)</a>
            <a href="../proprietes/ajoutPropriete/ajoutPropriete.php" class="bouton_Nav">Ajouter une propriété</a>
            <!--on affciche le bouton statistiques UNIQUEMENT si l'utilisateur est un admin, on va donc vérifier si la variable de session $estAdmin est validée-->
        <?php } ?>
        <?php if($estAdmin) { ?>
            <a href="../administration/statistiques.php" class="bouton">Statistiques</a>
        <?php } ?>
   
    </div>
    
<?php require "../common/footer.php"; ?>

</html><!-- fin de la page -->

    
    
    

 