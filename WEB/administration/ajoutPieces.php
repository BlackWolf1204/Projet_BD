<?php
$ROOT = '../';

// Enregistrer les pièces d'une seule fois
if (!empty($_POST)) {
	// Connexion à la base de données
	require('../common/main.php');

	$idPropriete = $_POST['idPropriete'];
	$nbApparts = $_POST['nbApparts'];
	$appartements = array();
	for ($i = 1; $i <= $nbApparts; $i++) {
		$nbPieces = $_POST["nbPieces_$i"];
		$pieces = array();
		for ($j = 1; $j <= $nbPieces; $j++) {
			$i_j = $i . '_' . $j;
			$pieces[] = array(
				'typePiece' => $_POST["typePiece_$i_j"],
			);
		}
		$appartements[] = array(
			'idAppartement' => $_POST["idAppartement_$i"],
			'nbPieces' => $_POST["nbPieces_$i"],
			'pieces' => $pieces,
		);
	}

	// Ajouter les pièces
	$sql = "INSERT INTO piece (idAppartement, typePiece) VALUES ";
	$first = true;
	foreach ($appartements as $appartement) {
		foreach ($appartement['pieces'] as $piece) {
			if (!$first)
				$sql .= ", ";
			$sql .= "({$appartement['idAppartement']}, '{$piece['typePiece']}')";
			$first = false;
		}
	}
	$result = $bdd->query($sql);
	if (!$result) {
		echo "Error: " . $sql . "<br>" . $bdd->error;
		die();
	} else {
		// Page d'accueil
		header("Location: ../index.php?success");
	}
}

?>

<!DOCTYPE html>
<html>

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

	$proprieteQuery = $bdd->query("SELECT * FROM propriete WHERE idPropriete = $idPropriete");
	if ($proprieteQuery) {
		$propriete = $proprieteQuery->fetch();
	}

	$sql = "SELECT * FROM appartement WHERE idPropriete = $idPropriete";
	$appartements = $bdd->query($sql);
	$appartements = $appartements->fetchAll();

	$typeAppartements = $bdd->query("SELECT * FROM typeappartement");
	$typeAppartements = $typeAppartements->fetchAll();

	$typePieces = $bdd->query("SELECT * FROM typepiece");
	$typePieces = $typePieces->fetchAll();

	$nbPieces = 0;
	foreach ($appartements as $appartement) {
		$nbPiecesAppart = $bdd->query("SELECT nbPieces FROM typeappartement WHERE typeAppart = {$appartement['typeAppart']}");
		$nbPiecesAppart = $nbPiecesAppart->fetch();
		$nbPiecesAppart = $nbPiecesAppart['nbPieces'];
		$nbPieces += $nbPiecesAppart;
	}

	if ($nbApparts == 1) {
		if ($nbPieces == 1)
			echo "<h2>Configuration de la pièce de l'appartement</h2>";
		else
			echo "<h2>Configuration des $nbPieces pièces de l'appartement</h2>";
	} else {
		echo "<h2>Configuration des $nbPieces pièces des $nbApparts appartements</h2>";
	}
	?>

	<form action="ajoutPieces.php" method="post">
		<!-- idPropriete/nomPropriete/adresse -->
		<?php echoLabelPropriete($propriete); ?>
		<input type="hidden" name="idPropriete" value="<?= $propriete['idPropriete'] ?>">
		<input type="hidden" name="nbApparts" value="<?= $nbApparts ?>">

		<!-- Pour une maison (1 ppartment) : degreSecurité (faible, moyen, fort), typeAppartement (select récup de la table typeappartement : T1, T2...) -->
		<!-- Pour les n appartements => numAppartement, degreSecurité (faible, moyen, fort), typeAppartement (select récup de la table typeappartement : T1, T2...) -->
		<?php

		for ($i = 1; $i <= $nbApparts; $i++) {
			$appartement = $appartements[$i - 1];
			foreach ($typeAppartements as $typeAppart) {
				if ($typeAppart['typeAppart'] == $appartement['typeAppart']) {
					$typeAppartement = $typeAppart;
					break;
				}
			}
		?>

			<div class="infoAppart" appartNum=<?= $i ?>>

				<h2 id="numAppartement_<?= $i ?>">Appartement numéro <?= $i ?></h2>
				<input type="hidden" name="numAppartement_<?= $i ?>" value="<?= $i ?>">
				<input type="hidden" name="idAppartement_<?= $i ?>" value="<?= $appartement['idAppartement'] ?>">
				<input type="hidden" name="nbPieces_<?= $i ?>" value="<?= $typeAppartement['nbPieces'] ?>">
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

	<?php require('../common/footer.php') ?>
	</body>

</html>