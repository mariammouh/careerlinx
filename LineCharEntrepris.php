<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "careerlinx";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Requête SQL pour récupérer le nombre de visites par jour pour l'entreprise X
$sql = "SELECT DATE(Date_Creation) AS Jour, COUNT(*) AS NombreVisites FROM entreprise    GROUP BY DATE(Date_Creation)";
$result = $conn->query($sql);

// Création des tableaux pour les labels et les données du graphique
$labels = [];
$data = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    // Ajouter le label au format 'Jour'
    $labels[] = $row["Jour"];
    $data[] = $row["NombreVisites"];
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nombre de visites par jour pour l'entreprise X</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div style="width: 800px; height: 400px;">
  <canvas id="myChart" width="800" height="400"></canvas>
</div>

<script>
const labels = <?php echo json_encode($labels); ?>;
const data = {
  labels: labels,
  datasets: [{
    label: 'Nombre de visites',
    data: <?php echo json_encode($data); ?>,
    fill: false,
    borderColor: 'rgb(75, 192, 192)',
    tension: 0.1
  }]
};

const config = {
  type: 'line',
  data: data,
};
var myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>
</body>
</html>
