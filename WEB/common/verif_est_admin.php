<?php

if (!isset($estAdmin) || $estAdmin != true) {
	echo "<h2>Vous n'avez pas les droits pour accéder à cette page</h2>";
	echo "<a href=\"{$ROOT}Page_accueil/Page_accueil.php\">Retour à l'accueil</a>";
	die();
}
