<?php 
session_start();
$id_admin = $_SESSION['id_admin'];
$email = $_SESSION["email"];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "careerlinx";
$id_probleme = 1;
if ($_SERVER["REQUEST_METHOD"] == "GET") {
   
    $date_premiere_apparition = $_GET["date_premiere_apparition"];
    $description = $_GET["description"];
    $date_resolution = $_GET["date_resolution"];
    $titre = $_GET["titre"];
    $statut = $_GET["statut"];
    if(isset($_GET["id_probleme"]))
    $id_probleme = $_GET["id_probleme"];

$sql = "UPDATE probleme SET 
date_premiere_apparition = '$date_premiere_apparition',
description = '$description',
date_resolution = '$date_resolution',
titre = '$titre',
statut = '$statut'
WHERE id_probleme = $id_probleme";
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($conn->query($sql) === TRUE) {
} else {
}

// Save in problem_admin table
$id_admin = $_SESSION["id_admin"]; // Assuming you have the admin ID in the session

$sql_admin = "INSERT INTO probelm_admin (id_probleme, id_admin) 
      VALUES ($id_probleme, $id_admin)";

if ($conn->query($sql_admin) === TRUE) {
} else {
}
header("Location:problems.php");
$conn->close();
}

?>