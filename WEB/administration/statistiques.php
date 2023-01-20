<!DOCTYPE html>

<html lang="fr">

<head>

    <title>Page statistiques</title>

    <?php require "../common/header.php"; ?>
    <?php require "../common/verif_est_admin.php"; ?>

    <h2>Les statistiques</h2>

    <a href="../Page_accueil/Page_accueil.php" class = "bouton-retour">Retour à l'accueil</a>
    
    <!-- Graphique en secteur -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            // Si l'écran est plus petit que 900px, modifier la taille du graphique
            var width = window.innerWidth;
            var height = window.innerHeight;
            if (width < 900) {
                width = width * 0.9;
                height = height * 0.3;
            } else {
                width = width * 0.5;
                height = height * 0.3;
            }
            var piechart = document.getElementById('piechart_genres');
            piechart.style.width = width + 'px';
            piechart.style.height = height + 'px';
            var graph_ages = document.getElementById('graph_ages');
            graph_ages.style.width = width + 'px';
            graph_ages.style.height = height + 'px';

            <?php
            $req = $bdd->query("SELECT genre, COUNT(*) AS nbPersonnes FROM infoPersonne GROUP BY genre");
            $nbParGenre = $req ? $req->fetchAll() : [];
            $nbHomme = 0;
            $nbFemme = 0;
            $nbAutre = 0;
            $nbInconnu = 0;
            foreach ($nbParGenre as $genre) {
                switch ($genre['genre']) {
                    case 'M':
                        $nbHomme += $genre['nbPersonnes'];
                        break;
                    case 'F':
                        $nbFemme += $genre['nbPersonnes'];
                        break;
                    case 'A':
                        $nbAutre += $genre['nbPersonnes'];
                        break;
                    default:
                        $nbInconnu += $genre['nbPersonnes'];
                        break;
                }
            }
            ?>

            {
                let data = google.visualization.arrayToDataTable([
                    ['Humain', 'Nombre'],
                    ['Hommes', <?= $nbHomme ?>],
                    ['Femmes', <?= $nbFemme ?>],
                    ['Autre', <?= $nbAutre ?>],
                    ['Inconnu', <?= $nbInconnu ?>],
                ]);
                let options = {
                    title: 'Proportion des genres des utilisateurs'
                };
                let chart = new google.visualization.PieChart(piechart);
                chart.draw(data, options);
            }

            // Graphique à colonnes pour les tranches d'âge des utilisateurs
            // Tranches d'âge : [18;24], ]24;45], ]45;65], 65+
            <?php
            // récupérer l'âge dans infoPersonne avec dateNais
            // Calculer l'âge
            $req = $bdd->query("SELECT TIMESTAMPDIFF(YEAR, dateNais, CURDATE()) AS age, COUNT(*) AS nbPersonnes FROM infoPersonne GROUP BY age");
            $nbParAge = $req ? $req->fetchAll() : [];
            $nb18_24 = 0;
            $nb24_45 = 0;
            $nb45_65 = 0;
            $nb65 = 0;
            echo "// count : " . count($nbParAge) . "\n";
            foreach ($nbParAge as $age) {
                echo "// " . $age['age'] . " : " . $age['nbPersonnes'] . " personnes\n";
                if ($age['age'] < 24) {
                    $nb18_24 += $age['nbPersonnes'];
                } else if ($age['age'] < 45) {
                    $nb24_45 += $age['nbPersonnes'];
                } else if ($age['age'] < 65) {
                    $nb45_65 += $age['nbPersonnes'];
                } else {
                    $nb65 += $age['nbPersonnes'];
                }
            }
            ?>

            {
                let data = google.visualization.arrayToDataTable([
                    ['Tranche d\'âge', 'Nombre'],
                    ['18-23', <?= $nb18_24 ?>],
                    ['24-44', <?= $nb24_45 ?>],
                    ['45-64', <?= $nb45_65 ?>],
                    ['65+', <?= $nb65 ?>],
                ]);
                let options = {
                    title: 'Tranches d\'âge des utilisateurs',
                    legend: { position: 'none' },
                    
                };
                let chart = new google.visualization.ColumnChart(graph_ages);
                chart.draw(data, options);
            }
        }

    </script>

    <style>
        .google_chart {
            margin: auto;
        }
        .google_chart:last-child {
            margin-bottom: 50px;
        }
    </style>

    <br>

    <div class="google_chart" id="piechart_genres" style="width: 900px; height: 500px;"></div>
    <div class="google_chart" id="graph_ages" style="width: 900px; height: 500px;"></div>

    <?php require "../common/footer.php"; ?>
