<?php
// require_once "search.php";
session_start();
$errors = [];
$id_etud = $_SESSION["id_user"];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "careerlinx";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
  die("Connexion échouée: " . $conn->connect_error);
}
function inscrir($id)
{
  global $conn;
  $sql = "SELECT * FROM inscription_concour WHERE ID_Diplome='$id'";
  $result = $conn->query("SELECT * FROM inscription_concour WHERE ID_Diplome='$id'");
  $data = array();
  if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

      if (strtotime($row['Date_limite_inscription']) > time()) {

        return $row;
      }
    }

    if (empty($data)) return false;
  } else
    return false;
}
function info($id,$note)
{
  global $conn;
  $sql = "SELECT * FROM etudiant WHERE etudiant.id_etudiant='$id'	";
  $result = $conn->query($sql);
  $data = array();
  if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

      if ($row['note'] >=$note) {
        return $row;
      }
    }

    if (empty($data)) return false;
  } else
    return false;
}
$requirements = (inscrir($_SESSION['id_inscri']));
$fichiers="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_con = $_POST["enregistre"];
    foreach ($_FILES as $key =>$name) {
     
        if (!empty($name["name"])) {

            $targetDir = "files/"; // Specify the directory where you want to store the uploaded files
            $imageFileType = strtolower(pathinfo($name["name"], PATHINFO_EXTENSION));
            // $targetFile = $targetDir . $school_name . "." . $imageFileType; // Customize the image file name

            // Check if the file is a valid image
            // $check = getp($name["tmp_name"]);
            // if ($check === false) {
            //   $errors[] = "Le fichier n'est pas une image.";
            // }

            // Check the file size
            if ($name["size"] > 500000) {
                $errors[] = "Désolé, votre fichier est trop volumineux.";
            }

            // Allow certain file formats
            if (!in_array($imageFileType, ["pdf", "docx"])) {
                $errors[] = "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
            }
            if(empty($errors)){
            $targetFile = $targetDir . $id_con . "CON" . $id_etud .$key . "." . $imageFileType;
            if (!move_uploaded_file($name["tmp_name"], $targetFile)) {
                $errors[] = "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
            }
            // echo$targetFile;
            $fichiers=$fichiers."  $key,".$targetFile;
            echo$fichiers;
        }
        }
    }     
   
    // Connect to the database

    $id_in=$requirements['id_inscription'];
    $sql_ecole = "INSERT INTO `resultat`(`id_inscrir`, `id_etud`, `files`) VALUES ('$id_in', '$id_etud','$fichiers')";
    if ($conn->query($sql_ecole) === FALSE) {
        $errors[] = "Erreur lors de l'inscription: ";
        echo '<script>alert("Erreur ' . $conn->error.'");</script>';

      }
    echo$sql_ecole;
    // header("Location:search.php");
}
