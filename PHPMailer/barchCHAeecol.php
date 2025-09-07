<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carrerlinx";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Requête SQL pour compter le nombre d'inscriptions par année
$sql = "SELECT YEAR(Date_limite_inscription) AS Annee, COUNT(*) AS NombreInscriptions FROM inscription_concour GROUP BY YEAR(Date_limite_inscription)";

$result = $conn->query($sql);

$labels = [];
$data = [];

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $labels[] = $row["Annee"];
    $data[] = $row["NombreInscriptions"];
  }
} else {
  echo "0 results";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nombre d'inscriptions par année</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <h3>nombre d'inscription a cette ecole x </h3>
<div style="width: 400px; height: 400px;">
  <canvas id="myChart" width="400" height="400"></canvas>
</div>

<script>
  const labels = <?php echo json_encode($labels); ?>;
  const data = {
    labels: labels,
    datasets: [{
      label: 'Nombre d\'inscriptions par année',
      data: <?php echo json_encode($data); ?>,
      backgroundColor: 'rgba(255, 99, 132, 0.2)',
      borderColor: 'rgb(255, 99, 132)',
      borderWidth: 1
    }]
  };

  const config = {
    type: 'bar',
    data: data,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  };

  var myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>
</body>
</html>
