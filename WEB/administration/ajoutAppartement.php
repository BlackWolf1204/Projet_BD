<?php
require_once("../common/main.php");
require_once("../common/bdd.php");
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset='utf-8'>
	<title>Ajouter un appartement</title>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel='stylesheet' type='text/css' media='screen' href='../style/main.css'>
</head>

<body>
	<h1>Ajouter un appartement</h1>

	<?php
	$immeubles = $bdd->query("SELECT * FROM immeuble");
	// si pas d'immeuble, afficher un message d'erreur
	if ($immeubles->rowCount() == 0) {
		echo "<p>Vous devez d'abord ajouter une prorpriété.</p>";
		echo "<a href='ajoutPropriete.php'>Ajouter une propriété</a>";
		exit();
	}
	?>

	<!-- idImmeuble/nomImmeuble, numAppartement, degreSecurité (faible, moyen, fort), typeAppartement (select récup de la table typeappartement : T1, T2...) -->
	<form target="ajoutAppartement.php" action="post">
		<label for="idImmeuble">Immeuble</label>
		<select name="idImmeuble">
			<?php
			while ($immeuble = $immeubles->fetch()) {
				// si nomImmeuble est null, afficher l'adresse de l'immeuble, sinon afficher le nom de l'immeuble
				$adresse = $immeuble['numRue'] . " " . $immeuble['nomRue'] . ", " . $immeuble['codePostal'] . " " . $immeuble['ville'];
				if ($immeuble['nomImmeuble'] == null) {
					echo "<option value='" . $immeuble['idImmeuble'] . "'>" . $adresse . "</option>";
				} else {
					echo "<option value='" . $immeuble['idImmeuble'] . "'>" . $immeuble['nomImmeuble'] . " (" . $adresse . ")</option>";
				}
			}
			?>
		</select>

		<label for="numAppartement">Numéro de l'appartement</label>
		<input type="text" name="numAppartement" placeholder="123">

		<label for="degreSecurite">Degré de sécurité</label>
		<select name="degreSecurite">
			<option value="faible">Faible</option>
			<option value="moyen">Moyen</option>
			<option value="fort">Fort</option>
		</select>

		<label for="typeAppartement">Type d'appartement</label>
		<select name="typeAppartement">
			<?php
			$typeappartements = $bdd->query("SELECT * FROM typeappartement");
			while ($typeappartement = $typeappartements->fetch()) {
				echo "<option value='" . $typeappartement['typeAppart'] . "'>" . $typeappartement['libTypeAppart'] . "</option>";
			}
			?>
		</select>

		<input type="submit" value="Ajouter">
	</form>
</body>

</html>