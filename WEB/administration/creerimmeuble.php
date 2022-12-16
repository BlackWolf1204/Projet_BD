<?php
require_once("../common/main.php");
require_once("../common/bdd.php");
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset='utf-8'>
	<title>Ajouter un immeuble</title>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel='stylesheet' type='text/css' media='screen' href='../style/main.css'>

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
	</script>
</head>

<body>
	<h1>Ajouter un immeuble</h1>

	<form target="creerimmeuble.php" action="post">
		<label for="numéroRue">Numéro de rue</label>
		<input type="text" name="numéroRue" placeholder="123">
		<label for="nomRue">Nom de rue</label>
		<input type="text" name="nomRue" placeholder="Rue de la paix">
		<label for="codePostal">Code postal</label>
		<input type="text" name="codePostal" placeholder="12345" id="codePostal" onchange="chercherVilleParCodePostal()">
		<label for="ville">Ville</label>
		<input type="text" name="ville" placeholder="Paris" id="ville" onchange="chercherCodePostalParVille()">
		<label for="nomImmeuble">Nom de l'immeuble</label>
		<input type="text" name="nomImmeuble" placeholder="Immeuble 1">
		<label for="degreIsolation">Degré d'isolation</label>
		<select name="degreIsolation">
			<option value="A">A</option>
			<option value="B">B</option>
			<option value="C">C</option>
			<option value="D">D</option>
			<option value="E">E</option>
			<option value="F">F</option>
		</select>
		<input type="submit" value="Ajouter">
	</form>
</body>

</html>