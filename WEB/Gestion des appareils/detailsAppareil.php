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

$derniereConsommation = $bdd->prepare('SELECT dateOn, dateOff FROM HistoriqueConsommation WHERE idAppareil = ? ORDER BY dateOn DESC LIMIT 1');
if(!$derniereConsommation->execute(array($idAppareil))) {
	echo "Erreur d'exécution de la requête<br>" . $derniereConsommation->errorInfo()[2];
	exit();
}
$derniereConsommation = $derniereConsommation->fetch();


$titre = "Page Appareil";
require_once $ROOT . 'common/header.php';
?>

	<style>
		h3 {
			margin-top: 1em !important;
		}

		.consommation-annee {
			display: flex;
			flex-direction: column;
			align-items: center;
			--taille: 1;
		}
		.graph-annee {
			display: grid;
			border: 2px solid black;
			border-radius: 5px;
			padding: 4px;
			width: fit-content;
			font-size: calc(1em * var(--taille));
		}

		.graph-annee .mois {
			display: grid;
			grid-column: 2;
			grid-row: 1;
			grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
			width: 100%;
		}

		.graph-annee .mois > span {
			overflow: hidden;
		}

		.graph-annee .joursSemaine {
			display: grid;
			grid-column: 1;
			grid-row: 2;
			margin: 0 .5em;
			grid-template-rows: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
			row-gap: calc(.3em * var(--taille));
		}

		.graph-annee .joursSemaine > span {
			display: flex;
			justify-content: center;
			flex-direction: column;
		}


		.graph-activite {
			display: grid;
			grid-column: 2;
			grid-row: 2;
			gap: calc(.3em * var(--taille));
			width: 100%;
		}
		.carre-activite {
			width: calc(1em * var(--taille));
			height: calc(1em * var(--taille));
			background-color: white;
		}

		.carre-activite:not([tempsActif="0"]) {
			/* tempsActif = 0 => blanc, tempsActif = 24 => rouge vif */
			background-color: hsl(0, 100%, calc(100% - var(--tempsActif) * 50% / 24));
			border: 1px solid black;
		}

		.joursSemaine > span {
			line-height: calc(1em * var(--taille));
		}

		@media (max-width: 1200px) { .graph-annee { --taille: .9; } }
		@media (max-width: 975px) { .graph-annee { --taille: .8; } }
		@media (max-width: 800px) { .graph-annee { --taille: .7; } .mois { display: none; } }
		@media (max-width: 620px) { .graph-annee { --taille: .6; } }
		@media (max-width: 470px) { .graph-annee { --taille: .5; } }
		@media (max-width: 360px) { .graph-annee { --taille: .4; } }

	</style>

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
			<tr>
				<td>Est allumé</td>
				<?php
				if($derniereConsommation['dateOn'] && !$derniereConsommation['dateOff']) {
					echo "<td>Oui depuis le " . date('d/m/Y H:i:s', strtotime($derniereConsommation['dateOn'])) . "</td>";
				} else {
					echo "<td>Non</td>";
				}
				?>
			</tr>
		</table>


		<h3>Historique de consommation</h3>
		<?php
		// Statistiques de consommation

		$req = $bdd->prepare('SELECT dateOn, dateOff
			FROM HistoriqueConsommation
			WHERE idAppareil = ?
			ORDER BY dateOn DESC');
		$req->execute(array($idAppareil));
		$historique = $req->fetchAll();

		$dateFin = $historique[0]['dateOff'];
		$dateDebut = $historique[count($historique) - 1]['dateOn'];
		$nbJours = (strtotime($dateFin) - strtotime($dateDebut)) / 86400;
		$nbSemaines = max(ceil($nbJours / 7), 1);

		$anneeDebut = intval(date('Y', strtotime($dateDebut)));
		$anneeFin = intval(date('Y', strtotime($dateFin) - 1)); // -1 pour exclure l'année ajoutée à minuit
		if(!$dateFin) {
			$anneeFin = intval(date('Y')); // année en cours
		}
		$nbAnnees = $anneeFin - $anneeDebut + 1;

		// Afficher en graphique le temps de fonctionnement dans le même style que l'activité d'un compte GitHub
		
		// Array d'activité par jour du type :
		// $activite[annee][semaine][jourSemaine] = nombre d'heures actives
		$activite = array();
		for($annee = $anneeDebut; $annee <= $anneeFin; $annee++) {
			$activite[$annee] = array();
			for($semaine = 1; $semaine <= 52; $semaine++) {
				$activite[$annee][$semaine] = array();
				for($jourSemaine = 1; $jourSemaine <= 7; $jourSemaine++) {
					$activite[$annee][$semaine][$jourSemaine] = 0;
				}
			}
		}
		foreach($historique as $consommation) {
			if($consommation['dateOff'] == NULL) {
				// Dernier = tout remplir j'usqu'à maintenant
				$consommation['dateOff'] = date('Y-m-d H:i:s');
			}

			$dateOn = strtotime($consommation['dateOn']);
			$dateOff = strtotime($consommation['dateOff']);
			$anneeOn = intval(date('Y', $dateOn));
			$semaineOn = intval(date('W', $dateOn));
			$jourSemaineOn = intval(date('N', $dateOn));
			// Si janvier et semaine >= 52, alors année précédente
			if($semaineOn >= 52 && intval(date('m', $dateOn)) == 1) {
				$anneeOn--;
			}

			// Nombre de secondes depuis le début de la journée
			$heureOn = intval(date('H', $dateOn));
			$minuteOn = intval(date('i', $dateOn));
			$secondeOn = intval(date('s', $dateOn));
			$tempsJourOn = $heureOn * 3600 + $minuteOn * 60 + $secondeOn;

			$anneeOff = intval(date('Y', $dateOff));
			$semaineOff = intval(date('W', $dateOff));
			$jourSemaineOff = intval(date('N', $dateOff));
			// Si janvier et semaine >= 52, alors année précédente
			if($semaineOff >= 52 && intval(date('m', $dateOff)) == 1) {
				$anneeOff--;
			}


			// Nombre de secondes depuis le début de la journée
			$heureOff = intval(date('H', $dateOff));
			$minuteOff = intval(date('i', $dateOff));
			$secondeOff = intval(date('s', $dateOff));
			$tempsJourOff = $heureOff * 3600 + $minuteOff * 60 + $secondeOff;

			for ($annee = $anneeOn; $annee <= $anneeOff; $annee++) {

				$debutSemaineAnnee = $annee == $anneeOn ? $semaineOn : 1;
				$finSemaineAnnee = $annee == $anneeOff ? $semaineOff : 52;

				for ($semaine = $debutSemaineAnnee; $semaine <= $finSemaineAnnee; $semaine++) {

					$debutJourSemaine = ($annee == $anneeOn && $semaine == $semaineOn) ? $jourSemaineOn : 1;
					$finJourSemaine = ($annee == $anneeOff && $semaine == $semaineOff) ? $jourSemaineOff : 7;

					for($jourSemaine = $debutJourSemaine; $jourSemaine <= $finJourSemaine; $jourSemaine++) {

						$estPremierJour = $annee == $anneeOn && $semaine == $semaineOn && $jourSemaine == $jourSemaineOn;
						$estDernierJour = $annee == $anneeOff && $semaine == $semaineOff && $jourSemaine == $jourSemaineOff;

						$debut = 0;
						$fin = 86400;
						if($estPremierJour)
							$debut = $tempsJourOn;
						if($estDernierJour)
							$fin = $tempsJourOff;

						$activite[$annee][$semaine][$jourSemaine] += ($fin - $debut) / 3600;
					}

				}

			}
		}
		?>


		<?php for($annee = $anneeDebut; $annee <= $anneeFin; $annee++) { ?>
			<div class="consommation-annee">
				<h3>Consommation de <?= $annee ?></h3>
				<div class="graph-annee">
					<div class="mois">
						<span>Janvier</span>
						<span>Février</span>
						<span>Mars</span>
						<span>Avril</span>
						<span>Mai</span>
						<span>Juin</span>
						<span>Juillet</span>
						<span>Août</span>
						<span>Septembre</span>
						<span>Octobre</span>
						<span>Novembre</span>
						<span>Décembre</span>
					</div>
					<div class="joursSemaine">
						<span style="grid-row: 1;">Lundi</span>
						<span style="grid-row: 3;">Mercredi</span>
						<span style="grid-row: 5;">Vendredi</span>
					</div>
					<div id="chart_div_<?= $annee ?>" class="graph-activite">
						<?php
						// Afficher le graphique de l'année
						$premierJourDeLAnnee = date("N", strtotime("$annee-01-01"));
						$dernierJourDeLAnnee = date("N", strtotime("$annee-12-31"));
						for($semaine = 1; $semaine <= 52; $semaine++) {
							$premJour = $semaine == 1 ? $premierJourDeLAnnee : 1;
							$dernJour = $semaine == 52 ? $dernierJourDeLAnnee : 7;
							for($jourSemaine = $premJour; $jourSemaine <= $dernJour; $jourSemaine++) {
								$tempsActif = $activite[$annee][$semaine][$jourSemaine];
								$semaine2Chiffres = str_pad($semaine, 2, "0", STR_PAD_LEFT);

								$date = date("d/m/Y", strtotime("$annee-W$semaine2Chiffres-$jourSemaine"));
								
								if($tempsActif > 1) {
									$heures = round($tempsActif, 1);
									$title = "$date : $heures heures d'activité";
								} else if($tempsActif > 0) {
									$minutes = round($tempsActif * 60, 1);
									if($minutes < 1) {
										$secondes = round($tempsActif * 3600, 1);
										$title = "$date : $secondes secondes d'activité";
									}
									else {
										$title = "$date : $minutes minutes d'activité";
									}
								} else
									$title = "$date : Aucune activité";

								
								echo "<span class=\"carre-activite\" tempsActif=\"$tempsActif\" style=\"--tempsActif: $tempsActif; grid-column: $semaine; grid-row: $jourSemaine;\" title=\"$title\"></span>";
							}
						}
						?>
					</div>
				</div>
			</div>
		<?php } ?>
		


		<br /><br />
		<a class="bouton" href="<?= $ROOT ?>Page_accueil/Page_accueil.php">Retour à l'accueil</a>

	</div>

	<?php require_once "{$ROOT}common/footer.php"; ?>