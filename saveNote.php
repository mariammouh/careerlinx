<?php
include_once "dashboardEtud.php";

$id_etud = $_SESSION["id_user"];
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "careerlinx";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$note_title = $_POST['note_title'];
$note_text = $_POST['contenu'];
$date_creation = date("Y-m-d H:i:s"); // Utilisez la fonction date pour obtenir la date actuelle au format MySQL

$sql = "INSERT INTO note (id_etudiant,note_title, contenu, date_creation) VALUES ('$id_etud ','$note_title', '$note_text', '$date_creation')";

if ($conn->query($sql) === TRUE) {
    // header("Location: archive.php?message=success");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>