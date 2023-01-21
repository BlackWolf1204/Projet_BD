<?php
$ROOT = "../";
require_once($ROOT . "common/main.php");
// Rechercher un id d'utilisateur à partir de son nom et de son prénom

if(!$estConnecte) {
	die("Erreur : vous devez être connecté");
}

if(isset($_GET) && !empty($_GET) && isset($_GET['get'])) {
	if (isset($_GET['nom']) && isset($_GET['prenom'])) {
		$nom = $_GET['nom'];
		$prenom = $_GET['prenom'];

		// Recherche de l'utilisateur dans la base de données
		$personnes = array();
		$req = $bdd->prepare("SELECT idPersonne, nom, prenom, mail FROM infoPersonne NATURAL JOIN Utilisateur WHERE nom LIKE ? AND prenom LIKE ?");
		$req->execute(array("%" . $nom . "%", "%" . $prenom . "%"));
		while ($personne = $req->fetch()) {
			$personnes[] = $personne;
		}
		echo json_encode($personnes);
		exit();
	}
	else {
		die("Erreur : paramètres manquants");
	}
}


// Affichage d'un formulaire de recherche d'utilisateur
// 1 champ pour le nom, 1 champ pour le prénom, 1 bouton de recherche
// Résultat : affichage du nom et du prénom de l'utilisateur trouvé
// Passer par une requête XML pour récupérer les données
?>

<div id="rechercheUser">
	<div>
		<label for="nom">Nom</label>
		<input type="text" name="nom" id="nom" onkeypress="if(event.keyCode == 13) rechercheUser();" />
		<label for="prenom">Prénom</label>
		<input type="text" name="prenom" id="prenom" onkeypress="if(event.keyCode == 13) rechercheUser();" />
		<input type="submit" value="Rechercher" onclick="rechercheUser(); return false;" />
	</div>
	<div id="resultat"></div>
</div>

<style>
	#rechercheUser input {
		width: auto !important;
	}
</style>

<script>
	function rechercheUser() {
		var nom = document.getElementById("nom").value;
		var prenom = document.getElementById("prenom").value;
		var url = "<?= $ROOT ?>common/chercherUser.php?get=1&nom=" + nom + "&prenom=" + prenom;
		var xhr = new XMLHttpRequest();
		xhr.open("GET", url, true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4) {
				var resultat = document.getElementById("resultat");
				resultat.style.color = undefined;
				if (xhr.status == 200) {
					var json = JSON.parse(xhr.responseText);
					if(json.length > 1) {
						resultat.style.color = "red";
						resultat.innerHTML = "Plusieurs personnes trouvées :<br />";
						for (var i = 0; i < json.length; i++) {
							var personne = json[i];
							resultat.innerHTML += personne.nom + " " + personne.prenom + " (" + personne.mail + ")<br />";
						}
					} else if(json.length == 1) {
						var personne = json[0];
						resultat.style.color = "unset";
						resultat.innerHTML = "Une personne trouvée :<br />";
						resultat.innerHTML += personne.nom + " " + personne.prenom + " (" + personne.mail + ")<br />";
					} else {
						resultat.style.color = "red";
						resultat.innerHTML = "Erreur : personne non trouvée.";
					}
					onUsersFound?.(json);
				} else {
					resultat.style.color = "red";
					resultat.innerHTML = "Erreur : " + xhr.status;
				}
			}
		}
		xhr.send(null);
	}
</script>