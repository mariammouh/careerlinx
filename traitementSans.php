
<?php
// traitement.php
session_start();
$id_diplome = $_SESSION["id_dip"];
function sanitizeInput($data) {
    // Remove leading and trailing whitespaces
    $data = trim($data);
    // Unquotes a quoted string
    $data = stripslashes($data);
    // Convert special characters to HTML entities
    $data = htmlspecialchars($data);
    // Escape single quotes
    $data = str_replace("'", "\'", $data);
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
    $date_limite = $_POST["date_limite"];
    $seuil_selection = $_POST["seuil_selection"];
    $filess=implode(" ",$_POST["files"]);
        
$f=sanitizeInput($filess);



    $sql_inscription = "INSERT INTO inscription_concour (ID_Diplome, Date_limite_inscription, fichier_necessaire, seuil_selection) VALUES ('$id_diplome', '$date_limite', '$f', '$seuil_selection')";
    if ($conn->query($sql_inscription) === FALSE) {
        echo "Error: " . $sql_inscription . "<br>" . $conn->error;
    }

    $conn->close();

    // header("Location: diplomes.php");
}
?>