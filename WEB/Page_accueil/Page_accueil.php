
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
        </style>
      
    
        <!--on affiche les boutons de navigation UNIQUEMENT si l'utilisateur est connecté, on va donc vérifier si la variable de session $_SESSION['id'] existe-->


        <?php if($estConnecte) { ?>
            <!--on affiche Bienvenue suivi du  de l'utilisateur au mileu de la page -->
            <h1 style="text-align: center;">Bienvenue <?= $Prenom ?> !</h1>
            <a href="../administration/gererConso.php" class="bouton_Nav bouton">Regarder sa consommation/production</a>
            <a href="../administration/gererAppareil.php" class="bouton_Nav bouton">Gérer ses appareils</a>
            <a href="../administration/gererPropriete.php" class="bouton_Nav bouton">Gérer sa/ses propriété(s)</a>
            <a href="../proprietes/ajoutPropriete/ajoutPropriete.php" class="bouton_Nav bouton">Ajouter une propriété</a>
            <!--on affciche le bouton statistiques UNIQUEMENT si l'utilisateur est un admin, on va donc vérifier si la variable de session $estAdmin est validée-->
        <?php } ?>
        <?php if($estAdmin) { ?>
            <a href="../administration/statistiques.php" class="bouton_Nav bouton">Statistiques</a>
        <?php } ?>
   
    </div>
    
<?php require "../common/footer.php"; ?>

</html><!-- fin de la page -->

    
    
    

 