<?php $ROOT = "/"; ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset='utf-8'>
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<title>Projet Maison Économe</title>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel='stylesheet' type='text/css' media='screen' href='style/main.css'>
</head>

<body>
	<?php require('common/header.php') ?>

	<?php
	// afficher un lien vers tous les .php et .html du projet
	$files = scandir(".");
	foreach ($files as $file) {
		if (substr($file, -4) == ".php" || substr($file, -5) == ".html") {
			echo "<a href='$file'>$file</a><br>";
		}
	}

	// et sous-dossiers
	$folders = scandir(".");
	foreach ($folders as $folder) {
		// ignorer le dossier common
		if ($folder == "common") {
			continue;
		}
		if (is_dir($folder) && $folder != "." && $folder != "..") {
			$files = scandir($folder);
			$filesPhp = array_filter($files, function ($file) {
				return substr($file, -4) == ".php" || substr($file, -5) == ".html";
			});
			if (count($filesPhp) == 0) {
				continue;
			}
			echo "<h2>$folder</h2>";
			foreach ($filesPhp as $file) {
				echo "<a href='$folder/$file'>$file</a><br>";
			}
		}
	}

	?>

	<?php require('common/footer.php') ?>
</body>

</html>