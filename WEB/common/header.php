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

<link rel="icon" href="<?= $ROOT ?>common/images/favicon.ico" type="image/x-icon" />
<link rel='stylesheet' type='text/css' media='screen' href='<?= $ROOT ?>style/main.css'>
<script src="<?= $ROOT ?>common/vanta/p5.min.js"></script>
<script src="<?= $ROOT ?>common/vanta/vanta.topology.min.js"></script>

</head>

<body>

    <header style="background-color: lightgreen;">
        <h1><a href="<?= $ROOT ?>Page_accueil/Page_accueil.php" title="Accueil" style="text-decoration: none;">Projet Maison Économe</a></h1>

        <div class="header-left">
            <img src="<?= $ROOT ?>common/images/logo.webp" alt="logo" class="logo">
        </div>

        <div class="header-right">
            <?php
            if (!isset($_SESSION['Id'])) {
                echo "<a id=\"signup\" href=\"{$ROOT}Page_accueil/inscription.php\">S'inscrire</a>";
                echo "<a id=\"login\" href=\"{$ROOT}Page_accueil/connexion.php\">Se connecter</a>";
                echo "<a id=\"login_admin\" href=\"{$ROOT}Page_accueil/connexion_administrateur.php\">Se connecter en tant qu'administrateur</a>";
            } else {
                echo "<a id=\"logout\" href=\"{$ROOT}Page_accueil/deconnexion.php\">Se déconnecter</a>";
                echo "<a id=\"manage_account\" href=\"{$ROOT}Page_accueil/gestion_compte.php\">Gérer son compte</a>";
            }
            ?>
        </div>
        </div>

    </header>
    <div class="vantatopologymin" id="vantatopologymin_1"></div>