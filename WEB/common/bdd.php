<?php

// se connecter à la bdd
try {
	$pdo = new PDO("mysql:host=127.0.0.1;dbname=maisoneco;charset=utf8", "root", "");
} catch (PDOException $e) {
	echo $e->getMessage();
	die("Impossible de se connecter à la base de données :<br>" . $e->getMessage());
}

$bdd = $pdo;

if (isset($_SESSION['Id']) && !empty($_SESSION['Id'])) {
	$sessionId = $_SESSION['Id'];
	$estConnecte = true;
	$requser = $bdd->prepare("SELECT COUNT(*) FROM Administrateur WHERE idPersonne = ?");
	$result = $requser->execute(array($sessionId));
	if ($result) {
		$estAdmin = $requser->fetchColumn() > 0;
	} else {
		$estAdmin = false;
	}

	$requser = $bdd->prepare("SELECT Nom, Prenom FROM InfoPersonne WHERE idPersonne = ?");
	$result = $requser->execute(array($sessionId));
	if ($result) {
		$result = $requser->fetch();
		$Prenom = $result['Prenom'];
		$Nom = $result['Nom'];
	} else {
		$sessionId = null;
		$estConnecte = false;
		$estAdmin = false;
		$Prenom = "";
		$Nom = "";
	}
} else {
	$sessionId = null;
	$estConnecte = false;
	$estAdmin = false;
	$Prenom = "";
	$Nom = "";
}
