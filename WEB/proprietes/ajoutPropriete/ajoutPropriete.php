<?php
$ROOT = '../../';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Ajouter une propriété</title>

	<script>
		function sendRequest(params, callback) {
			let xhr = new XMLHttpRequest();
			xhr.open("GET", "https://geo.api.gouv.fr/communes?" + params);
			xhr.onload = () => callback(xhr.responseText);
			xhr.send();
		}

		function chercherVilleParCodePostal() {
			let codePostal = document.getElementById("codePostal").value;
			sendRequest("codePostal=" + codePostal, (response) => {
				let data = JSON.parse(response);
				let ville = data[0]?.nom;
				document.getElementById("ville").value = ville;
			});
		}

		function trouverVille(data, nomVille) {
			for (let i = 0; i < data.length; i++) {
				if (data[i].nom.toLowerCase() == nomVille) {
					return data[i];
				}
			}
			return data[0];
		}

		function chercherCodePostalParVille() {
			let ville = document.getElementById("ville").value;
			sendRequest("nom=" + ville, (response) => {
				let data = JSON.parse(response);
				let codePostal = trouverVille(data, ville.toLowerCase())?.code;
				document.getElementById("codePostal").value = codePostal;
			});
		}

		function choixImmeuble(immeuble) {
			let nbAppartements = document.getElementById("nbAppartements");
			if (immeuble) {
				nbAppartements.style.display = "block";
			} else {
				nbAppartements.style.display = "none";
			}
		}
	</script>

	<?php require("{$ROOT}common/header.php") ?>
	<?php require("{$ROOT}common/verif_est_connecte.php") ?>

	<h2>Ajouter un immeuble</h2>

	<a href="../../Page_accueil/Page_accueil.php">Retour</a>

	<form action="ajoutAppartement.php" method="post">
		<!-- radio box : maison ou immeuble -->
		<div id="type">
			<label for="type">Type</label>
			<span onclick="this.querySelector('input').click()"><input type="radio" name="type" value="maison" title="La propriété est une maison" checked oninput="choixImmeuble(false)">Maison</span>
			<span onclick="this.querySelector('input').click()"><input type="radio" name="type" value="immeuble" title="La propriété est un immeuble" oninput="choixImmeuble(true)">Immeuble</span>
		</div>

		<!-- nombre d'appartements -->
		<div id="nbAppartements" style="display: none;">
			<label for="nbAppartements">Nombre d'appartements</label>
			<input type="number" name="nbAppartements" min="1" max="100" value="1" title="Nombre d'appartements à enregistrer dans l'immeuble">
		</div>

		<!-- addresse : numéro, rue, code postal, ville -->
		<div id="adresse">
			<label for="numéroRue">Numéro de rue</label>
			<input type="text" name="numéroRue" placeholder="123" title="Numéro de rue">
			<label for="nomRue">Nom de rue</label>
			<input type="text" name="nomRue" placeholder="Rue de la paix" title="Nom de rue">
			<label for="codePostal">Code postal</label>
			<input type="text" name="codePostal" placeholder="12345" id="codePostal" onchange="chercherVilleParCodePostal()" title="Code postal">
			<label for="ville">Ville</label>
			<input type="text" name="ville" placeholder="Paris" id="ville" onchange="chercherCodePostalParVille()" title="Ville">
		</div>

		<!-- nom de la propriete et degré d'isolation -->
		<div id="propriete">
			<label for="nomPropriete">Nom de la propriété</label>
			<input type="text" name="nomPropriete" placeholder="Propriété 1">
			<label for="degreIsolation">Degré d'isolation</label>
			<select name="degreIsolation" title="Le degré d'isolation sur une échelle de A à F">
				<option value="A">A</option>
				<option value="B">B</option>
				<option value="C">C</option>
				<option value="D">D</option>
				<option value="E">E</option>
				<option value="F">F</option>
			</select>
		</div>
		<input type="submit" value="Ajouter">
	</form>

	<?php require("{$ROOT}common/footer.php") ?>
	</body>

</html>