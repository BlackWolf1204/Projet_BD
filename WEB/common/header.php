<?php
 if(!isset($ROOT)) {
	 $ROOT = "../";
 }
 require_once("main.php");

session_start();

    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $url = 'https';
    } else {
        $url = 'http';
    }
    $url .= '://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if (isset($_SESSION["Id"])) {
        $co_deco = "Deconnexion";
        $url_co_deco = "${ROOT}Page_accueil/deconnexion.php";
        $sign_gerer = "Gérer compte";
		$url_sign_gerer = "${ROOT}Page_accueil/gestion_compte.php?id=".$_SESSION['Id'];
    } else {
        $co_deco = "Se connecter";
        $url_co_deco = "${ROOT}Page_accueil/connexion.php";
		$co_admin = "Se connecter en tant qu'administrateur";
		$url_co_admin = "${ROOT}Page_accueil/connexion_administrateur.php";
        $sign_gerer = "S'inscrire";
        $url_sign_gerer = "${ROOT}Page_accueil/inscription.php";
    }
?>
        
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="icon" href="<?=$ROOT?>images/logo.webp" type="image/x-icon" />
<link rel='stylesheet' type='text/css' media='screen' href='<?=$ROOT?>style/main.css'>

</head>

<body>

    <header style="background-color: lightgreen;">
        <h1><a href="<?=$ROOT?>" title="Accueil" style="text-decoration: none;">Projet Maison Économe</a></h1>

		<div class="header-left">
                <img src="<?=$ROOT?>images/logo.webp" alt="logo" class="logo">
            </div>
    
            <div class="header-right">
                <a id="signup" href=<?php echo $url_co_deco; ?>><?php echo $co_deco ; ?></a>
				<a id="login" href=<?php echo $url_sign_gerer; ?>><?php echo $sign_gerer; ?></a>
                <?php
                    if (isset($url_co_admin)) echo "<a id=\"login\" href= $url_co_admin>$co_admin</a>";
                ?>
            </div>	
 		</div>

    </header>

