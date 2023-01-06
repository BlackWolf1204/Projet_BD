<!--        //SITE D'UNE MAISON ECONOME EN ENERGIE // -->
<!--        
    Cette page sera la page d'accueil de notre site web. 
     Elle sera divisée en 3 parties :
     (1) L'entête : où nous mettrons un bouton de connexion, une image de fond (à définir), et un bouton de gestion du compte en haut à droite.
     (2) Le corps de la page : où nous mettrons une image de fond avec du texte et différents liens vers les autres pages.
     (3) Le pied de page : où nous mettrons nos noms et prénoms.
 -->

 <!DOCTYPE html><!-- déclaration du type de document HTML -->

 <html lang="fr"><!-- déclaration de la langue de la page -->
 
 <head><!-- début de l'entête de la page -->

    <title>Page d'acceuil</title><!-- déclaration du titre de la page -->

        <?php require "../common/header.php"?>
    
        <div class="body-left"><!-- début de la classe body-left -->
    
            <img src="images/accueil.jpg" alt="accueil" class="accueil"><!-- déclaration de la classe accueil -->

            <!-- Ci dessous on programme en Java Script , même si cela n'est pas indispensable 
            , je trouve que en terme d'investissemnt visuel ça en vaut la peine
            lien : https://www.vantajs.com/?effect=topology -->

            <div id="vantatopologymin"></div><!-- ID de l'élément HTML -->
            <script src="p5.min.js"></script>
            <script src="vanta.topology.min.js"></script>
            <script>

            // Ajout de l'effet d'image dynamique de fond 
            VANTA.TOPOLOGY(
            {
                el: "#vantatopologymin", // ID de l'élément HTML
                mouseControls: true,
                touchControls: true,
                gyroControls: false,
                minHeight: 200.00,
                minWidth: 200.00,
                scale: 1.00,
                scaleMobile: 1.00
            }
            )
                </script>
            <style>
                .vanta-canvas {
                    position: relative !important;
                }
            </style>
            
        </div><!-- fin de la classe body-left -->
    
        <div class="body-right"><!-- début de la classe body-right -->
    
            <h1>BIENVENUE SUR NOTRE SITE</h1><!-- titre de la page -->
    
            <p><b>De nos jours il est important de faire des economies en energie,
                 ce site va permetre d'avoir un control sur l'ensemble de vos appartement ....</b></p><!-- paragraphe d'introduction -->
    
            <a href="../administration/gererConso.php" class="bouton">Regarder sa consomation/production</a><!-- déclaration de la classe bouton -->
    
            <a href="../administration/gererAppareil.php" class="bouton">Gerer ses appareils</a><!-- déclaration de la classe bouton -->

            <a href="../administration/gererPropriete.php" class="bouton">Gerer sa/ses propriété(s)</a><!-- déclaration de la classe bouton -->
            
            <a href="../administration/ajoutPropriete.php" class="bouton">Ajouter une propriété</a><!-- déclaration de la classe bouton -->
            <!-- <a href="statistiques.php" class="bouton">Statistiques</a>  seulement pour admins -->
            
        </div><!-- fin de la classe body-right -->
    


    </div><!-- fin de la classe body -->
    
</body><!-- fin du corps de la page -->

<?php require "../common/footer.php"; ?>

</html><!-- fin de la page -->

    
    
    

 