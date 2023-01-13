<?php
$ROOT = '../../';
?>

<!DOCTYPE html>
<html lang="fr">

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

	<?php require("{$ROOT}common/header.php") ?>
	<?php require("{$ROOT}common/verif_est_connecte.php") ?>

	<?php
	if (empty($_POST)) {
		echo "<p>Vous devez d'abord ajouter une propriété.</p>";
		echo "<a href='./ajoutPropriete.php'>Ajouter une propriété</a>";
		exit();
	}

	// Données du POST :
	// type, nbAppartements,
	// numéroRue, nomRue, codePostal, ville, nomPropriete
	// degreIsolation

	$propriete = proprieteFromPost();
	$type = $_POST['type'];
	$nbAppartements = $_POST['nbAppartements'];
	if ($type == "maison")
		$nbAppartements = 1;


	if ($type == "maison") {
		echo "<h2>Configuration de la maison</h2>";
	} else if ($nbAppartements == 1) {
		echo "<h2>Configuration de l'appartement</h2>";
	} else {
		echo "<h2>Configuration des $nbAppartements appartements</h2>";
	}

	?>

	<form action="ajoutPieces.php" method="post">
		<?php echoLabelPropriete($propriete); ?>
		<input type="hidden" name="type" value="<?= $type ?>">
		<input type="hidden" name="nbAppartements" value="<?= $nbAppartements ?>">
		<input type="hidden" name="numéroRue" value="<?= $propriete['numéroRue'] ?>">
		<input type="hidden" name="nomRue" value="<?= $propriete['nomRue'] ?>">
		<input type="hidden" name="codePostal" value="<?= $propriete['codePostal'] ?>">
		<input type="hidden" name="ville" value="<?= $propriete['ville'] ?>">
		<input type="hidden" name="codeDepartement" value="<?= $_POST['codeDepartement'] ?>">
		<input type="hidden" name="nomDepartement" value="<?= $_POST['nomDepartement'] ?>">
		<input type="hidden" name="codeRegion" value="<?= $_POST['codeRegion'] ?>">
		<input type="hidden" name="nomRegion" value="<?= $_POST['nomRegion'] ?>">
		<input type="hidden" name="nomPropriete" value="<?= $propriete['nomPropriete'] ?>">
		<input type="hidden" name="degreIsolation" value="<?= $_POST['degreIsolation'] ?>">

		<!-- Pour une maison (1 ppartment) : degreSecurité (faible, moyen, fort), typeAppartement (select récup de la table typeappartement : T1, T2...) -->
		<!-- Pour les n appartements => numAppartement, degreSecurité (faible, moyen, fort), typeAppartement (select récup de la table typeappartement : T1, T2...) -->
		<?php
		// Chargement des types d'appartements et types de sécurité une fois
		$TypeSecurite = $bdd->query("SELECT * FROM TypeSecurite");
		$TypeSecurite = $TypeSecurite->fetchAll();
		$TypeAppartement = $bdd->query("SELECT * FROM TypeAppartement");
		$TypeAppartement = $TypeAppartement->fetchAll();

		for ($i = 1; $i <= $nbAppartements; $i++) {
		?>

			<div class="infoAppart" appartNum=<?= $i ?>>

				<?php
				$style = "";
				if ($type == "maison") {
					$style = "style=\"display: none;\"";
				}
				echo "<div id=\"numAppartement_$i\" $style>";
				echo "<label for=\"numAppartement_$i\">Numéro d'appartement</label> ";
				echo "<input type=\"text\" name=\"numAppartement_$i\" placeholder=\"$i\" value=\"$i\" size=4>";
				echo "</div>";
				?>

				<div id="degreSecurite_<?= $i ?>">
					<label for="degreSecurite_<?= $i ?>">Degré de sécurité</label>
					<select name="degreSecurite_<?= $i ?>" title="Degré de sécurité du logement">
						<?php
						$default = 2;
						foreach ($TypeSecurite as $TypeSec) {
							$selected = $TypeSec['degreSecurite'] == $default ? "selected" : "";
							echo "<option value='" . $TypeSec['degreSecurite'] . "' $selected>" . $TypeSec['nomSecurite'] . "</option>";
						}
						?>
					</select>
				</div>

				<div id="typeAppartement_<?= $i ?>">
					<label for="typeAppartement_<?= $i ?>">Type de logement</label>
					<select name="typeAppartement_<?= $i ?>" title="Type et taille du logement">
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

	<?php require("{$ROOT}common/footer.php") ?>
	</body>

</html>