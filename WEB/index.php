<?php
$ROOT = "./";
$titre = "Projet Maison Économe";
require('common/header.php');

	function scanFolder($path)
	{
		$files = scandir($path);

		// Fichiers
		$nbFichiers = 0;
		foreach ($files as $file) {
			$fpath = $path . "/" . $file;
			if (!is_dir($fpath)) {
				if (substr($file, -4) == ".php" || substr($file, -5) == ".html") {
					$nbFichiers++;
					break;
				}
			}
		}
		if ($nbFichiers >= 1) {
			echo "<h2>$path</h2>";
		}
		foreach ($files as $file) {
			$fpath = $path . "/" . $file;
			if (!is_dir($fpath)) {
				if (substr($file, -4) == ".php" || substr($file, -5) == ".html") {
					echo "<a href='$fpath'>$file</a><br>";
					continue;
				}
			}
		}

		// Dossiers
		foreach ($files as $file) {
			$fpath = $path . "/" . $file;
			if (is_dir($fpath)) {
				// ignorer le dossier common
				if ($file != "." && $file != ".." && $file != "common") {
					scanFolder($fpath);
				}
			}
		}
	}

	// afficher un lien vers tous les .php et .html du projet
	// et sous-dossiers
	scanFolder(".");
	
	require('common/footer.php')
?>
