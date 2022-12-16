<?php

// se connecter à la bdd
try {
	$pdo = new PDO("mysql:host=localhost;dbname=maisoneco", "root", "");
} catch (PDOException $e) {
	echo $e->getMessage();
}

$bdd = $pdo;
