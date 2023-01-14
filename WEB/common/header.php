<?php
if (!isset($ROOT)) {
    $ROOT = "../";
}
require_once("main.php");
require_once("fonctions.php");


if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $url = 'https';
} else {
    $url = 'http';
}
$url .= '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="icon" href="<?= $ROOT ?>common/images/Green_house.ico" type="image/x-icon" />
        <link rel='stylesheet' type='text/css' media='screen' href='<?= $ROOT ?>common/style/main.css'>
        <script src="<?= $ROOT ?>common/vanta/p5.min.js"></script>
        <script src="<?= $ROOT ?>common/vanta/vanta.topology.min.js"></script>

</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container">
<img src=  "<?= $ROOT ?>common/images/Green_house.webp" alt="Green_house" width="20" height="20" style="float:left; margin:0 25px 0 0;" />

    <a class="navbar-brand" href="<?= $ROOT ?>Page_accueil/Page_accueil.php"><b>Green House </b></a>
    <button class="navbar-toggler" type="carousel-btn" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <?php
       if (!$estConnecte) 
        {
            echo "<li class='nav-item'><a class='nav-link' href='{$ROOT}Page_accueil/inscription.php'>S'inscrire</a></li>";
            echo "<li class='nav-item'><a class='nav-link' href='{$ROOT}Page_accueil/connexion.php'>Se connecter (utilisateur)</a></li>";
            echo "<li class='nav-item'><a class='nav-link' href='{$ROOT}Page_accueil/connexion_administrateur.php'>Se connecter (admin)</a></li>";
        }
        else
        {
            echo "<li class='nav-item'><a class='nav-link' href='{$ROOT}Page_accueil/deconnexion.php'>Se déconnecter</a></li>";
            echo "<li class='nav-item'><a class='nav-link' href='{$ROOT}Page_accueil/mon_compte.php'>Mon compte</a></li>";
        }
        ?>
        </ul>
    </div>
    </div>
    
        
</nav>


    <br><br>

    <div class="vantatopologymin" id="vantatopologymin_1"></div>
   

    <?php if(!($estConnecte)) { ?>
            <!-- on affiche une image de fond avec un texte qui explique le site , l'image sera d'une opacite plus legere pour que le texte soit lisible -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                <!-- pour mettre de la bordure sur l'image, on peut utiliser la classe img-thumbnail -->
                <img class="d-block w-100" src="<?= $ROOT ?>common/images/appareil.webp" alt="Green House"; style="opacity: 3; image-thumnail: 5px; border: 10px solid black; object-fit: fill; height: 100%; width: 100%; ">
                <div class="carousel-caption center"style=" ; "><!-- les parametre de object-fit sont : fill, contain, cover, none, scale-down -->
                    <h1  style="color: Green; font-size: 50px; font-weight: bold; text-shadow: 6px 6px 10px #000000;">Green House</h1>
                    <p  style="color: White; font-size: 20px; font-weight: bold; text-shadow: 8px 8px 10px #000000;">Contrôler votre consommation d'energies  </p>
                    <p  style="color: White; font-size: 20px; font-weight: bold; text-shadow: 8px 8px 10px #000000;">afin de réduire vos émissions de substances nocives </p>

            </div>


        </div>

    </div>




  
<?php } ?>



           



        











       
