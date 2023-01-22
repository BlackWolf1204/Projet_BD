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

function adresseSansNomPropriete($propriete)
{
	return $propriete['numeroRue'] . " " . $propriete['nomRue'] . ", " . $propriete['codePostal'] . " " . $propriete['nomVille'];
}

function adressePropriete($propriete)
{
	$adresse = adresseSansNomPropriete($propriete);
	if ($propriete['nomPropriete'] != null) {
		$labelPropriete = $propriete['nomPropriete'] . " (" . $adresse . ")";
	} else {
		$labelPropriete = $adresse;
	}
	return $labelPropriete;
}

function lienAdressePropriete($propriete, $ROOT)
{
	$idPropriete = $propriete['idPropriete'];
	$lien = $ROOT . "proprietes/detailsPropriete.php?idPropriete=$idPropriete";
	
	$adresse = adresseSansNomPropriete($propriete);
	if ($propriete['nomPropriete'] != null) {
		return "<a href=\"$lien\">" . $propriete['nomPropriete'] . "</a> (" . $adresse . ")";
	} else {
		return "P<a href=\"$lien\">$adresse</a>";
	}
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

function getURLPageAccueil($ROOT)
{
	return $ROOT . "Page_accueil/Page_accueil.php";
}

function getURLConnexion($ROOT)
{
	return $ROOT . "connexion/connexion.php";
}

function pageAccueilSiNonConnecte($estConnecte, $ROOT)
{
	if (!$estConnecte) {
		header("Location: " . getURLPageAccueil($ROOT));
		exit();
	}
}

function lienInfoPersonne($idPersonne, $nomPersonne, $prenomPersonne, $ROOT, $defaut = "Personne")
{
	if($idPersonne == NULL)
		return $defaut;
	return "<a href=\"{$ROOT}administration/infoPersonne.php?idPersonne={$idPersonne}\">{$prenomPersonne} {$nomPersonne}</a>";
}

function lienInfoAppareil($idAppareil, $nomAppareil, $typeAppareil, $ROOT, $defaut = "Appareil inconnu")
{
	if($idAppareil == NULL)
		return $defaut;
	return "<a href=\"{$ROOT}Gestion des appareils/detailsAppareil.php?idAppareil={$idAppareil}\">{$nomAppareil} ({$typeAppareil})</a>";
}