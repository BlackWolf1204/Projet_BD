<?php
$ROOT = "../";
require_once '../common/main.php';

if(!$estConnecte)
{
	header("Location: connexion.php");
	exit();
}

if (!isset($_GET['idAppareil'])) {
	echo "Erreur : aucun identifiant d'appareil envoyé";
	exit();
}
$idAppareil = $_GET['idAppareil'];

if(!isset($_GET['etat'])) {
	echo "Erreur : aucun état envoyé";
	exit();
}
switch(mb_strtolower($_GET['etat'])) {
	case "true":
	case "on":
	case "1":
		$etat = true;
		break;
	case "false":
	case "off":
	case "0":
	case "":
		$etat = false;
		break;
	default:
		echo "Erreur : état invalide";
		exit();
}

// Vérifier que l'appareil appartient bien à l'utilisateur, ou que l'utilisateur est un administrateur
if(!$estAdmin) {
	$req = $bdd->prepare('SELECT COUNT(*) FROM Appareil NATURAL JOIN Piece NATURAL JOIN Appartement NATURAL JOIN Locataire WHERE idAppareil = ? AND idLocataire = ?');
	$req->execute(array($idAppareil, $sessionId));
	$nbAppareils = $req->fetchColumn();
	if($nbAppareils == 0) {
		echo "Erreur : l'appareil ne vous appartient pas";
		exit();
	}
}

// Vérifier l'état de l'appareil
$req = $bdd->prepare('SELECT idConsommation, dateOn, dateOff FROM HistoriqueConsommation WHERE idAppareil = ? ORDER BY dateOn DESC LIMIT 1');
$req->execute(array($idAppareil));
$historique = $req->fetch();

$ancienEtat = false; // été allumé que s'il existe un historique et que le plus récent a une dateOff à null
if($historique) {
	$ancienEtat = $historique['dateOff'] == null;
}

if($etat) {
	// Allumer l'appareil
	if($ancienEtat == $etat) {
		echo '{"message": "Erreur : l\'appareil est déjà allumé", "error": true, "etat": true}';
		exit();
	}
	$req = $bdd->prepare('INSERT INTO HistoriqueConsommation (idAppareil, dateOn) VALUES (?, NOW())');
	$req->execute(array($idAppareil));
	echo '{"message": "Appareil allumé", "error": false, "etat": true}';
} else {
	// Éteindre l'appareil
	if($ancienEtat == $etat) {
		echo '{"message": "Erreur : l\'appareil est déjà éteint", "error": true, "etat": false}';
		exit();
	}
	$req = $bdd->prepare('UPDATE HistoriqueConsommation SET dateOff = NOW() WHERE idConsommation = ?');
	$req->execute(array($historique['idConsommation']));
	echo '{"message": "Appareil éteint", "error": false, "etat": false}';
}
