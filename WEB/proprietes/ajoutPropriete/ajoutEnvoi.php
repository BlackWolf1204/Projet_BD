<?php
$ROOT = "../../";
require_once("{$ROOT}common/main.php");
require_once("{$ROOT}common/fonctions.php");

// Données du POST :
// type, nbAppartements,
// numéroRue, nomRue, codePostal, ville, nomPropriete
// degreIsolation
// pour chaque appartement :
// 		numAppartement_i, degreSecurite_i, typeAppartement_i
//      pour chaque pièces :
//      numPiece_i_j, typePiece_i_j

$propriete = proprieteFromPost(); // adresse...
$type = $_POST['type'];
$nbAppartements = $_POST['nbAppartements'];
if ($type == "maison")
	$nbAppartements = 1;

$typeAppartements = $bdd->query("SELECT * FROM typeappartement");
$typeAppartements = $typeAppartements->fetchAll();

$typePieces = $bdd->query("SELECT * FROM typepiece");
$typePieces = $typePieces->fetchAll();

$appartements = array();
for ($i = 1; $i <= $nbAppartements; $i++) {
	$appartement = array();
	$appartement['numAppartement'] = $_POST["numAppartement_$i"];
	$appartement['degreSecurite'] = $_POST["degreSecurite_$i"];
	foreach ($typeAppartements as $typeAppartement) {
		if ($typeAppartement['typeAppart'] == $_POST["typeAppartement_$i"]) {
			$appartement['typeAppart'] = $typeAppartement;
			break;
		}
	}
	if (empty($appartement['typeAppart'])) {
		echo "<p>Erreur : type d'appartement {$typeAppart['typeAppart']} inconnu.</p>";
		exit();
	}

	$nbPiecesAppart = $appartement['typeAppart']['nbPieces'];
	$pieces = array();
	for ($j = 1; $j <= $nbPiecesAppart; $j++) {
		$i_j = $i . "_" . $j;
		$piece = array();
		$piece['numPiece'] = $_POST["numPiece_$i_j"];
		foreach ($typePieces as $typePiece) {
			if ($typePiece['typePiece'] == $_POST["typePiece_$i_j"]) {
				$piece['typePiece'] = $typePiece;
				break;
			}
		}
		if (empty($piece['typePiece'])) {
			echo "<p>Erreur : type de pièce {$typePiece['typePiece']} inconnu.</p>";
			exit();
		}
		$pieces[] = $piece;
	}
	$appartement['pieces'] = $pieces;

	$appartements[] = $appartement;
}

// Insertion dans la base de données
// Démarrer la transaction
$bdd->beginTransaction();
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
