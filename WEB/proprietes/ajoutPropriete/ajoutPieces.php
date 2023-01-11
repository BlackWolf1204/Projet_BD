<?php
$ROOT = '../../';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Ajouter les pièces</title>
	<style>
		.infoPiece {
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
	// pour chaque appartement :
	// numAppartement_i, degreSecurite_i, typeAppartement_i

	$propriete = proprieteFromPost();
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
		$appartements[] = $appartement;
	}

	// Vérifier qu'aucun numéro d'appartement n'est en double
	$numsAppartements = array();
	foreach ($appartements as $appartement) {
		$numsAppartements[] = $appartement['numAppartement'];
	}
	if (count($numsAppartements) != count(array_unique($numsAppartements))) {
		echo "<p>Vous avez entré plusieurs fois le même numéro d'appartement.</p>";
		exit();
	}

	$nbPieces = 0;
	foreach ($appartements as $appartement) {
		$nbPieces += $appartement['typeAppart']['nbPieces'];
	}

	if ($nbAppartements == 1) {
		if ($nbPieces == 1)
			echo "<h2>Configuration de la pièce de l'appartement</h2>";
		else
			echo "<h2>Configuration des $nbPieces pièces de l'appartement</h2>";
	} else {
		echo "<h2>Configuration des $nbPieces pièces des $nbAppartements appartements</h2>";
	}
	?>

	<form action="ajoutEnvoi.php" method="post">
		<?php echoLabelPropriete($propriete); ?>
		<input type="hidden" name="type" value="<?= $type ?>">
		<input type="hidden" name="nbAppartements" value="<?= $nbAppartements ?>">
		<input type="hidden" name="numéroRue" value="<?= $propriete['numéroRue'] ?>">
		<input type="hidden" name="nomRue" value="<?= $propriete['nomRue'] ?>">
		<input type="hidden" name="codePostal" value="<?= $propriete['codePostal'] ?>">
		<input type="hidden" name="ville" value="<?= $propriete['ville'] ?>">
		<input type="hidden" name="nomPropriete" value="<?= $propriete['nomPropriete'] ?>">
		<input type="hidden" name="degreIsolation" value="<?= $_POST['degreIsolation'] ?>">

		<!-- Pour une maison (1 ppartment) : degreSecurité (faible, moyen, fort), typeAppartement (select récup de la table typeappartement : T1, T2...) -->
		<!-- Pour les n appartements => numAppartement, degreSecurité (faible, moyen, fort), typeAppartement (select récup de la table typeappartement : T1, T2...) -->
		<?php

		for ($i = 1; $i <= $nbAppartements; $i++) {
			$appartement = $appartements[$i - 1];
			$typeAppartement = trouveTypeAppartement($typeAppartements, $appartement['typeAppart']['typeAppart']);
		?>

			<div class="infoAppart" appartNum=<?= $i ?>>

				<h2 id="numAppartement_<?= $i ?>">Appartement numéro <?= $i ?></h2>
				<input type="hidden" name="numAppartement_<?= $i ?>" value="<?= $i ?>">
				<input type="hidden" name="degreSecurite_<?= $i ?>" value="<?= $appartement['degreSecurite'] ?>">
				<input type="hidden" name="typeAppartement_<?= $i ?>" value="<?= $typeAppartement['typeAppart'] ?>">
				<p>Type : <?= $typeAppartement['libTypeAppart'] ?></p>

				<?php
				$nbPiecesAppart = $typeAppartement['nbPieces'];
				for ($j = 1; $j <= $nbPiecesAppart; $j++) {
					$i_j = $i . "_" . $j;
				?>
					<div class="infoPiece" pieceNum=<?= $j ?>>
						<h3 id="numPiece_<?= $i_j ?>">Pièce numéro <?= $j ?></h3>
						<input type="hidden" name="numPiece_<?= $i_j ?>" value="<?= $j ?>">
						<label for="typePiece_<?= $i_j ?>">Type de pièce</label>
						<select name="typePiece_<?= $i_j ?>" id="typePiece_<?= $i_j ?>">
							<?php
							foreach ($typePieces as $typePiece) {
								$id = $typePiece['typePiece'];
								$libelle = iconv('ISO-8859-1', 'UTF-8', $typePiece['libTypePiece']);
								echo "<option value='$id'>$libelle</option>";
							}
							?>
						</select>
					</div>
				<?php
				}
				?>

			</div>

		<?php
		}
		?>

		<input type="submit" value="Ajouter">
	</form>

	<?php require("{$ROOT}common/footer.php") ?>
	</body>

</html>