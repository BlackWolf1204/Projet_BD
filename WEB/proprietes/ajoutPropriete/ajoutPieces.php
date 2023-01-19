<?php
$ROOT = '../../';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Ajouter les pièces</title>
	<style>
		#labelPropriete {
			text-align: center;
		}
		.infoPiece {
			border: 1px solid black;
			margin: 1em auto;
			padding: 1em;
			width: fit-content;
		}
		.infoAppart > p {
			text-align: center;
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
	// numeroRue, nomRue, codePostal, ville, nomPropriete
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
		$lappartement = $type == "maison" ? "la maison" : "l'appartement";
		if ($nbPieces == 1)
			echo "<h2>Configuration de la pièce de $lappartement</h2>";
		else
			echo "<h2>Configuration des $nbPieces pièces de $lappartement</h2>";
	} else {
		echo "<h2>Configuration des $nbPieces pièces des $nbAppartements appartements</h2>";
	}
	?>

	<form action="ajoutEnvoi.php" method="post">
		<?php echoLabelPropriete($propriete); ?>
		<input type="hidden" name="type" value="<?= $type ?>">
		<input type="hidden" name="nbAppartements" value="<?= $nbAppartements ?>">
		<input type="hidden" name="numeroRue" value="<?= $propriete['numeroRue'] ?>">
		<input type="hidden" name="nomRue" value="<?= $propriete['nomRue'] ?>">
		<input type="hidden" name="codePostal" value="<?= $propriete['codePostal'] ?>">
		<input type="hidden" name="nomVille" value="<?= $propriete['nomVille'] ?>">
		<input type="hidden" name="codeDepartement" value="<?= $_POST['codeDepartement'] ?>">
		<input type="hidden" name="nomDepartement" value="<?= $_POST['nomDepartement'] ?>">
		<input type="hidden" name="codeRegion" value="<?= $_POST['codeRegion'] ?>">
		<input type="hidden" name="nomRegion" value="<?= $_POST['nomRegion'] ?>">
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

				<?php if ($type != "maison") { ?>
					<h2 id="numAppartement_<?= $i ?>">Appartement numéro <?= $appartement['numAppartement'] ?></h2>
				<?php } ?>
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
								$libelle = $typePiece['libTypePiece'];
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

		<div class="doubleboutons">
			<input type="submit" value="Ajouter">
			<a href="<?= $ROOT ?>Page_accueil/Page_accueil.php" class="bouton">Retour à l'accueil</a>
		</div>
	</form>

	<?php require("{$ROOT}common/footer.php") ?>
