<!DOCTYPE html>
<html>

<head>
    <title>Pie Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="myPieChart" width="400" height="400"></canvas>

    <?php
    session_start();
    $id_ecole = $_SESSION["id_user"];
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "careerlinx";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch data for the current year
    $sql = "SELECT COUNT(inscription_concour.id_etudiant) AS count_etudiant, diplomes.ID_Diplome
            FROM diplomes
            INNER JOIN inscription_concour ON diplomes.ID_Ecole = '$id_ecole'
            INNER JOIN resultat ON inscription_concour.id_inscription = resultat.id_inscription
            GROUP BY diplomes.ID_Diplome";
    $result = $conn->query($sql);

    $data = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[$row['ID_Diplome']] = $row['count_etudiant'];
        }
    }

    $conn->close();
    ?>

    <script>
        // Render pie chart using Chart.js
        var labelsFromPHP = <?php echo json_encode(array_keys($data)); ?>;
        var dataFromPHP = <?php echo json_encode(array_values($data)); ?>;

        var ctx = document.getElementById('myPieChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labelsFromPHP,
                datasets: [{
                    label: 'Number of Students',
                    data: dataFromPHP,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'right'
                }
            }
        });
    </script>
</body>
</html>
