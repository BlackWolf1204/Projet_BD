<?php
$ROOT = '../../';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Ajouter une propriété</title>

	<?php require("{$ROOT}common/header.php") ?>
	<?php require("{$ROOT}common/verif_est_connecte.php") ?>

	<h2>Ajouter un immeuble</h2>

    <a href="../../Page_accueil/Page_accueil.php" class = "bouton-retour">Retour à l'accueil</a>

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
			<input type="number" name="nbAppartements" min="1" max="100" value="1" title="Nombre d'appartements à enregistrer dans l'immeuble" required oninput="if(!this.value) this.value = 1;">
		</div>

		<!-- addresse : numéro, rue, code postal, ville -->
		<div id="adresse">
			<label for="numéroRue">Numéro de rue</label>
			<input type="number" name="numéroRue" id="numéroRue" placeholder="123" title="Numéro de rue" required>
			<label for="street">Rue</label>
			<input type="text" name="nomRue" id="street" placeholder="Rue de la paix" title="Nom de la rue" autcompelte="address-level1" required oninput="nomRueAjoute()">
			<label for="codePostal">Code postal</label>
			<input type="text" name="codePostal" id="zipCode" placeholder="75000" title="Code postal" autcomplete="postal-code" required oninput="chercherVilleParCodePostal()">
			<label for="ville">Ville</label>
			<input type="text" name="ville" placeholder="Paris" id="city" title="Ville" autcomplete="city address-level2" required oninput="chercherCodePostalParVille()">
			<label for="departement">Département</label>
			<input type="text" id="departement" name="departement" title="Département" disabled>
			<input type="hidden" id="codeDepartement" name="codeDepartement">
			<input type="hidden" id="nomDepartement" name="nomDepartement">
			<label for="region">Région</label>
			<input type="text" id="region" name="region" title="Région" disabled>
			<input type="hidden" id="codeRegion" name="codeRegion">
			<input type="hidden" id="nomRegion" name="nomRegion">
		</div>

		<!-- nom de la propriete et degré d'isolation -->
		<div id="propriete">
			<label for="nomPropriete">Nom de la propriété</label>
			<input type="text" name="nomPropriete" placeholder="Propriété 1" autocomplete="off" required>
			<label for="degreIsolation">Degré d'isolation</label>
			<select name="degreIsolation" title="Le degré d'isolation sur une échelle de A à F" required>
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

	<script>
		function sendRequest(url, callback) {
			let xhr = new XMLHttpRequest();
			xhr.open("GET", url);
			xhr.onload = () => callback(xhr.responseText);
			xhr.send();
		}

		function chercherNomDepartement(codeDepartement) {
			if (codeDepartement) {
				sendRequest("https://geo.api.gouv.fr/departements/" + codeDepartement, (response) => {
					let data = JSON.parse(response);
					let nomDepartement = data?.nom || '';
					document.getElementById("departement").value = `${nomDepartement} (${codeDepartement})`;
					document.getElementById("codeDepartement").value = codeDepartement;
					document.getElementById("nomDepartement").value = nomDepartement;
				});
			} else {
				document.getElementById("departement").value = '';
				document.getElementById("codeDepartement").value = '';
				document.getElementById("nomDepartement").value = '';
			}
		}

		function chercherNomRegion(codeRegion) {
			if (codeRegion) {
				sendRequest("https://geo.api.gouv.fr/regions/" + codeRegion, (response) => {
					let data = JSON.parse(response);
					let nomRegion = data?.nom || '';
					document.getElementById("region").value = nomRegion;
					document.getElementById("codeRegion").value = codeRegion;
					document.getElementById("nomRegion").value = nomRegion;
				});
			} else {
				document.getElementById("region").value = '';
				document.getElementById("codeRegion").value = '';
				document.getElementById("nomRegion").value = '';
			}
		}

		/**
		 * @return {boolean} `true` si le département a changé, `false` sinon
		 */
		function actualiseDepartementRegion(dataVille) {
			var departementAChange = false;
			if (dataVille) {
				if (document.getElementById('codeDepartement').value != dataVille.codeDepartement) {
					departementAChange = true;
				}
				chercherNomDepartement(dataVille.codeDepartement);
				chercherNomRegion(dataVille.codeRegion);
			}
			return departementAChange;
		}

		function chercherVilleParCodePostal() {
			let codePostal = document.getElementById("zipCode").value;
			sendRequest("https://geo.api.gouv.fr/communes?codePostal=" + codePostal, (response) => {
				let data = JSON.parse(response);
				let dataVille = data[0];
				if (dataVille) {
					const departementAChange = actualiseDepartementRegion(dataVille);
					if (!document.getElementById("city").value || departementAChange)
						document.getElementById("city").value = dataVille.nom; // si la ville est déjà renseignée, on ne la change pas
				}
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
			let ville = document.getElementById("city").value;
			sendRequest("https://geo.api.gouv.fr/communes?nom=" + ville, (response) => {
				let data = JSON.parse(response);
				let dataVille = trouverVille(data, ville.toLowerCase());
				if (dataVille) {
					const departementAChange = actualiseDepartementRegion(dataVille);
					if (!document.getElementById("zipCode").value || departementAChange)
						document.getElementById("zipCode").value = dataVille.code; // si le code postal est déjà renseigné, on ne le change pas
				}
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

		function nomRueAjoute() {
			// Déplacer le numéro de la rue
			let rue = document.getElementById("street");
			let numero = document.getElementById("numéroRue");
			if (rue.value && rue.value.match(/^[0-9]+/)) {
				numero.value = rue.value.match(/^[0-9]+/)[0];
				const nomRue = rue.value.replace(/^[0-9]+ */, "");;
				rue.value = nomRue;
				setTimeout(() => rue.value = nomRue, 1);
			}
		}
	</script>

	<?php require("{$ROOT}common/footer.php") ?>
	</body>

</html>