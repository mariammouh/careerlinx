<?php 

$errors = [];
session_start();
$id_etud = $_SESSION["id_user"];
$fullname=$_SESSION["nom"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "imglogo/étudiants/"; // Specify the directory where you want to store the uploaded files
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    
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
        $targetFile = $targetDir . $fullname .  $id_etud. "." . $imageFileType;
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $errors[] = "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
          }
      }
      if (isset($_POST['email']))
      $email = $_POST["email"];
      if (isset($_POST['niveau_academique']))
      $niveau = $_POST["niveau_academique"];
      if (isset($_POST['domaine_etude']))
      $domaine_etude = $_POST["domaine_etude"];
      if (isset($_POST['note']))
      $note_obtention =(float) $_POST["note"];
      if (isset($_POST['tel']))
      $tel = (string)$_POST['tel'];
      if (isset($_POST['adresse']))
      $adresse = $_POST["adresse"];
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
       if($email!== $_SESSION["email"]) {
        $sql="UPDATE `utilisateur` SET `email` = '$email' WHERE `utilisateur`.`id_utilisateur` = '$id_etud'";
        if ($conn->query($sql) === FALSE) {
            $errors[] = "Erreur lors de l'insertion des données de l'étudiant: " . $conn->error;
          } 
         $_SESSION["email"] = $email  ;
    }
        $sql_etudiant="UPDATE `etudiant` SET `adresse` = '$adresse',
         `num_telephone` = '$tel', `niveau_academique` = '$niveau',
          `domaine_etude` = '$domaine_etude',`note` =  $note_obtention 
          WHERE `etudiant`.`id_etudiant` = '$id_etud'";
        
        if ($conn->query($sql_etudiant) === FALSE) {
            $errors[] = "Erreur lors de l'insertion des données de l'étudiant: " . $conn->error;
          } else {
            header("Location: dashboardEtud.php");
            exit();
          }
        }
     foreach($errors as $e ) echo $e;
        // Close the connection
        $conn->close();
      }
?>