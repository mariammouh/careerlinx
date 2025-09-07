<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>myChart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<?php
$con = new mysqli('localhost', 'root', '', 'careerlinx');

$query = $con->query("
    SELECT Nom_Ecole AS ecole, nbr_étud AS nombre_etudiants
    FROM écoles_universités
");

$ecoles = [];
$nombre_etudiants = [];

while ($data = $query->fetch_assoc()) {
    $ecoles[] = $data['ecole'];
    $nombre_etudiants[] = $data['nombre_etudiants'];
}

?>

<body>
<h3> nombre des etudiants selon les ecoles inscrit au site</h3>
<div style="width: 400px; height: 400px;">
  <canvas id="myChart" width="400" height="400"></canvas>
</div>

<script>
      // Data du graphique
      const labels = <?php echo json_encode($ecoles) ?>;
const data = {
  labels: labels,
  datasets: [{
    label: 'Nombre d\'étudiants',
    data: <?php echo json_encode($nombre_etudiants) ?> ,
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)'
    ],
    borderColor: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
    ],
    borderWidth: 1
  }]
};
// </block:setup>

// <block:config:0>
const config = {
  type: 'bar',
  data: data,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
};
// </block:config>


var myChart = new Chart(
    document.getElementById('myChart'),
    config
  );

  

</script>

</body>
</html>