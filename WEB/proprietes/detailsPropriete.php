<?php
$ROOT = "../";
$titre = "Page propriété";
require "../common/header.php";
pageAccueilSiNonConnecte($estConnecte, $ROOT);
?>

	<style>
		.appart p {
			margin-bottom: .2em;
		}
		body h3 {
			margin-top: .5em;
		}
		h3 ~ table, h4 ~ table {
			margin-top: 0 !important;
		}
		.appart h4 {
			margin-top: .5em;
		}
	</style>

	<h2>Détails de la propriété</h2>

	<a href="../Page_accueil/Page_accueil.php" class="bouton-retour">Retour à l'accueil</a>

	<?php

	if (isset($_GET['idPropriete'])) {
		$idPropriete = $_GET['idPropriete']; // utiliser prepare() pour éviter les injections SQL
	} else {
		header("Location: gererProprietes.php");
	}

	// requete pour la base
	$req = "SELECT numeroRue, nomRue, codePostal, nomVille, degreIsolation, nomPropriete, idPropriete,
			idProprietaire, nomProprietaire, prenomProprietaire, DATE(dateDebutProp) AS dateDebutProp
            FROM ProprieteAdresse LEFT OUTER JOIN ProprietaireActuel USING (idPropriete)
			WHERE idPropriete = ?";

	if (!isset($estAdmin) || $estAdmin != true) {
		$req = "$req AND idProprietaire = $sessionId";
	}

	// exécution de la requête
	$req = $bdd->prepare($req);
	// si erreur
	if ($req == NULL) {
		die("Problème d'exécution de la requête<br>{$bdd->errorInfo()[2]}<br>");
	}
	$dataProprietes = $req->execute(array($idPropriete));

	if ($req->rowCount() == 0) {
		echo "<p>Cette propriété n'existe pas ou n'est pas visible.<br>Redirection vers la page des propriétés</p>";
		header("Refresh: 2; url=gererProprietes.php");
		exit();
	}

	$propriete = $req->fetch();
	?>

	<div class="container text-center">
		<p>Nom de la propriété : <?= $propriete['nomPropriete']; ?></p>
		<p>Adresse : <?= adresseSansNomPropriete($propriete); ?></p>
		<p>Degré d'isolation : <?= $propriete['degreIsolation']; ?></p>
		<p>Propriétaire actuel : <?= lienInfoPersonne($propriete['idProprietaire'], $propriete['nomProprietaire'], $propriete['prenomProprietaire'], $ROOT, 'Sans propriétaire'); ?></p>
		<?php if ($propriete['idProprietaire'] != NULL) { ?>
			<p style="margin-bottom: .5em;">Propriétaire depuis le : <?= date('d/m/Y', strtotime($propriete['dateDebutProp'])); ?></p>
		<?php } ?>
		<div class="boutonsgroupes centre">
			<a class="bouton" href="changerProprietaire.php?idPropriete=<?= $idPropriete ?>">Changer le propriétaire</a>
			<a class="bouton rouge" href="supprimerPropriete.php?idPropriete=<?= $idPropriete ?>">Supprimer la propriété</a>
		</div>

		<h3>Propriétaires précédents</h3>
		<?php
		$req = "SELECT idPersonne, nom, prenom, DATE(dateDebutProp) AS dateDebutProp, DATE(dateFinProp) AS dateFinProp
				FROM Proprietaire LEFT OUTER JOIN InfoPersonne USING (idPersonne)
				WHERE idPropriete = ?
				ORDER BY Proprietaire.dateDebutProp DESC";
		$req = $bdd->prepare($req);
		if (!$req->execute(array($idPropriete))) {
			die("Problème d'exécution de la requête :<br>{$req->errorInfo()[2]}<br>");
		}
		$proprietaires = $req->fetchAll();

		if (count($proprietaires) == 0) {
			echo "<p>Cette propriété n'a jamais eu de propriétaire.</p>";
		} else {
		?>
			<table>
				<tr class="titre">
					<th>Nom</th>
					<th>Prénom</th>
					<th>Date de début de propriété</th>
					<th>Date de fin de propriété</th>
				</tr>
				<?php foreach ($proprietaires as $proprietaire) {
					echo "<tr>";
					echo "<td>" . lienInfoPersonne($proprietaire['idPersonne'], $proprietaire['nom'], '', $ROOT, 'Utilisateur inconnu') . "</td>";
					echo "<td>" . $proprietaire['prenom'] . "</td>";
					echo "<td>" . date('d/m/Y', strtotime($proprietaire['dateDebutProp'])) . "</td>";
					echo "<td>" . ($proprietaire['dateFinProp'] ? date('d/m/Y', strtotime($proprietaire['dateFinProp'])) : '') . "</td>";
					echo "</tr>";
				} ?>
			</table>
		<?php } ?>

		<h3>Appartements</h3>
		<?php
		$req = "SELECT idAppartement, numAppart, degreSecurite, libTypeAppart,
				idLocataire, nomLocataire, prenomLocataire, DATE(dateDebutLoc) AS dateDebutLoc
				FROM Appartement NATURAL JOIN TypeAppartement LEFT OUTER JOIN LocataireActuel USING (idAppartement)
				WHERE idPropriete = ?";
		$req = $bdd->prepare($req);
		if (!$req->execute(array($idPropriete))) {
			die("Problème d'exécution de la requête :<br>{$req->errorInfo()[2]}<br>");
		}
		$appartements = $req->fetchAll();
		foreach ($appartements as $appartement) { ?>

			<div class="appart">
				<p>Numéro d'appartement : <?= $appartement['numAppart']; ?></p>
				<p>Degré de sécurité : <?= $appartement['degreSecurite']; ?></p>
				<p>Type d'appartement : <?= $appartement['libTypeAppart']; ?></p>
				<p>Locataire actuel : <?= lienInfoPersonne($appartement['idLocataire'], $appartement['nomLocataire'], $appartement['prenomLocataire'], $ROOT, 'Sans locataire'); ?></p>
				<?php if ($appartement['idLocataire'] != NULL) { ?>
					<p style="margin-bottom: .5em;">Locataire depuis le : <?= date('d/m/Y', strtotime($appartement['dateDebutLoc'])); ?></p>
				<?php } ?>
				<div class="boutonsgroupes centre">
					<a class="bouton" href="changerLocataire.php?idAppartement=<?= $appartement['idAppartement'] ?>">Changer le locataire</a>
				</div>

				<h4>Locataires précédents</h4>
				
				<?php
				$req = "SELECT idPersonne, nom, prenom, DATE(dateDebutLoc) AS dateDebutLoc, DATE(dateFinLoc) AS dateFinLoc
						FROM Locataire NATURAL JOIN InfoPersonne WHERE idAppartement = ?
						ORDER BY Locataire.dateDebutLoc DESC";
				$req = $bdd->prepare($req);
				if (!$req->execute(array($appartement['idAppartement']))) {
					die("Problème d'exécution de la requête :<br>{$req->errorInfo()[2]}<br>");
				}
				$locataires = $req->fetchAll();

				if(count($locataires) == 0) {
					echo "<p>Cet appartement n'a jamais eu de locataire.</p>";
				} else { ?>

					<table>
						<tr class="titre">
							<th>Nom</th>
							<th>Prénom</th>
							<th>Date de début de location</th>
							<th>Date de fin de location</th>
						</tr>

						<?php foreach ($locataires as $locataire) { ?>
						<tr>
							<td><?= lienInfoPersonne($locataire['idPersonne'], $locataire['nom'], '', $ROOT, 'Utilisateur inconnu'); ?></td>
							<td><?= $locataire['prenom']; ?></td>
							<td><?= date('d/m/Y', strtotime($locataire['dateDebutLoc'])); ?></td>
							<td><?= $locataire['dateFinLoc'] ? date('d/m/Y', strtotime($locataire['dateFinLoc'])) : ''; ?></td>
						</tr>
						<?php } ?>
					</table>
				<?php } ?>

				<h4>Pièces et appareils</h4>

				<?php
				$req = "SELECT idPiece, libTypePiece
						FROM Piece NATURAL JOIN TypePiece
						WHERE idAppartement = ?";
				$req = $bdd->prepare($req);
				if (!$req->execute(array($appartement['idAppartement']))) {
					die("Problème d'exécution de la requête :<br>{$req->errorInfo()[2]}<br>");
				}
				$pieces = $req->fetchAll();

				if(count($pieces) == 0) {
					echo "<p>Cet appartement ne contient aucune pièce.</p>";
				} else { ?>

					<table>
						<tr class="titre">
							<th>Type de pièce</th>
							<th>Appareils</th>
						</tr>

						<?php
						foreach ($pieces as $piece) {
							$req = "SELECT idAppareil, nomAppareil, libTypeAppareil
									FROM Appareil NATURAL JOIN TypeAppareil
									WHERE idPiece = ?";
							$req = $bdd->prepare($req);
							if (!$req->execute(array($piece['idPiece']))) {
								die("Problème d'exécution de la requête :<br>{$req->errorInfo()[2]}<br>");
							}
							$appareils = $req->fetchAll();
						?>
							<tr>
								<td><?= $piece['libTypePiece']; ?></td>
								<td>
									<?php
									if(count($appareils) > 0) {
										foreach ($appareils as $appareil) {
											echo lienInfoAppareil($appareil['idAppareil'], $appareil['nomAppareil'], $appareil['libTypeAppareil'], $ROOT, 'Appareil inconnu');
											echo "<br>";
										}
									}
									?>
								</td>
							</tr>
						<?php } ?>
					</table>
				<?php } ?>

			</div>
		<?php } ?>
		<div class="boutonsgroupes centre">
			<a class="bouton" href="gererProprietes.php">Gérer ses propriétés</a>
		</div>
	</div>

	<?php require "../common/footer.php"; ?>
