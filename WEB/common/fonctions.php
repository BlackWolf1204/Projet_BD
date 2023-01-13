<?php

function proprieteFromPost()
{
	return array(
		"numéroRue" => $_POST['numéroRue'],
		"nomRue" => $_POST['nomRue'],
		"codePostal" => $_POST['codePostal'],
		"ville" => $_POST['ville'],
		"nomPropriete" => $_POST['nomPropriete']
	);
}

function adressePropriete($propriete)
{
	$adresse = $propriete['numéroRue'] . " " . $propriete['nomRue'] . ", " . $propriete['codePostal'] . " " . $propriete['ville'];
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
