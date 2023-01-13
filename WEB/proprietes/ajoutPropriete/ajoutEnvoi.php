<?php
$ROOT = "../../";
require_once("{$ROOT}common/main.php");
require_once("{$ROOT}common/fonctions.php");
require_once("{$ROOT}common/verif_est_connecte.php");

// Données du POST :
// type, nbAppartements,
// numéroRue, nomRue, codePostal, ville, codeDepartement, nomDepartement, codeRegion, nomRegion,
// nomPropriete, degreIsolation
// pour chaque appartement :
// 		numAppartement_i, degreSecurite_i, typeAppartement_i
//      pour chaque pièces :
//      numPiece_i_j, typePiece_i_j

if (
	!isset($_POST['type']) || !isset($_POST['nbAppartements'])
	|| !isset($_POST['numéroRue']) || !isset($_POST['nomRue']) || !isset($_POST['codePostal']) || !isset($_POST['ville'])
	|| !isset($_POST['codeDepartement']) || !isset($_POST['nomDepartement']) || !isset($_POST['codeRegion']) || !isset($_POST['nomRegion'])
	|| !isset($_POST['nomPropriete']) || !isset($_POST['degreIsolation'])
	|| !isset($_POST['numAppartement_1']) || !isset($_POST['degreSecurite_1']) || !isset($_POST['typeAppartement_1'])
	|| !isset($_POST['numPiece_1_1']) || !isset($_POST['typePiece_1_1'])
) {
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
$res = $bdd->query("INSERT INTO region (codeRegion, nomRegion) VALUES ('{$propriete['codeRegion']}', '{$propriete['nomRegion']}')");
// Ajouter le déparpartement s'il n'existe pas
$res = $bdd->query("INSERT INTO departement (codeDepartement, nomDepartement, codeRegion) VALUES ('{$propriete['codeDepartement']}', '{$propriete['nomDepartement']}', '{$propriete['codeRegion']}')");
// Ajouter la ville si elle n'existe pas
$res = $bdd->query("SELECT idVille FROM ville WHERE nomVille = '{$propriete['ville']}' AND codeDepartement = '{$propriete['codeDepartement']}'");
if ($res->rowCount() == 0) {
	$res = $bdd->query("INSERT INTO ville (codePostal, nomVille, codeDepartement) VALUES ('{$propriete['codePostal']}', '{$propriete['ville']}', '{$propriete['codeDepartement']}')");
	$idVille = $bdd->lastInsertId();
} else {
	$idVille = $res->fetch()['idVille'];
}
// Ajouter la rue si elle n'existe pas
$res = $bdd->query("SELECT idRue FROM rue WHERE nomRue = '{$propriete['nomRue']}' AND idVille = '{$idVille}'");
if ($res->rowCount() == 0) {
	$res = $bdd->query("INSERT INTO rue (nomRue, idVille) VALUES ('{$propriete['nomRue']}', '$idVille')");
	$idRue = $bdd->lastInsertId();
} else {
	$idRue = $res->fetch()['idRue'];
}
// Ajouter l'adresse si elle n'existe pas
$res = $bdd->query("SELECT idAdresse FROM adresse WHERE numeroRue = '{$propriete['numéroRue']}' AND idRue = '{$idRue}'");
if ($res->rowCount() == 0) {
	$res = $bdd->query("INSERT INTO adresse (numeroRue, idRue) VALUES ('{$propriete['numéroRue']}', '$idRue')");
	$idAdresse = $bdd->lastInsertId();
} else {
	$idAdresse = $res->fetch()['idAdresse'];
}




$res = $bdd->query("INSERT INTO propriete (numeroRue, nomRue, codePostal, ville, nomPropriete, degreIsolation)
	VALUES ('{$propriete['numéroRue']}', '{$propriete['nomRue']}', '{$propriete['codePostal']}', '{$propriete['ville']}', '{$propriete['nomPropriete']}', '{$_POST['degreIsolation']}')");
if ($res === false) {
	$bdd->rollBack();
	echo "<p>Erreur : propriété non insérée.</p>";
	for ($i = 0; $i < 3; $i++)
		echo $bdd->errorInfo()[$i] . "<br>";
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

// Commit de la transaction
$bdd->commit();
echo "<p>Propriété insérée avec succès.</p>";
echo "<p>Redirection vers la page d'accueil...</p>";

// Redirection vers la page d'accueil dans 2 secondes
header("Refresh: 2; url={$ROOT}Page_accueil/Page_accueil.php");
