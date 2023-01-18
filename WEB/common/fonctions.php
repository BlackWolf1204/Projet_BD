<?php

function proprieteFromPost()
{
	return array(
		"numeroRue" => $_POST['numeroRue'],
		"nomRue" => $_POST['nomRue'],
		"codePostal" => $_POST['codePostal'],
		"nomVille" => $_POST['nomVille'],
		"nomPropriete" => $_POST['nomPropriete'],
		"codeRegion" => $_POST['codeRegion'],
		"nomRegion" => $_POST['nomRegion'],
		"codeDepartement" => $_POST['codeDepartement'],
		"nomDepartement" => $_POST['nomDepartement'],
	);
}

function adressePropriete($propriete)
{
	$adresse = $propriete['numeroRue'] . " " . $propriete['nomRue'] . ", " . $propriete['codePostal'] . " " . $propriete['nomVille'];
	if ($propriete['nomPropriete'] != null) {
		$labelPropriete = $propriete['nomPropriete'] . " (" . $adresse . ")";
	} else {
		$labelPropriete = $adresse;
	}
	return $labelPropriete;
}

function echoLabelPropriete($propriete)
{
	$labelPropriete = adressePropriete($propriete);
	echo "<div id=\"labelPropriete\">";
	echo "<label for=\"labelPropriete\">Propriété</label> ";
	echo "<span name=\"labelPropriete\" type=\"text\" readonly=true>$labelPropriete</span>";
	echo "</div>";
}

function trouveTypeAppartement($listeTypeAppartements, $typeAppart)
{
	foreach ($listeTypeAppartements as $typeAppartement) {
		if ($typeAppartement['typeAppart'] == $typeAppart) {
			return $typeAppartement;
		}
	}
	echo "<p>Erreur : type d'appartement {$typeAppart} inconnu.</p>";
	exit();
}

function trouveTypePiece($listeTypePieces, $idTypePiece)
{
	foreach ($listeTypePieces as $typePiece) {
		if ($typePiece['typePiece'] == $idTypePiece) {
			return $typePiece;
		}
	}
	echo "<p>Erreur : type de pièce {$idTypePiece} inconnu.</p>";
	exit();
}

function periodeDateDuAu($dateDebut, $dateFin) {
	if($dateFin == NULL) {
		return "du " . date("d/m/Y", strtotime($dateDebut)) . " à aujourd'hui";
	} else {
		return "du " . date("d/m/Y", strtotime($dateDebut)) . " au " . date("d/m/Y", strtotime($dateFin));
	}
}

function pageAccueilSiNonConnecte($ROOT)
{
	if (!isset($_SESSION['Id']) || empty($_SESSION['Id'])) {
		header("Location: {$ROOT}Page_accueil/Page_accueil.php");
		exit();
	}
}