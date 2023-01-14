</div> <!-- fin de la div .body -->
<footer style="background-color: white;">
	<div class="vantatopologymin" id="vantatopologymin_2"></div>
	<div class="footer"><!-- début de la classe footer -->

		<div class="flex-together">
			<p>Projet : maison éco</p>&nbsp;
			<p>© 2022-2023 - Etudiants 3A DI Polytech Tours</p><!-- copyright et auteurs du site -->
		</div>

		<div class="flex-together">
			<p>Site réalisé par : </p><!-- mention de l'auteur -->
			<p>"Yasser BELAKHDAR | Zoé CASTERET | Alaâ CHAKORI SEMMANE | Jérôme LÉCUYER"</p><!-- ajout des prénoms des auteurs -->
		</div>

	</div><!-- fin de la classe footer -->
</footer>
<script>
	// Ajout de l'effet d'image dynamique de fond
	vantaConfig = {
		mouseControls: true,
		touchControls: true,
		gyroControls: false,
		minHeight: 77.00,
		minWidth: 100.00,
		scale: 1.00,
		scaleMobile: 1.00
	}
	VANTA.TOPOLOGY({
		...vantaConfig,
		el: "#vantatopologymin_1"
	});
	VANTA.TOPOLOGY({
		...vantaConfig,
		el: "#vantatopologymin_2"
	});
</script>