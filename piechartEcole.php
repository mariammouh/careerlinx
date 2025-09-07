<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>myChart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<?php
$con = new mysqli('localhost', 'root', '', 'careerlinx');

$query = $con->query("
    SELECT niveau_academique AS niveau, COUNT(*) AS nombre_etudiants
    FROM etudiant
    GROUP BY niveau_academique
");

$niveaux = [];
$nombre_etudiants = [];

while ($data = $query->fetch_assoc()) {
    $niveaux[] = $data['niveau'];
    $nombre_etudiants[] = $data['nombre_etudiants'];
}
?>


<body>
    <h3> nombre etudiant inscrit dans ce ecole x selon leurs niveau acdimique</h3>
    <div><canvas id="pieChart" width="400" height="400"></canvas></div>
   
    <script>
        var ctx = document.getElementById('pieChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($niveaux); ?>,
                datasets: [{
                    label: 'Nombre d\'étudiants',
                    data: <?php echo json_encode($nombre_etudiants); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</html>
