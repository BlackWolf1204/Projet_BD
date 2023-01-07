<?php

function adressePropriete($propriete)
{
	$adresse = $propriete['numeroRue'] . " " . $propriete['nomRue'] . ", " . $propriete['codePostal'] . " " . $propriete['ville'];
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
