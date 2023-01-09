<?php

// se connecter à la bdd
try {
	$pdo = new PDO("mysql:host=127.0.0.1;dbname=maisoneco", "root", "");
} catch (PDOException $e) {
	echo $e->getMessage();
	// die("Impossible de se connecter à la base de données :<br>" . $e->getMessage());
}

$bdd = $pdo;

if (isset($_SESSION['Id'])) {
	$result = $bdd->query("SELECT COUNT(*) FROM Administrateur WHERE idPersonne = {$_SESSION['Id']}");
	if ($result) {
		$estAdmin = $result->fetchColumn() > 0;
	} else {
		$estAdmin = false;
	}
}
