<?php
$ROOT = "../../";
require_once("{$ROOT}common/main.php");
require_once("{$ROOT}common/fonctions.php");
require_once("{$ROOT}common/verif_est_connecte.php");

// Données du POST :
// type, nbAppartements,
// numeroRue, nomRue, codePostal, nomVille, codeDepartement, nomDepartement, codeRegion, nomRegion,
// nomPropriete, degreIsolation
// pour chaque appartement :
// 		numAppartement_i, degreSecurite_i, typeAppartement_i
//      pour chaque pièces :
//      numPiece_i_j, typePiece_i_j

if (
	!isset($_POST['type']) || !isset($_POST['nbAppartements'])
	|| !isset($_POST['numeroRue']) || !isset($_POST['nomRue']) || !isset($_POST['codePostal']) || !isset($_POST['nomVille'])
	|| !isset($_POST['codeDepartement']) || !isset($_POST['nomDepartement']) || !isset($_POST['codeRegion']) || !isset($_POST['nomRegion'])
	|| !isset($_POST['nomPropriete']) || !isset($_POST['degreIsolation'])
	|| !isset($_POST['numAppartement_1']) || !isset($_POST['degreSecurite_1']) || !isset($_POST['typeAppartement_1'])
	|| !isset($_POST['numPiece_1_1']) || !isset($_POST['typePiece_1_1'])
) {
	if(!isset($_POST['type'])) echo "type non défini<br>";
	if(!isset($_POST['nbAppartements'])) echo "nbAppartements non défini<br>";
	if(!isset($_POST['numeroRue'])) echo "numeroRue non défini<br>";
	if(!isset($_POST['nomRue'])) echo "nomRue non défini<br>";
	if(!isset($_POST['codePostal'])) echo "codePostal non défini<br>";
	if(!isset($_POST['nomVille'])) echo "ville non défini<br>";
	if(!isset($_POST['codeDepartement'])) echo "codeDepartement non défini<br>";
	if(!isset($_POST['nomDepartement'])) echo "nomDepartement non défini<br>";
	if(!isset($_POST['codeRegion'])) echo "codeRegion non défini<br>";
	if(!isset($_POST['nomRegion'])) echo "nomRegion non défini<br>";
	if(!isset($_POST['nomPropriete'])) echo "nomPropriete non défini<br>";
	if(!isset($_POST['degreIsolation'])) echo "degreIsolation non défini<br>";
	if(!isset($_POST['numAppartement_1'])) echo "numAppartement_1 non défini<br>";
	if(!isset($_POST['degreSecurite_1'])) echo "degreSecurite_1 non défini<br>";
	if(!isset($_POST['typeAppartement_1'])) echo "typeAppartement_1 non défini<br>";
	if(!isset($_POST['numPiece_1_1'])) echo "numPiece_1_1 non défini<br>";
	if(!isset($_POST['typePiece_1_1'])) echo "typePiece_1_1 non défini<br>";
	
	die("Erreur : données non valides.");
}

$propriete = proprieteFromPost(); // adresse...
$type = $_POST['type'];
$nbAppartements = $_POST['nbAppartements'];
if ($type == "maison")
	$nbAppartements = 1;

// Chargement des types d'appartements une fois
$typeAppartements = $bdd->query("SELECT * FROM typeappartement");
$typeAppartements = $typeAppartements->fetchAll();

// Chargement des types de pièces une fois
$typePieces = $bdd->query("SELECT * FROM typepiece");
$typePieces = $typePieces->fetchAll();

// Récupération des données des appartements
$appartements = array();
for ($i = 1; $i <= $nbAppartements; $i++) {
	$appartement = array();
	$appartement['numAppartement'] = $_POST["numAppartement_$i"];
	$appartement['degreSecurite'] = $_POST["degreSecurite_$i"];
	$appartement['typeAppart'] = trouveTypeAppartement($typeAppartements, $_POST["typeAppartement_$i"]);
	$nbPiecesAppart = $appartement['typeAppart']['nbPieces'];
	$pieces = array();
	for ($j = 1; $j <= $nbPiecesAppart; $j++) {
		$i_j = $i . "_" . $j;
		$piece = array();
		$piece['numPiece'] = $_POST["numPiece_$i_j"];
		$piece['typePiece'] = trouveTypePiece($typePieces, $_POST["typePiece_$i_j"]);
		$pieces[] = $piece;
	}
	$appartement['pieces'] = $pieces;

	$appartements[] = $appartement;
}

// Insertion dans la base de données
// Démarrer la transaction
$bdd->beginTransaction();

// Ajouter la région si elle n'existe pas
$res = $bdd->prepare("INSERT INTO region (idRegion, nomRegion) VALUES (?, ?)");
$res->execute(array($propriete['codeRegion'], $propriete['nomRegion']));
// Ajouter le déparpartement s'il n'existe pas
$res = $bdd->prepare("INSERT INTO departement (numDepartement, nomDepartement, idRegion) VALUES (?, ?, ?)");
$res->execute(array($propriete['codeDepartement'], $propriete['nomDepartement'], $propriete['codeRegion']));
// Ajouter la ville si elle n'existe pas
$res = $bdd->prepare("SELECT idVille FROM ville WHERE nomVille = ? AND numDepartement = ?");
$res->execute(array($propriete['nomVille'], $propriete['codeDepartement']));
if ($res->rowCount() == 0) {
	$res = $bdd->prepare("INSERT INTO ville (nomVille, codePostal, numDepartement) VALUES (?, ?, ?)");
	$res->execute(array($propriete['nomVille'], $propriete['codePostal'], $propriete['codeDepartement']));
	$idVille = $bdd->lastInsertId();
	if($idVille == 0) {
		$bdd->rollBack();
		echo "INSERT INTO ville (nomVille, codePostal, numDepartement) VALUES ('{$propriete['nomVille']}', '{$propriete['codePostal']}', '{$propriete['codeDepartement']}')<br>";
		die("Erreur : impossible d'ajouter la ville");
	}
} else {
	$idVille = $res->fetch()['idVille'];
}

// Ajouter la rue si elle n'existe pas
$res = $bdd->prepare("SELECT idRue FROM rue WHERE nomRue = ? AND idVille = ?");
$res->execute(array($propriete['nomRue'], $idVille));
if ($res->rowCount() == 0) {
	$res = $bdd->prepare("INSERT INTO rue (nomRue, idVille) VALUES (?, ?)");
	if (!$res) {
		$bdd->rollBack();
		die("Erreur : impossible d'ajouter la rue : " . $bdd->errorInfo()[2]);
	}
	$res->execute(array($propriete['nomRue'], $idVille));
	$idRue = $bdd->lastInsertId();
} else {
	$idRue = $res->fetch()['idRue'];
}

// Ajouter l'adresse si elle n'existe pas
$res = $bdd->query("SELECT idAdresse FROM adresse WHERE numeroRue = '{$propriete['numeroRue']}' AND idRue = '{$idRue}'");
if ($res->rowCount() == 0) {
	$res = $bdd->query("INSERT INTO adresse (numeroRue, idRue) VALUES ('{$propriete['numeroRue']}', '$idRue')");
	if (!$res) {
		$bdd->rollBack();
		die("Erreur : impossible d'ajouter l'adresse : " . $bdd->errorInfo()[2]);
	}
	$idAdresse = $bdd->lastInsertId();
} else {
	$idAdresse = $res->fetch()['idAdresse'];
}

$res = $bdd->prepare("INSERT INTO propriete (idAdresse, nomPropriete, degreIsolation) VALUES (?, ?, ?)");
if(!$res->execute(array($idAdresse, $propriete['nomPropriete'], $_POST['degreIsolation']))) {
	$bdd->rollBack();
	if($res->errorInfo()[2] == "Duplicate entry '$idAdresse' for key 'idAdresse'") {
		echo "Erreur : une propriété existe déjà à cette adresse<br>";
	}
	else {
		echo "Erreur : impossible d'ajouter la propriété<br>{$res->errorInfo()[2]}<br>";
	}
	echo "<a href='{$ROOT}Page_accueil/Page_accueil.php'>Retour à la page d'accueil</a><br>";
	exit();
}

$propriete['idPropriete'] = $bdd->lastInsertId();

foreach ($appartements as $appartement) {
	$res = $bdd->query("INSERT INTO appartement (idPropriete, numAppart, degreSecurite, typeAppart)
		VALUES ({$propriete['idPropriete']}, '{$appartement['numAppartement']}', {$appartement['degreSecurite']}, {$appartement['typeAppart']['typeAppart']})");
	if ($res === false) {
		$bdd->rollBack();
		echo "<p>Erreur : appartement non inséré.</p>";
		for ($i = 0; $i < 3; $i++)
			echo $bdd->errorInfo()[$i] . "<br>";
		exit();
	}
	$appartement['idAppartement'] = $bdd->lastInsertId();
	foreach ($appartement['pieces'] as $piece) {
		$res = $bdd->query("INSERT INTO piece (idAppartement, typePiece)
			VALUES ({$appartement['idAppartement']}, {$piece['typePiece']['typePiece']})");
		if ($res === false) {
			$bdd->rollBack();
			echo "<p>Erreur : pièce non insérée.</p>";
			for ($i = 0; $i < 3; $i++)
				echo $bdd->errorInfo()[$i] . "<br>";
			exit();
		}
	}
}

// Ajout du propriétaire : utilisateur actuel (ou personne si administrateur)
if (!$estAdmin) {
	$aujourdhui = date("Y-m-d");
	$res = $bdd->query("INSERT INTO Proprietaire (idPropriete, datedebutprop, datefinprop, idPersonne) VALUES ({$propriete['idPropriete']}, '$aujourdhui', NULL, $sessionId)");
	if ($res === false) {
		$bdd->rollBack();
		die("<p>Erreur : propriétaire non inséré {$bdd->errorInfo()[2]}</p>");
	}
	$proprietaire = true;
} else {
	$proprietaire = false;
}

// Commit de la transaction
$bdd->commit();
echo "<p>Propriété insérée avec succès.</p>";
if ($proprietaire)
	echo "<p>Vous êtes le propriétaire de cette propriété.</p>";
else {
	echo "<p>En tant qu'administrateur, vous ne pouvez pas être propriétaire de cette propriété.</p>";
	echo "<p>Vous pouvez choisir le nouveau propriétaire depuis la page de gestion des propriétés.</p>";
}
echo "<p>Redirection vers la page d'accueil...</p>";

// Redirection vers la page d'accueil dans 2 secondes
header("Refresh: 2; url={$ROOT}Page_accueil/Page_accueil.php");
