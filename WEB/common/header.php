<?php
 $ROOT = "../";
 require_once("main.php");

 session_start();           
 if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
	 $url = 'https';
 }
 else {
	 $url = 'http';
 }

 $url .= '://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
 
 if (isset($_SESSION["utilisateur"])) {
     $co_deco = "Deconnexion";
	 $url_co_deco = "../Page_accueil/Deconexion.php";
	 $sign_gerer = "Gérer compte";
	 $url_sign_gerer = "../Page_accueil/gestion_compte.html";
 }
 else {
     $co_deco = "Se connecter";
	 $url_co_deco = "../Page_accueil/connexion.html";
	 $sign_gerer = "S'inscrire";
	 $url_sign_gerer = "../Page_creation_compte/page_creation_compte.html";
 }
?>
        
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel='stylesheet' type='text/css' media='screen' href='style/main.css'>

</head>

<body>

    <header style="background-color: lightgreen;">
        <h1><a href="<?php echo $ROOT; ?>" title="Accueil" style="text-decoration: none;">Projet Maison Économe</a></h1>

		<div class="header-left">
                <img src="images/logo.png" alt="logo" class="logo">
            </div>
    
            <div class="header-right">
                <a id="signup" href=<?php echo $url_co_deco; ?>><?php echo $sign_gerer; ?></a>
		        <a id="login" href=<?php echo $url_sign_gerer; ?>><?php echo $co_deco; ?></a>
            </div>

    </header>