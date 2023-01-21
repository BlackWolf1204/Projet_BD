<?php
$ROOT = "../";
require_once("../common/main.php");
require_once("../common/fonctions.php");
pageAccueilSiNonConnecte($ROOT);

if (isset($_GET['idAppartement'])) {
	$idAppartement = $_GET['idAppartement']; // utiliser prepare() pour éviter les injections SQL
} else if (isset($_POST['idAppartement'])) {
	$idAppartement = $_POST['idAppartement']; 
} else {
	header("Location: gererAppartements.php");
}

// requete pour la base
$req = "SELECT numeroRue, nomRue, codePostal, nomVille, degreIsolation, nomPropriete, idAppartement, numAppart, idPropriete,
		idLocataire, nomLocataire, prenomLocataire, DATE(dateDebutLoc) AS dateDebutLoc
		FROM Appartement NATURAL JOIN ProprieteAdresse LEFT OUTER JOIN LocataireActuel USING (idAppartement) LEFT OUTER JOIN ProprietaireActuel USING (idPropriete)
		WHERE idAppartement = ?";

if (!isset($estAdmin) || $estAdmin != true) {
	$req = "$req AND idProprietaire = $sessionId";
}

// exécution de la requête
$req = $bdd->prepare($req);
// si erreur
if ($req == NULL) {
	die("Problème d'exécution de la requête<br>{$bdd->errorInfo()[2]}<br>");
}
$dataAppartements = $req->execute(array($idAppartement));

if ($req->rowCount() == 0) {
	echo "<p>Cet appartement n'existe pas ou n'est pas visible.<br>Redirection vers la page des propriétés</p>";
	header("Refresh: 2; url=gererProprietes.php");
	exit();
}

$appartement = $req->fetch();


// Si POST, vérifier idAppartement et idLocataire puis changer le locataire
if (!empty($_POST)) {
	if(!isset($_POST['idAppartement']) || !isset($_POST['idLocataire'])) {
		die('{ "error": "Erreur: idAppartement ou idLocataire non défini" }');
	}
	$idAppartement = $_POST['idAppartement'];
	$idNouveauLocataire = $_POST['idLocataire'];
	$idAncienLocataire = $appartement['idLocataire'];
	
	// Changer le locataire
	if($idAncienLocataire == $idNouveauLocataire) {
		die('{ "error": "Erreur : Le locataire n\'a pas changé." }');
	}
	if($idAncienLocataire) {
		$req = $bdd->prepare("UPDATE LocataireActuel SET dateFinLoc = NOW() WHERE idAppartement = ? AND idLocataire = ?");
		$req->execute(array($idAppartement, $idAncienLocataire));
	}

	$req = $bdd->prepare("INSERT INTO LocataireActuel (idLocataire, idAppartement, dateDebutLoc) VALUES (?, ?, NOW())");
	$req->execute(array($idNouveauLocataire, $idAppartement));

	// Redirection vers la page des détails
	die('{ "message": "Changement de locataire effectué." }');
}
?>

<!DOCTYPE html>

<html lang="fr">

<head>

	<title>Changer le locataire</title>

	<style>
		#boutonChangerLoc {
			width: auto;
		}
	</style>

	<?php require "../common/header.php"; ?>

	<h2>Changer le locataire</h2>

	<a href="../Page_accueil/Page_accueil.php" class="bouton-retour">Retour à l'accueil</a>

	<div class="container text-center">
		<p>Nom de la propriété : <?= $appartement['nomPropriete']; ?></p>
		<p>Adresse : <?= adresseSansNomPropriete($appartement); ?></p>
		<p>Numéro d'appartement : <?= $appartement['numAppart']; ?></p>
		<p>Locataire actuel : <?= lienInfoPersonne($appartement['idLocataire'], $appartement['nomLocataire'], $appartement['prenomLocataire'], $ROOT, 'Sans locataire'); ?></p>
		<?php if ($appartement['idLocataire'] != NULL) { ?>
			<p style="margin-bottom: .5em;">Locataire depuis le : <?= date('d/m/Y', strtotime($appartement['dateDebutLoc'])); ?></p>
		<?php } ?>
		
		<?php require("../common/chercherUser.php"); ?>

		<div class="boutonsgroupes centre">
			<button id="boutonChangerLoc" disabled="true" onclick="changerLocataireClick()">Changer le locataire</button>
			<a class="bouton" href="detailsPropriete.php?idPropriete=<?= $idPropriete ?>">Détails de la propriété</a>
		</div>

		<script>
			var nouveauLocataire = null;
			function onUsersFound(users) {
				if(users.length === 1)
					nouveauLocataire = users[0];
				else
					nouveauLocataire = null;
				const boutonChangerLoc = document.getElementById('boutonChangerLoc');
				
				if(nouveauLocataire != null)
					boutonChangerLoc.removeAttribute('disabled');
				else
					boutonChangerLoc.setAttribute('disabled', 'true');	
			}

			function changerLocataireClick() {
				// Envoyer la requête
				const xhr = new XMLHttpRequest();
				xhr.open('POST', 'changerLocataire.php');
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhr.onload = function() {
					if (xhr.status === 200) {
						var json = JSON.parse(xhr.responseText);
						if(json.error)
							alert(json.error);
						else
							window.location.href = 'detailsPropriete.php?idPropriete=<?= $appartement['idPropriete']; ?>';
					} else {
						alert('Erreur lors du changement de locataire.');
					}
				};
				xhr.send('idAppartement=<?= $idAppartement; ?>&idLocataire=' + nouveauLocataire.idPersonne);
			}
		</script>
	</div>

	<?php require "../common/footer.php"; ?>
