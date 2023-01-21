<?php
$ROOT = "../";
require_once("../common/main.php");
require_once("../common/fonctions.php");
pageAccueilSiNonConnecte($ROOT);

if (isset($_GET['idPropriete'])) {
	$idPropriete = $_GET['idPropriete']; // utiliser prepare() pour éviter les injections SQL
} else if (isset($_POST['idPropriete'])) {
	$idPropriete = $_POST['idPropriete']; 
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


// Si POST, vérifier idPropriete et idProprietaire puis changer le propriétaire
if (!empty($_POST)) {
	if(!isset($_POST['idPropriete']) || !isset($_POST['idProprietaire'])) {
		die('{ "error": "Erreur: idPropriete ou idProprietaire non défini" }');
	}
	$idPropriete = $_POST['idPropriete'];
	$idNouveauProprietaire = $_POST['idProprietaire'];
	$idAncienProprietaire = $propriete['idProprietaire'];
	
	// Changer le propriétaire
	if($idAncienProprietaire == $idNouveauProprietaire) {
		die('{ "error": "Erreur : Le propriétaire n\'a pas changé." }');
	}
	if($idAncienProprietaire) {
		$req = $bdd->prepare("UPDATE ProprietaireActuel SET dateFinProp = NOW() WHERE idPropriete = ? AND idProprietaire = ?");
		$req->execute(array($idPropriete, $idAncienProprietaire));
	}

	$req = $bdd->prepare("INSERT INTO ProprietaireActuel (idProprietaire, idPropriete, dateDebutProp) VALUES (?, ?, NOW())");
	$req->execute(array($idNouveauProprietaire, $idPropriete));

	// Redirection vers la page des détails
	die('{ "message": "Changement de propriétaire effectué." }');
}
?>

<!DOCTYPE html>

<html lang="fr">

<head>

	<title>Changer le locataire</title>

	<style>
		#boutonChangerProp {
			width: auto;
		}
	</style>

	<?php require "../common/header.php"; ?>

	<h2>Changer le propriétaire</h2>

	<a href="../Page_accueil/Page_accueil.php" class="bouton-retour">Retour à l'accueil</a>

	<div class="container text-center">
		<p>Nom de la propriété : <?= $propriete['nomPropriete']; ?></p>
		<p>Adresse : <?= adresseSansNomPropriete($propriete); ?></p>
		<p>Propriétaire actuel : <?= lienInfoPersonne($propriete['idProprietaire'], $propriete['nomProprietaire'], $propriete['prenomProprietaire'], $ROOT, 'Sans propriétaire'); ?></p>
		<?php if ($propriete['idProprietaire'] != NULL) { ?>
			<p style="margin-bottom: .5em;">Propriétaire depuis le : <?= date('d/m/Y', strtotime($propriete['dateDebutProp'])); ?></p>
		<?php } ?>
		
		<?php require("../common/chercherUser.php"); ?>

		<button id="boutonChangerProp" disabled="true" onclick="changerProprietaireClick()">Changer le propriétaire</button>

		<script>
			var nouveauProprietaire = null;
			function onUsersFound(users) {
				if(users.length === 1)
					nouveauProprietaire = users[0];
				else
					nouveauProprietaire = null;
				const boutonChangerProp = document.getElementById('boutonChangerProp');
				
				if(nouveauProprietaire != null)
					boutonChangerProp.removeAttribute('disabled');
				else
					boutonChangerProp.setAttribute('disabled', 'true');	
			}

			function changerProprietaireClick() {
				// Envoyer la requête
				const xhr = new XMLHttpRequest();
				xhr.open('POST', 'changerProprietaire.php');
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhr.onload = function() {
					if (xhr.status === 200) {
						var json = JSON.parse(xhr.responseText);
						if(json.error)
							alert(json.error);
						else
							window.location.href = 'detailsPropriete.php?idPropriete=<?= $idPropriete; ?>';
					} else {
						alert('Erreur lors du changement de propriétaire.');
					}
				};
				xhr.send('idPropriete=<?= $idPropriete; ?>&idProprietaire=' + nouveauProprietaire.idPersonne);
			}
		</script>
	</div>

	<?php require "../common/footer.php"; ?>
