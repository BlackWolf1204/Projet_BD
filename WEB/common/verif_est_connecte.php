<?php
if (!$estConnecte) {
	echo "<p>Vous devez être connecté pour effectuer cette action.</p>";
	exit();
}

// Vérifier si la session est valide
$requser = $bdd->query("SELECT COUNT(*) FROM InfoPersonne WHERE idPersonne = ?");
$requser->execute(array($sessionId));
if (!$res || $res->fetchColumn() == 0) {
	echo "<p>Votre session a expiré. Veuillez vous reconnecter.</p>";
	$_SESSION = array();
	exit();
}
