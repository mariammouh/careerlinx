<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Répartition des secteurs d'activité</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h3>obtenir la répartition des secteurs d'activité des entreprises inscrit </h3>
    <div style="width: 800px; height: 400px;">
        <canvas id="myChart" width="800" height="400"></canvas>
    </div>
    <script>
        <?php
        // Pour obtenir la répartition des secteurs d'activité des entreprises dans un diagramme en secteurs 
        // Connexion à la base de données
        $conn = new mysqli('localhost', 'root', '', 'careerlinx');
        if ($conn->connect_error) {
            die("Erreur de connexion à la base de données : " . $conn->connect_error);
        }

        // Récupération des données des secteurs d'activité
        $sql = "SELECT Secteur_Activite, COUNT(*) as Nombre_Entreprises FROM entreprise GROUP BY Secteur_Activite";
        $result = $conn->query($sql);

        // Conversion des données en format compatible avec Chart.js
        $labels = [];
        $data = [];
        $backgroundColor = [];
        while ($row = $result->fetch_assoc()) {
            $labels[] = $row['Secteur_Activite'];
            $data[] = $row['Nombre_Entreprises'];
            // Générer une couleur aléatoire pour chaque secteur
            $backgroundColor[] = "rgba(" . rand(0, 255) . "," . rand(0, 255) . "," . rand(0, 255) . ",0.5)";
        }

        // Création de l'objet de données pour Chart.js
        $chart_data = [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $backgroundColor
                ]
            ]
        ];

        // Conversion de l'objet de données en JSON pour l'insérer dans le script
        echo "const data = " . json_encode($chart_data) . ";";
        ?>

        const config = {
            type: 'polarArea',
            data: data,
            options: {}
        };

        var myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>
</body>
</html>
