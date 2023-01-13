<?php
if (!$estConnecte) {
	echo "<p>Vous devez être connecté pour effectuer cette action.</p>";
	echo "<a href=\"{$ROOT}Page_accueil/Page_accueil.php\">Retour à l'accueil</a>";
	exit();
}

// Vérifier si la session est valide
$requser = $bdd->prepare("SELECT COUNT(*) FROM InfoPersonne WHERE idPersonne = ?");
$res = $requser->execute(array($sessionId));
if (!$res || $requser->fetchColumn() == 0) {
	echo "<p>Votre session a expiré. Veuillez vous reconnecter.</p>";
	$_SESSION = array();
	exit();
}
