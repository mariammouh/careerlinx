<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "careerlinx";

session_start();
$id_etud = $_SESSION["id_user"];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

$year = $_GET["year"];
$month = $_GET["month"];
$day = $_GET["day"];

$sql = "SELECT ce.Titre, ce.Date_concourEntretien, ce.Heure_h, ce.location
        FROM concours_Entretiens ce
        INNER JOIN resultat r ON ce.id_concours = r.id_concours
        WHERE YEAR(ce.Date_concourEntretien) = $year
        AND MONTH(ce.Date_concourEntretien) = $month
        AND DAY(ce.Date_concourEntretien) = $day
        AND r.id_etud = $id_etud
        AND r.resultat = 'en attend'";

$result = $conn->query($sql);

$events = [];
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $events[] = [
      "description" => "Titre: " . $row["Titre"] . ", Date: " . $row["Date_concourEntretien"] . ", Heure: " . $row["Heure_h"] . ", Lieu: " . $row["location"]
    ];
    
  }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($events);
?>