
 <!DOCTYPE html><!-- déclaration du type de document HTML -->

 <html lang="fr"><!-- déclaration de la langue de la page -->
 
 <head><!-- début de l'entête de la page -->

    <title>Page d'acceuil</title><!-- déclaration du titre de la page -->

        <?php require "../common/header.php"?>
    
        <div class="body-left"><!-- début de la classe body-left -->
    
            <img src="images/accueil.jpg" alt="accueil" class="accueil"><!-- déclaration de la classe accueil -->

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
    
            <a href="qqchose1.html" class="bouton">qqchose1</a><!-- déclaration de la classe bouton -->
    
            <a href="qqchose2.html" class="bouton">qqchose2</a><!-- déclaration de la classe bouton -->

            <a href="qqchose3.html" class="bouton">qqchose3</a><!-- déclaration de la classe bouton -->




        </div><!-- fin de la classe body-right -->
    


    </div><!-- fin de la classe body -->
    
</body><!-- fin du corps de la page -->

<?php require "../common/footer.php"; ?>

</html><!-- fin de la page -->

    
    
    

 