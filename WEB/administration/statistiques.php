<!DOCTYPE html>

<html lang="fr">

<head>

    <title>Page statistiques</title>

    <?php require "../common/header.php"; ?>

    <h2>Les statistiques</h2>

    <a href="../Page_accueil/Page_accueil.php">Retour</a>

    <!-- Graphique en secteur -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

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