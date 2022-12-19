<?php
$ROOT = "../";
require_once("../common/main.php");
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset='utf-8'>
	<title>Ajouter un appartement</title>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel='stylesheet' type='text/css' media='screen' href='../style/main.css'>
	<style>
		.infoAppart {
			border: 1px solid black;
			margin: 1em 0;
			padding: 1em;
			width: fit-content;
		}
	</style>
</head>

<body>
	<?php require('../common/header.php') ?>

	<?php
	if (isset($_POST['idPropriete']))
		$idPropriete = $_POST['idPropriete'];
	else if (isset($_GET['debug_dont_redirect'])) {
		$idPropriete = 1;
	} else {
		echo "<p>Vous devez d'abord ajouter une propriété.</p>";
		echo "<a href='ajoutPropriete.php'>Ajouter une propriété</a>";
		exit();
	}

	if (isset($_POST['numApparts']))
		$numApparts = $_POST['numApparts'];
	else
		$numApparts = 1;
	if (isset($_POST['estMaison']))
		$estMaison = $_POST['estMaison'];
	else
		$estMaison = false;

	if ($estMaison == true)
		$numApparts = 1;

	$proprieteQuery = $bdd->query("SELECT * FROM propriete WHERE idPropriete = $idPropriete");
	if ($proprieteQuery) {
		$propriete = $proprieteQuery->fetch();
	}
	if (!$propriete && isset($_GET['debug_dont_redirect'])) {
		$propriete = array(
			'idPropriete' => 1,
			'nomPropriete' => 'Maison',
			'numRue' => '123',
			'nomRue' => 'Rue de la maison',
			'codePostal' => '12345',
			'ville' => 'Ville de la maison'
		);
	}
	?>

	<?php
	if ($estMaison == true) {
		echo "<h2>Type de maison</h2>";
	} else if ($numApparts == 1) {
		echo "<h2>Type de l'appartement</h2>";
	} else {
		echo "<h2>Type des $numApparts appartements</h2>";
	}
	?>

	<form action="ajoutAppartement.php" method="post">
		<!-- idPropriete/nomPropriete/adresse -->
		<div id="labelPropriete">
			<label for="labelPropriete">Propriété</label>
			<?php
			// si nomPropriete est null, afficher l'adresse de la propriété, sinon afficher le nom de la propriété
			$adresse = $propriete['numRue'] . " " . $propriete['nomRue'] . ", " . $propriete['codePostal'] . " " . $propriete['ville'];
			if ($propriete['nomPropriete'] != null) {
				$labelPropriete = $propriete['nomPropriete'] . " (" . $adresse . ")";
			} else {
				$labelPropriete = $adresse;
			}
			?>
			<span name="labelPropriete" type="text" readonly=true><?= $labelPropriete ?></span>
		</div>

		<!-- Pour une maison (1 ppartment) : degreSecurité (faible, moyen, fort), typeAppartement (select récup de la table typeappartement : T1, T2...) -->
		<!-- Pour les n appartements => numAppartement, degreSecurité (faible, moyen, fort), typeAppartement (select récup de la table typeappartement : T1, T2...) -->
		<?php
		for ($i = 1; $i <= $numApparts; $i++) {
		?>

			<div class="infoAppart" appartNum=<?= $i ?>>

				<?php
				if ($estMaison == true) {
					echo "<div id=\"numAppartement\">";
					echo "<label for=\"numAppartement\">Numéro d'appartement</label>";
					echo "<input type=\"text\" name=\"numAppartement\" placeholder=\"123\">";
					echo "</div>";
				}
				?>

				<div id="degreSecurite">
					<label for="degreSecurite">Degré de sécurité</label>
					<select name="degreSecurite">
						<option value="faible">Faible</option>
						<option value="moyen">Moyen</option>
						<option value="fort">Fort</option>
					</select>
				</div>

				<div id="typeAppart">
					<label for="typeAppart">Type de logement</label>
					<select name="typeAppart">
						<?php
						$typeappartements = $bdd->query("SELECT * FROM typeappartement");
						while ($typeappartement = $typeappartements->fetch()) {
							echo "<option value='" . $typeappartement['typeAppart'] . "'>" . $typeappartement['libTypeAppart'] . "</option>";
						}
						?>
					</select>
				</div>

			</div>

		<?php
		}
		?>

		<input type="submit" value="Ajouter">
	</form>

	<?php require('../common/footer.php') ?>
</body>

</html>