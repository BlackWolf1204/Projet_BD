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
                height = height * 0.5;
            } else {
                width = width * 0.5;
                height = height * 0.5;
            }
            var piechart = document.getElementById('piechart');
            piechart.style.width = width + 'px';
            piechart.style.height = height + 'px';

            <?php
            $req = $bdd->query("SELECT COUNT(*) FROM infoPersonne WHERE genre = 'M'");
            $nbHomme = $req ? $req->fetch()[0] : 0;
            $req = $bdd->query("SELECT COUNT(*) FROM infoPersonne WHERE genre = 'F'");
            $nbFemme = $req ? $req->fetch()[0] : 0;
            $req = $bdd->query("SELECT COUNT(*) FROM infoPersonne WHERE genre = 'A'");
            $nbAutre = $req ? $req->fetch()[0] : 0;
            ?>

            var data = google.visualization.arrayToDataTable([
                ['Humain', 'Nombre'],
                ['Hommes', <?= $nbHomme ?>],
                ['Femmes', <?= $nbFemme ?>],
                ['Autre', <?= $nbAutre ?>],
            ]);

            var options = {
                title: 'Proportion des genres des utilisateurs'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>

    <style>
        #piechart {
            margin: auto;
        }

        #piechart rect {
            opacity: 0;
        }
    </style>

    <br>

    <div id="piechart" style="width: 900px; height: 500px;"></div>

    </body>

    <?php require "../common/footer.php"; ?>

</html>