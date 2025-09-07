<?php 
$errors = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
  // Validate the school name
  $school_name = $_POST["school_name"];
  if (!preg_match("/^[a-zA-Z ]*$/", $school_name)) {
    $errors[] = "Le nom de l'école ne doit contenir que des caractères alphabétiques";
  }

  // Validate the location
  $location = $_POST["location"];
  if (empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "L'adresse e-mail n'est pas valide.";
  }
  if ($_POST["password"] !== $_POST["password_confirmation"]) {
    $errors[] = "Le mot de passe n'est pas confirmé.";
  }
  if (empty($_POST["conditions"])) {
    $errors[] = "Vous devez accepter les conditions de notre site web.";
  }

  // Check if an image file is uploaded
  if (!empty($_FILES["image"]["name"])) {
    $targetDir = "imglogo/école/"; // Specify the directory where you want to store the uploaded files
    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    // $targetFile = $targetDir . $school_name . "." . $imageFileType; // Customize the image file name

    // Check if the file is a valid image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
      $errors[] = "Le fichier n'est pas une image.";
    }
  
    // Check the file size
    if ($_FILES["image"]["size"] > 500000) {
      $errors[] = "Désolé, votre fichier est trop volumineux.";
    }
  
    // Allow certain file formats
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
      $errors[] = "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
    }
  
    // Check if there are any errors
   
  }

  // Check if there are any errors
  if (empty($errors)) {
    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "careerlinx";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
      die("Connexion échouée: " . $conn->connect_error);
    }

    // Insert user data into the database
    $email = $_POST["email"];
    $password = $_POST["password"];
    $sql_user = "INSERT INTO utilisateur (email, pass_word, utilisateur_type) VALUES ('$email', '$password', 'école')";
    if ($conn->query($sql_user) === FALSE) {
      $errors[] = "Erreur lors de l'insertion des données d'utilisateur: " . $conn->error;
    } else {
      $user_id = $conn->insert_id;
      $type_ecole = $_POST["type_ecole"];
      $date_creation = $_POST["date_creation"];
      $website = $_POST["website"];
      $num_students = $_POST["num_students"];
      $num_filieres = $_POST["num_filieres"];
      $description = $_POST["description"];
      $Accessibilite = $_POST["Accessibilité"];
      $Contact = $_POST["Contact"];
      $targetFile = $targetDir . $school_name . $user_id . "." . $imageFileType;
      $sql_ecole = "INSERT INTO Écoles_Universités (Nom_Ecole, Localisation, Date_Creation, siteWeb, nbr_étud, nbr_filière, Description, ID_Ecole, typeEcole, Accessibilité, Contact, logo) VALUES ('$school_name', '$location', '$date_creation', '$website', '$num_students', '$num_filieres', '$description', '$user_id', '$type_ecole', '$Accessibilite', '$Contact', '$targetFile')";
      if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $errors[] = "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
      }
      if ($conn->query($sql_ecole) === FALSE) {
        $errors[] = "Erreur lors de l'insertion des données de l'école: " . $conn->error;
      } else {
        header("Location: dashboard.php");
        exit();
      }
    }

    // Close the connection
    $conn->close();
  }
}
?>