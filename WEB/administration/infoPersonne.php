<?php
$ROOT = "../";
require_once '../common/main.php';

if (!$estConnecte) {
	header("Location: {$ROOT}Page_accueil/connexion.php");
	exit();
}

if (!isset($_GET['idPersonne']) || empty($_GET['idPersonne'])) {
	die("Erreur : aucun identifiant de personne envoyé");
}

$idPersonne = $_GET['idPersonne'];

// Récupérer utilisateur
$requser = $bdd->prepare('SELECT * FROM InfoPersonne NATURAL JOIN Utilisateur WHERE idPersonne = ?');
if (!$requser) {
	die("Erreur de requête");
}
$requser->execute(array($idPersonne));
$userinfo = $requser->fetch();

if (!$userinfo) {
	// Récupérer administrateur
	$requser = $bdd->prepare('SELECT *, idPersonne AS idAdmin FROM InfoPersonne NATURAL JOIN Administrateur WHERE idPersonne = ?');
	if (!$requser) {
		die("Erreur de requête");
	}
	$requser->execute(array($idPersonne));
	$userinfo = $requser->fetch();

	if (!$userinfo) {
		// Récupérer sans compte
		$requser = $bdd->prepare('SELECT * FROM InfoPersonne WHERE idPersonne = ?');
		if (!$requser) {
			die("Erreur de requête");
		}
		$requser->execute(array($idPersonne));
		$userinfo = $requser->fetch();

		if (!$userinfo) {
			die("Erreur : personne inconnue");
		}
	}
}

// Si l'utilisateur est admin ou qu'il est sur son propre profil
$estAdminOuAutorise = $estAdmin || $userinfo['idPersonne'] == $idPersonne;

if (!$estAdminOuAutorise) {
	$proprietes = $bdd->prepare('SELECT * FROM Proprietaire NATURAL JOIN ProprieteAdresse WHERE idProprietaire = ?');
	if (!$proprietes) {
		die("Erreur de requête");
	}
	$proprietes->execute(array($idPersonne));
	$propriete = $proprietes->fetchAll();

	$locations = $bdd->prepare('SELECT * FROM Locataire NATURAL JOIN Appartement NATURAL JOIN ProprieteAdresse WHERE idLocataire = ?');
	if (!$locations) {
		die("Erreur de requête");
	}
	$locations->execute(array($idPersonne));
	$location = $locations->fetchAll();
}
?>

<html>

<head>
	<title> Page Profil </title>
	<meta charset="UTF-8">
	<?php require_once "{$ROOT}common/header.php"; ?>

	<div class="container mt-5 text-center">

		<!--on affiche le infos du profil nom, prenom , on met un bouton de modification a cote du mail, du numero de telephone et si on  clique dessus on peut modifier les champs -->

		<!-- Affichage des informations du profil -->
		<h2>Profil de <?php echo $userinfo['prenom'] . " " . $userinfo['nom']; ?></h2>
		<br /><br />

		<table>
			<tr>
				<td>Nom</td>
				<td><?= $userinfo['nom']; ?></td>
			</tr>
			<tr>
				<td>Prénom</td>
				<td><?= $userinfo['prenom']; ?></td>
			</tr>
			<tr>
				<td>Genre</td>
				<td><?= $userinfo['genre']; ?></td>
			</tr>
			<tr>
				<td>Mail</td>
				<td><?= $userinfo['mail']; ?></td>
			</tr>

			<?php if($estAdminOuAutorise) { // Uniquement visible par l'utilisateur ou un admin ?>
				<tr>
					<td>Date de naissance</td>
					<td><?= $userinfo['dateNais']; ?></td>
				</tr>
				<tr>
					<td>Numéro de téléphone</td>
					<td><?= $userinfo['numTel']; ?></td>
				</tr>

				<tr>
					<td>Identifiant</td>
					<td><?= isset($userinfo['identifiant']) ? $userinfo['identifiant'] : 'Sans compte'; ?></td>
				</tr>
			<?php } ?>

			<tr>
				<td>Date de création du compte</td>
				<td><?= isset($userinfo['dateCreation']) ? $userinfo['dateCreation'] : 'Sans compte'; ?></td>
			</tr>
			<tr>
				<td>Administrateur</td>
				<td><?= (isset($userinfo['idAdmin']) && $userinfo['idAdmin']) ? "Oui" : "Non"; ?></td>
			</tr>
		</table>

		<br /><br />
		<a class="bouton" href="<?= $ROOT ?>Page_accueil/Page_accueil.php">Retour à l'accueil</a>

	</div>

	<?php require_once "{$ROOT}common/footer.php"; ?>
