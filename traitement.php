<?php
// Assuming you have established database connection here
session_start();
// $id_diplome=$_SESSION["id_dip"];
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "careerlinx";
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $location = $_POST["location"];
    $date = $_POST["date"]; // Assuming you have date field in the form
    $heure = $_POST["heure"]; // Assuming you have heure field in the form
    $duree = $_POST["duree"]; // Assuming you have duree field in the form
    $date_limite = $_POST["date_limite"]; // Assuming you have date_limite field in the form
    $seuil_selection = $_POST["seuil_selection"]; // Assuming you have seuil_selection field in the form
    $type = $_POST["type"]; // Assuming you have type field in the form
    $url = isset($_POST["url"]) ? $_POST["url"] : ""; // Get URL if provided, otherwise empty string
    $titre = $_POST["titre"];
    $id_diplome=$_SESSION["ID_Dip"];
 

    // Insert data into concours_entretiens table
    $sql_concours = "INSERT INTO concours_entretiens (Titre,Date_concourEntretien, Heure_h, Duree, location ,Type) VALUES ('$titre','$date', '$heure', '$duree', '$location', '$type')";
    if ($conn->query($sql_concours) === TRUE) {
        $id_concours = $conn->insert_id; // Get the ID of the last inserted record
    } else {
        echo "Error: " . $sql_concours . "<br>" . $conn->error;
    }
    $filess=implode(" ",$_POST["files"]);
    
$f=sanitizeInput($filess);
  

    // Insert data into inscription_concour table
    $sql_inscription = "INSERT INTO inscription_concour (ID_Diplome, Date_limite_inscription, fichier_necessaire, seuil_selection, id_concours) VALUES ('$id_diplome', '$date_limite', '$filess', '$seuil_selection', '$id_concours')";
    if ($conn->query($sql_inscription) === FALSE) {
        echo "Error: " . $sql_inscription . "<br>" . $conn->error;
    }
header("Location: diplomes.php");
//     // Close database connection
    $conn->close();
}
?>
