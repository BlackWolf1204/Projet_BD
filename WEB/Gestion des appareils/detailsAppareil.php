<?php
$ROOT = "../";
require_once '../common/main.php';

if (!$estConnecte) {
	header("Location: {$ROOT}Page_accueil/connexion.php");
	exit();
}

if (!isset($_GET['idAppareil']) || empty($_GET['idAppareil'])) {
	echo "Erreur : aucun identifiant d'appareil envoyé";
	exit();
}

$idAppareil = $_GET['idAppareil'];

$req = $bdd->prepare('SELECT nomAppareil, emplacement,
	libTypePiece, numAppart, idPropriete, nomPropriete, numeroRue, nomRue, nomVille, codePostal, nomDepartement, nomRegion,
	libTypeAppareil, VideoEconomie
	FROM Appareil NATURAL JOIN Piece NATURAL JOIN TypePiece NATURAL JOIN Appartement NATURAL JOIN ProprieteAdresse
	NATURAL JOIN TypeAppareil
	WHERE idAppareil = ?');
$req->execute(array($idAppareil));
$appareil = $req->fetch();
?>

<html>

<head>
	<title> Page Appareil </title>
	<meta charset="UTF-8">
	<?php require_once "{$ROOT}common/header.php"; ?>

	<div class="container mt-5 text-center">

		<h2>Informations de l'appareil</h2>
		<br /><br />

		<table>
			<tr>
				<td>Nom de l'appareil</td>
				<td><?= $appareil['nomAppareil'] ?></td>
			</tr>
			<tr>
				<td>Type d'appareil</td>
				<td><?= $appareil['libTypeAppareil'] ?></td>
			</tr>
			<tr>
				<td>Emplacement exact</td>
				<td><?= $appareil['emplacement'] ?></td>
			</tr>
			<tr>
				<td>Pièce</td>
				<td><?= $appareil['libTypePiece'] ?></td>
			</tr>
			<tr>
				<td>Numéro d'appartement</td>
				<td><?= $appareil['numAppart'] ?></td>
			</tr>
			<tr>
				<td>Propriété</td>
				<td><?= lienAdressePropriete($appareil, $ROOT) ?></td>
			</tr>
			<tr>
				<td>Video d'économie</td>
				<td>
					<?php
					if (empty($appareil['VideoEconomie'])) {
						echo "Aucune vidéo disponible";
					} else {
						$video = $appareil['VideoEconomie'];
						echo "<a href='$video'>$video</a>";
					}
					?>
				</td>
			</tr>
		</table>

		<br /><br />
		<a class="bouton" href="<?= $ROOT ?>Page_accueil/Page_accueil.php">Retour à l'accueil</a>

	</div>

	<?php require_once "{$ROOT}common/footer.php"; ?>