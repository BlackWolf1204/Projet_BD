<?php

// se connecter à la bdd
try {
	$pdo = new PDO("mysql:host=127.0.0.1;dbname=maisoneco", "root", "");
} catch (PDOException $e) {
	echo $e->getMessage();
}

$bdd = $pdo;
