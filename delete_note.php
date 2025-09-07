<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "careerlinx";

session_start();
$id_etud = $_SESSION["id_user"];
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id_note = $_GET['id'];

    $sql = "DELETE FROM note WHERE id_note = '$id_note'";

    if ($conn->query($sql) === TRUE) {
        header("Location: archive.php?message=deleted");
        exit();
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>