<?php
$ROOT = '../';

// Enregistrer les appartements d'une seule fois
if (!empty($_POST)) {
	// Connexion à la base de données
	require('../common/main.php');

	$idPropriete = $_POST['idPropriete'];
	$nbApparts = $_POST['nbApparts'];
	$appartements = array();
	for ($i = 1; $i <= $nbApparts; $i++) {
		$appartements[] = array(
			'numAppartement' => $_POST["numAppartement_$i"],
			'degreSecurite' => $_POST["degreSecurite_$i"],
			'typeAppart' => $_POST["typeAppart_$i"],
		);
	}

	// Ajouter les appartements
	$sql = "INSERT INTO appartement (idPropriete, numAppart, degreSecurite, typeAppart) VALUES ";
	$first = true;
	foreach ($appartements as $appartement) {
		if (!$first)
			$sql .= ", ";
		$sql .= "($idPropriete, {$appartement['numAppartement']}, {$appartement['degreSecurite']}, '{$appartement['typeAppart']}')";
		$first = false;
	}
	$result = $bdd->query($sql);
	if (!$result) {
		echo "Error: " . $sql . "<br>" . $bdd->error;
	} else {
		// Ajouter les pièces
		header("Location: ajoutPieces.php?idPropriete=$idPropriete&nbApparts=$nbApparts");
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<title>Ajouter un appartement</title>
	<style>
		.infoAppart {
			border: 1px solid black;
			margin: 1em 0;
			padding: 1em;
			width: fit-content;
		}
	</style>

	<?php require('../common/header.php') ?>

	<?php
	if (isset($_GET['idPropriete']))
		$idPropriete = $_GET['idPropriete'];
	else if (isset($_GET['debug_dont_redirect'])) {
		$idPropriete = 1;
	} else {
		echo "<p>Vous devez d'abord ajouter une propriété.</p>";
		echo "<a href='ajoutPropriete.php'>Ajouter une propriété</a>";
		exit();
	}

	$nbApparts = isset($_GET['nbApparts']) ? $_GET['nbApparts'] : 1;
	$type = isset($_GET['type']) ? $_GET['type'] : "immeuble";

	if ($type == "maison")
		$nbApparts = 1;

	$proprieteQuery = $bdd->query("SELECT * FROM propriete WHERE idPropriete = $idPropriete");
	if ($proprieteQuery) {
		$propriete = $proprieteQuery->fetch();
	}
	if (!$propriete && isset($_GET['debug_dont_redirect'])) {
		$propriete = array(
			'idPropriete' => 1,
			'nomPropriete' => 'Maison',
			'numeroRue' => '123',
			'nomRue' => 'Rue de la maison',
			'codePostal' => '12345',
			'ville' => 'Ville de la maison'
		);
	}
	?>

	<?php
	if ($type == "maison") {
		echo "<h2>Configuration de la maison</h2>";
	} else if ($nbApparts == 1) {
		echo "<h2>Configuration de l'appartement</h2>";
	} else {
		echo "<h2>Configuration des $nbApparts appartements</h2>";
	}
	?>

	<form action="ajoutAppartement.php" method="post">
		<!-- idPropriete/nomPropriete/adresse -->
		<div id="labelPropriete">
			<label for="labelPropriete">Propriété</label>
			<?php
			// si nomPropriete est null, afficher l'adresse de la propriété, sinon afficher le nom de la propriété
			$adresse = $propriete['numeroRue'] . " " . $propriete['nomRue'] . ", " . $propriete['codePostal'] . " " . $propriete['ville'];
			if ($propriete['nomPropriete'] != null) {
				$labelPropriete = $propriete['nomPropriete'] . " (" . $adresse . ")";
			} else {
				$labelPropriete = $adresse;
			}
			?>
			<span name="labelPropriete" type="text" readonly=true><?= $labelPropriete ?></span>
		</div>
		<input type="hidden" name="idPropriete" value="<?= $propriete['idPropriete'] ?>">
		<input type="hidden" name="nbApparts" value="<?= $nbApparts ?>">

		<!-- Pour une maison (1 ppartment) : degreSecurité (faible, moyen, fort), typeAppartement (select récup de la table typeappartement : T1, T2...) -->
		<!-- Pour les n appartements => numAppartement, degreSecurité (faible, moyen, fort), typeAppartement (select récup de la table typeappartement : T1, T2...) -->
		<?php
		$TypeSecurite = $bdd->query("SELECT * FROM TypeSecurite");
		$TypeSecurite = $TypeSecurite->fetchAll();
		$TypeAppartement = $bdd->query("SELECT * FROM TypeAppartement");
		$TypeAppartement = $TypeAppartement->fetchAll();

		for ($i = 1; $i <= $nbApparts; $i++) {
		?>

			<div class="infoAppart" appartNum=<?= $i ?>>

				<?php
				if ($type != "maison") {
					echo "<div id=\"numAppartement_$i\">";
					echo "<label for=\"numAppartement_$i\">Numéro d'appartement</label> ";
					echo "<input type=\"text\" name=\"numAppartement_$i\" placeholder=\"$i\" value=\"$i\" size=4>";
					echo "</div>";
				}
				?>

				<div id="degreSecurite_<?= $i ?>">
					<label for="degreSecurite_<?= $i ?>">Degré de sécurité</label>
					<select name="degreSecurite_<?= $i ?>">
						<?php
						$default = 2;
						foreach ($TypeSecurite as $TypeSec) {
							$selected = $TypeSec['degreSecurite'] == $default ? "selected" : "";
							echo "<option value='" . $TypeSec['degreSecurite'] . "' $selected>" . $TypeSec['nomSecurite'] . "</option>";
						}
						?>
					</select>
				</div>

				<div id="typeAppart_<?= $i ?>">
					<label for="typeAppart_<?= $i ?>">Type de logement</label>
					<select name="typeAppart_<?= $i ?>">
						<?php
						foreach ($TypeAppartement as $TypeAppart) {
							echo "<option value='" . $TypeAppart['typeAppart'] . "'>" . $TypeAppart['libTypeAppart'] . "</option>";
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