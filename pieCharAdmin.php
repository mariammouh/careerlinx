<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carrerlinx";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Récupérer le nombre d'inscriptions d'étudiants
$sql = "SELECT COUNT(*) as total_etudiants FROM utilisateur WHERE utilisateur_type = 'etudiant'";
$result_etudiants = $conn->query($sql);
$row_etudiants = $result_etudiants->fetch_assoc();
$total_etudiants = $row_etudiants['total_etudiants'];

// Récupérer le nombre d'inscriptions d'écoles
$sql = "SELECT COUNT(*) as total_ecoles FROM écoles_universités";
$result_ecoles = $conn->query($sql);
$row_ecoles = $result_ecoles->fetch_assoc();
$total_ecoles = $row_ecoles['total_ecoles'];

// Récupérer le nombre d'inscriptions d'entreprises
$sql = "SELECT COUNT(*) as total_entreprises FROM entreprise";
$result_entreprises = $conn->query($sql);
$row_entreprises = $result_entreprises->fetch_assoc();
$total_entreprises = $row_entreprises['total_entreprises'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyChart</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<h3> taux des etudiant , ecoles et entreprise inscrit a crrerlinx</h3>
  <div style="width: 400px; height: 400px;">
    <canvas id="myChart" width="400" height="400"></canvas>
  </div>
  <script>
    const data = {
      labels: [
        'Étudiants',
        'Écoles',
        'Entreprises'
      ],
      datasets: [{
        label: 'Nombre d\'inscriptions',
        data: [<?php echo $total_etudiants; ?>, <?php echo $total_ecoles; ?>, <?php echo $total_entreprises; ?>],
        backgroundColor: [
          'rgb(255, 99, 132)',
          'rgb(54, 162, 235)',
          'rgb(255, 205, 86)'
        ],
        hoverOffset: 4
      }]
    };

    const config = {
      type: 'doughnut',
      data: data,
    };

    var myChart = new Chart(
      document.getElementById('myChart'),
      config
    );
  </script>
</body>

</html>
