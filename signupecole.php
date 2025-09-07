<!DOCTYPE html>

<?php

// $errors = [];

// // Vérifier si le formulaire est soumis
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
//   // Valider le nom de l'école
//   $school_name = $_POST["school_name"];
//   if (!preg_match("/^[a-zA-Z ]*$/", $school_name)) {
//     $errors[] = "Le nom de l'école ne doit contenir que des caractères alphabétiques";
//   }

//   // Valider l'emplacement
//   $location = $_POST["location"];
//   if (empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
//     $errors[] = "L'adresse e-mail n'est pas valide.";
//   }
//   if ($_POST["password"] !== $_POST["password_confirmation"]) {
//     $errors[] = "Le mot de passe n'est pas confirmé.";
//   }
//   if (empty($_POST["conditions"])) {
//     $errors[] = "Vous devez accepter les conditions de notre site web.";
//   }

//   // Vérifier si un fichier image est téléchargé
//   if (!empty($_FILES["image"]["name"])) {
//     $targetDir = "imglogo/école/"; // Spécifier le répertoire où vous souhaitez stocker les fichiers téléchargés
//     $targetFile = $targetDir . basename($_FILES["image"]["name"]);
//     $uploadOk = 1;
//     $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

//     // Vérifier si le fichier est une image réelle
//     $check = getimagesize($_FILES["image"]["tmp_name"]);
//     if ($check === false) {
//         $errors[] = "Le fichier n'est pas une image.";
//         $uploadOk = 0;
//       }
  
//       // Vérifier la taille du fichier
//       if ($_FILES["image"]["size"] > 500000) {
//         $errors[] = "Désolé, votre fichier est trop volumineux.";
//         $uploadOk = 0;
//       }
  
//       // Autoriser certains formats de fichier
//       if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
//         $errors[] = "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
//         $uploadOk = 0;
//       }
  
//       // Vérifier si $uploadOk est défini sur 0 en raison d'une erreur
//       if ($uploadOk == 0) {
//         $errors[] = "Désolé, votre fichier n'a pas été téléchargé.";
//       } else {
//         // Déplacer le fichier téléchargé vers le répertoire cible
//         if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
//           $errors[] = "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
//         }
//       }
//   }

//   // Vérifier s'il y a des erreurs
//   if (empty($errors)) {
//     // Connecter à la base de données
//     $servername = "localhost";
//     $username = "root";
//     $password = "";
//     $dbname = "careerlinx";
//     $conn = new mysqli($servername, $username, $password, $dbname);

//     // Vérifier la connexion
//     if ($conn->connect_error) {
//       die("Connexion échouée: " . $conn->connect_error);
//     }

//     // Insérer les données dans la base de données
//     $email = $_POST["email"];
//     $password = $_POST["password"];
//     $sql_user = "INSERT INTO utilisateur (email, pass_word, utilisateur_type) VALUES ('$email', '$password', 'école')";
//     if ($conn->query($sql_user) === FALSE) {
//       $errors[] = "Erreur lors de l'insertion des données d'utilisateur: " . $conn->error;
//     } else {
//       $user_id = $conn->insert_id;
//       $type_ecole = $_POST["type_ecole"];
//       $date_creation = $_POST["date_creation"];
//       $website = $_POST["website"];
//       $num_students = $_POST["num_students"];
//       $num_filieres = $_POST["num_filieres"];
//       $description = $_POST["description"];
//       $Accessibilite = $_POST["Accessibilité"];
//       $Contact = $_POST["Contact"];
//       $sql_ecole = "INSERT INTO Écoles_Universités (Nom_Ecole, Localisation, Date_Creation, siteWeb, nbr_étud, nbr_filière, Description, ID_Ecole, typeEcole, Accessibilité, Contact, logo) VALUES ('$school_name', '$location', '$date_creation', '$website', '$num_students', '$num_filieres', '$description', '$user_id', '$type_ecole', '$Accessibilite', '$Contact', 'plsss')";
//       session_start(); 
//       $_SESSION['imj']=$targetFile;
//       if ($conn->query($sql_ecole) === FALSE) {
//         $errors[] = "Erreur lors de l'insertion des données de l'école: " . $conn->error;
//       } else {
//         header("Location: dashboard.php");
//         exit();
//       }
//     }

//     // Fermer la connexion
//     $conn->close();
//   }
// }

// Afficher les erreurs


?>
<?php 
session_start();
$errors = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
  // Validate the school name
  $school_name = $_POST["school_name"];
  if (!preg_match("/^[a-zA-Z ]*$/", $school_name)) {
    $errors[] = "Le nom de l'école ne doit contenir que des caractères alphabétiques";
  }
  $date_creation = $_POST["date_creation"];
  $current_date = new DateTime();
  $creation_date = new DateTime($date_creation);
  if ($creation_date > $current_date) {
      $errors[] = "La date de création de l'école ne peut pas être postérieure à la date actuelle.";
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
  if (empty($_POST["num_students"]) || $_POST["num_students"] < 1) {
    $errors[] = "Le nombre d'étudiants doit être un entier positif supérieur à zéro.";
}

// Validate $num_filieres
if (empty($_POST["num_filieres"]) || $_POST["num_filieres"] < 1) {
    $errors[] = "Le nombre de filières doit être un entier positif supérieur à zéro.";
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
    $email = $_POST["email"];
    $check_email_query = "SELECT * FROM utilisateur WHERE email = '$email'";
    $result = $conn->query($check_email_query);
    if ($result->num_rows > 0) {
      $errors[] = "Cet email est déjà utilisé";
    } else {
    // Insert user data into the database
    $email = $_POST["email"];
    $password = $_POST["password"];
    $currentDate = date("Y-m-d");
    $sql_user = "INSERT INTO utilisateur (email, pass_word, utilisateur_type,date_inscription) VALUES ('$email', '$password', 'école','$currentDate')";
    if ($conn->query($sql_user) === FALSE) {
      $errors[] = "Erreur lors de l'insertion des données d'utilisateur: " . $conn->error;
    } else {
      $user_id = $conn->insert_id;
      $_SESSION["id_user"]=$user_id;
      $_SESSION["email"]=$email;
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
        header("Location: dashbeco.php");
        exit();
      }
    }

    // Close the connection
    $conn->close();
  }
}
}
?>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;

    }

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #1b2234;
    }

    .contactForm {
      position: relative;
      max-width: 1000px;
      width: 100%;
      border-radius: 6px;
      padding: 30px;
      margin: 0 15px;
      background-color: #fff;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
      padding-bottom: 10px;
      height: fit-content;
    }

    .contactForm header {
      position: relative;
      text-align: center;
      font-size: 20px;
      font-weight: 600;
      color: #333;

      text-shadow: 0px 0px 0px rgb(0, 0, 0);
    }

    .contactForm header::before {
      content: "";
      position: absolute;
      left: 100;
      bottom: -2px;
      height: 3px;
      width: 27px;
      border-radius: 8px;
      background-color: #4070f4;
    }

    img {
      width: 30%;
      height: auto;
      left: 100;
      margin-left: 280px;
      margin-top: 20px;
    }

    .contactForm form {
      position: relative;
      margin-top: 16px;
      min-height: 700px;
      background-color: #fff;
      overflow: hidden;
      height: auto;
      text-shadow: 0px 0px 0px rgb(0, 0, 0);

    }

    .contactForm form .form {
      position: absolute;
      background-color: #fff;
      transition: 0.3s ease;
    }

    .contactForm form .form.second {
      opacity: 0;
      pointer-events: none;
      transform: translateX(100%);
    }

    form.secActive .form.second {
      opacity: 1;
      pointer-events: auto;
      transform: translateX(0);
    }

    form.secActive .form.first {
      opacity: 0;
      pointer-events: none;
      transform: translateX(-100%);
    }

    .contactForm form .title {
      display: block;
      margin-bottom: 8px;
      font-size: 16px;
      font-weight: 600;
      margin: 6px 0;
      color: navy;
      text-shadow: 0px 0px 0px rgb(0, 0, 0);

    }

    .contactForm form .fields {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    form .fields .input-field {
      display: flex;
      width: calc(100% / 3 - 15px);
      flex-direction: column;
      margin: 4px 0;
    }

    .input-field label {
      font-size: 14px;
      font-weight: 500;
      color: #2e2e2e;
    }

    .input-field input,
    select {
      outline: none;
      font-size: 14px;
      font-weight: 400;
      color: #333;
      border-radius: 5px;
      border: 1px solid #aaa;
      padding: 0 15px;
      height: 38px;
      margin: 8px 0;
    }

    .input-field input :focus,
    .input-field select:focus {
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.13);
    }

    .input-field select,
    .input-field input[type="date"] {
      color: #707070;
    }

    .input-field input[type="date"]:valid {
      color: #333;
    }

    .input-field input[type="radio"] {
      display: inline-flex;
    }

    .contactForm form button,
    .backBtn {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 45px;
      max-width: 200px;
      width: 100%;
      border: none;
      outline: none;
      color: #fff;
      border-radius: 5px;
      margin: 25px 0;
      background-color: #4070f4;
      transition: all 0.3s linear;
      cursor: pointer;
      margin-top: 10px;
      margin-bottom: auto;
    }

    .contactForm form .btnText {
      font-size: 14px;
      font-weight: 400;
    }

    form button:hover {
      background-color: #23366b;
    }

    form button i,
    form .backBtn i {
      margin: 0 6px;
    }

    form .backBtn i {
      transform: rotate(180deg);
    }

    form .buttons {
      display: flex;
      align-items: center;
      margin-left: 38%;
    }

    form .buttons button,
    .backBtn {
      margin-right: 14px;
    }

    @media (max-width: 750px) {
      .contactForm form {
        overflow-y: scroll;
      }

      .contactForm form::-webkit-scrollbar {
        display: none;
      }

      form .fields .input-field {
        width: calc(100% / 2 - 15px);
      }
    }

    @media (max-width: 550px) {
      form .fields .input-field {
        width: 100%;
      }
    }

    .type {
      display: inline-flex;
      padding: 30px;
      color: red;
    }

    .btn-warning {

      padding: 10px 12px;
      font-size: 15px;

      border-radius: 3px;
      color: #fff;
      background-color: #618ce7;
      border: 0;
      transition: 0.2s;
      overflow: hidden;
      margin: 10px;

    }

    .btn-warning input[type="file"] {
      cursor: pointer;
      position: absolute;
      left: 0%;
      top: 0%;
      transform: scale(3);
      opacity: 0;
      height: 50px;

    }

    .btn-warning:hover {
      background-color: black;
    }

    .overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 998;
    }

    /* Style for forms */
    .form-popup {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 20px;
      background-color: #f9f9f9;
      border: 1px solid #ccc;
      border-radius: 5px;
      z-index: 999;
      font-size: 14px;

      font-family: "Open Sans", sans-serif;
    }

    .containerHome {
      position: relative;
    }

    :root {
      --primary-clr: #6c00f9;
      --white: #fff;
      --text-clr: #464646;
      --tabs-list-bg-clr: #dfc8fd;
      --btn-hvr: #4e03b0;
    }

    /* Style for close button */
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    .flex_align_justify {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .wrapper {
      min-height: 10vh;
      padding: 0 20px;
    }

    .tc_wrap {
      width: 700px;
      max-width: 100%;
      height: 450px;
      background: var(--white);
      display: flex;
      border-radius: 3px;
      overflow: hidden;
    }

    .tc_wrap .tabs_list {
      width: 200px;
      background: var(--tabs-list-bg-clr);
      height: 100%;
    }

    .tc_wrap .tabs_content {
      width: calc(100% - 200px);
      padding: 0 10px 0 20px;
      height: 100%;
    }

    .tc_wrap .tabs_content .tab_head,
    .tc_wrap .tabs_content .tab_foot {
      color: var(--primary-clr);
      padding: 25px 0;
      height: 70px;
    }

    .tc_wrap .tabs_content .tab_head {
      text-align: center;
    }

    .tc_wrap .tabs_content .tab_body {
      height: calc(100% - 140px);
      overflow: auto;
    }

    .tc_wrap .tabs_list ul {
      padding: 70px 20px;
      text-align: right;
    }

    .tc_wrap .tabs_list ul li {
      padding: 10px 0;
      position: relative;
      margin-bottom: 3px;
      cursor: pointer;
      font-weight: bold;
      transition: all 0.5s ease;
    }

    .tc_wrap .tabs_list ul li:before {
      content: "";
      position: absolute;
      top: 0;
      right: -20px;
      width: 2px;
      height: 100%;
      background: var(--primary-clr);
      opacity: 0;
      transition: all 0.5s ease;
    }

    .tc_wrap .tabs_list ul li.active,
    .tc_wrap .tabs_list ul li:hover {
      color: var(--primary-clr);
    }

    .tc_wrap .tabs_list ul li.active:before {
      opacity: 1;
    }

    .tc_wrap .tabs_content .tab_body .tab_item h3 {
      padding-top: 10px;
      margin-bottom: 10px;
      color: var(--primary-clr);
    }

    .tc_wrap .tabs_content .tab_body .tab_item p {
      margin-bottom: 20px;
    }

    .tc_wrap .tabs_content .tab_body .tab_item.active {
      display: block !important;
    }

    .tc_wrap .tabs_content .tab_foot button {
      width: 125px;
      padding: 5px 10px;
      background: transparent;
      border: 1px solid;
      border-radius: 25px;
      cursor: pointer;
      transition: all 0.5s ease;
    }

    .tc_wrap .tabs_content .tab_foot button.decline {
      margin-right: 15px;
      border-color: var(--tabs-list-bg-clr);
      color: var(--tabs-list-bg-clr);
    }

    .tc_wrap .tabs_content .tab_foot button.agree {
      background: var(--primary-clr);
      border-color: var(--primary-clr);
      color: var(--white);
    }

    .tc_wrap .tabs_content .tab_foot button.decline:hover {
      background: var(--tabs-list-bg-clr);
      color: var(--white);
    }

    .tc_wrap .tabs_content .tab_foot button.agree:hover {
      background: var(--btn-hvr);
      border-color: var(--btn-hvr);
    }

    .terms {
      font-size: 14px;
      font-weight: 500;
      color: #2e2e2e;

    }

    .custum-file-upload {
      height: auto;
      width: auto;
      display: flex;
      flex-direction: column;
      align-items: space-between;
      gap: 20px;
      cursor: pointer;
      align-items: center;
      justify-content: center;
      border: 2px dashed #cacaca;
      background-color: rgba(255, 255, 255, 1);
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0px 48px 35px -48px rgba(0, 0, 0, 0.1);
      margin-top: 15px;
    }

    .custum-file-upload .icon {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .custum-file-upload .icon svg {
      height: 30px;
      fill: rgba(75, 85, 99, 1);
    }

    .custum-file-upload .text {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .custum-file-upload .text span {
      font-weight: 400;
      color: rgba(75, 85, 99, 1);
    }

    .custum-file-upload input {
      display: none;
    }
    .custom-file-upload input[type="file"] {
    display: none;
}

.custom-file-upload label {
    background-color: #007bff;
    color: #fff;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
}
  </style>

  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Responsive Regisration Form</title>
</head>

<body>

  <div class="containerHome">
    <div class="contactForm">
      <header>Inscription pour les écoles</header>

      <img src="eco.png">

      <form action="#" method="post" enctype="multipart/form-data">

        <div class="form first">
          <div class="details d'écoles">
            <span class="title">Les informations d'école :</span>
            <div class="fields">
              <div class="input-field">
                <label for="school_name">Nom de l'école :</label>
                <input type="text" id="school_name" name="school_name" required />
              </div>
              <div class="input-field">
                <label for="location">Localisation :</label>
                <input type="text" id="location" name="location" required />
              </div>
              <div class="input-field">
                <label for="type_ecole">Accessibilité :</label>
                <select id="Accessibilité" name="Accessibilité" required>
                  <option value="" disabled selected>Sélectionnez l'accessibilité.</option>
                  <option value="university">Université</option>
                  <option value="open_for_everyone">polarisation limitée</option>
                  <option value="specific_grade">polarisation ouverte</option>
                </select>
              </div>
              <div class="input-field">
                <label>Type de l'école :</label>
                <select id="type_ecole" name="type_ecole" required>
                  <option value="" disabled selected>Sélectionnez le type d'école</option>
                  <option value="private">private</option>
                  <option value="public">public</option>

                </select>
              </div>
              <div class="input-field">
                <label for="date_creation">Date de création :</label>
                <input type="date" id="date_creation" name="date_creation" required />
              </div>
              <div class="input-field">
                <label for="website">Site Web :</label>
                <input type="url" id="website" name="website" />
              </div>
              <div class="input-field">
                <label for="num_students">Nombre d'étudiants :</label>
                <input type="number" id="num_students" name="num_students" />
              </div>
              <div class="input-field">
                <label for="num_students">Nombre des filières :</label>
                <input type="number" id="num_filieres" name="num_filieres" />
              </div>
              <div class="input-field ">
                <label for="image">Sélectionnez une image/logo pour profile:</label>
                <label class="custum-file-upload" for="file">
                  <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24">
                      <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                      <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                      <g id="SVGRepo_iconCarrier">
                        <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path>
                      </g>
                    </svg>
                  </div>
                  <div class="text">
                    <span>Click to upload image</span>
                  </div>
                  <input type="file" id="file" name="image">
              </div>
              <div class="input-field">
                <label for="description">Description :</label>
                <textarea id="description" name="description" rows="4" required></textarea>
              </div>
            </div>

          </div>
          <div class="details d'inscription">
            <span class="title">Les informations d'inscription :</span>
            <div class="fields">
              <div class="input-field">
                <label for="email">Email</label>
                <input id="email" name="email" type="text" />
                <div class="error"></div>
              </div>
              <div class="input-field">
                <label for="password">Mot de pass :</label>
                <input id="password" name="password" type="password" />
                <div class="error"></div>
              </div>
              <div class="input-field">
                <label for="password2">Confirmez votre mot de pass :</label>
                <input id="password_confirmation" name="password_confirmation" type="password" />
                <div class="error"></div>
              </div>
              <div class="input-field">
                <label>Numéro de téléphone :</label>
                <input type="tel" placeholder="Enter mobile number" id="Contact" name="Contact" required />
              </div>
              <br>
            </div>
            <input type="checkbox" id="conditions" name="conditions">
            <label for="termsCheckbox" class="terms">Je confirme avoir lu et accepté les <a href="#" onclick="openForm('termsForm', event)">termes et conditions</a></label>
          </div>


          <div class="error" style="color: red; font-style: italic;">
            <?php
           if (!empty($errors)) {
            foreach ($errors as $error) {
              echo "<p>$error</p>";
            }
         
          }
            ?>
          </div>
          <div class="buttons">
            <button type="submit" class="sumbit" >Envoyer</button>
          </div>
        </div>
    
    </form>
  </div>
  <div id="overlay" class="overlay" onclick="closeForms()"></div>
  <div id="termsForm" class="form-popup">
    <div class="form-container">
      <span class="close" onclick="closeForm('termsForm')">&times;</span>
      <div class="wrapper flex_align_justify">
        <div class="tc_wrap">
          <div class="tabs_list">
            <ul>
              <li data-tc="tab_item_1" class="active">Conditions d'utilisation</li>
              <li data-tc="tab_item_2">Droits de propriété intellectuelle</li>
              <li data-tc="tab_item_3">Activités interdites</li>
              <li data-tc="tab_item_4">Clause de résiliation</li>
              <li data-tc="tab_item_5">Loi applicable</li>
            </ul>
          </div>

          <div class="tabs_content">
            <div class="tab_head">
              <h2>Conditions Générales d'Utilisation</h2>
            </div>
            <div class="tab_body">
              <div class="tab_item tab_item_1">
                <h3>Conditions d'utilisation</h3>
                <p> Cette section décrit les conditions générales d'utilisation du site, régissant l'accès et l'utilisation des services proposés. En acceptant ces conditions, l'utilisateur s'engage à respecter les règles énoncées et à utiliser le site de manière légale et appropriée. Les conditions d'utilisation définissent également les droits et responsabilités de l'utilisateur, ainsi que les obligations du site envers ses utilisateurs. En cas de non-respect de ces conditions, le site se réserve le droit de prendre des mesures appropriées, y compris la résiliation du compte utilisateur.</p>
              </div>
              <div class="tab_item tab_item_2" style="display: none;">
                <h3>Droits de propriété intellectuelle</h3>
                <p> Dans cette section, sont abordés les droits de propriété intellectuelle liés au contenu du site. Ces droits comprennent les droits d'auteur, les marques déposées et d'autres droits de propriété intellectuelle associés au contenu publié sur le site. L'utilisateur reconnaît et accepte que tout le contenu du site est protégé par des lois sur la propriété intellectuelle et ne peut être utilisé ou reproduit sans autorisation préalable. Toute utilisation non autorisée du contenu peut entraîner des poursuites judiciaires.</p>
              </div>
              <div class="tab_item tab_item_3" style="display: none;">
                <h3>Activités interdites</h3>
                <p>Cette section énumère les activités qui sont strictement interdites sur le site. Ces activités incluent, mais ne se limitent pas à, la fraude, le harcèlement, la diffusion de contenu illicite, la violation des droits d'auteur et tout comportement considéré comme contraire aux lois en vigueur. Le site se réserve le droit de prendre des mesures appropriées contre tout utilisateur qui se livre à de telles activités, y compris la suspension ou la résiliation de son compte.</p>

              </div>
              <div class="tab_item tab_item_4" style="display: none;">
                <h3>Clause de résiliation</h3>
                <p>La clause de résiliation énonce les conditions dans lesquelles le site peut résilier le compte d'un utilisateur. Ces conditions peuvent inclure le non-respect des conditions d'utilisation, le comportement inapproprié, la violation des lois ou toute autre activité contraire aux politiques du site. En cas de résiliation du compte, l'utilisateur peut perdre l'accès à certaines fonctionnalités du site et peut ne pas être autorisé à créer un nouveau compte sans autorisation préalable.</p>
              </div>
              <div class="tab_item tab_item_5" style="display: none;">
                <h3>Loi applicable</h3>
                <p>Cette section précise la loi applicable aux conditions d'utilisation du site. En acceptant ces conditions, l'utilisateur reconnaît que toute utilisation du site est soumise à la législation en vigueur dans le pays où le site est exploité. En cas de litige, les tribunaux compétents seront ceux du pays où le site est hébergé. L'utilisateur accepte de se conformer à ces lois et de respecter les décisions des tribunaux compétents.</p>
              </div>
            </div>
            <!-- <div class="tab_foot flex_align_justify">
                <button class="decline">
                    Refuser
                </button>
                <button class="agree">
                    Accepter
                </button>
            </div>
        </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function openForm(formId, event) {
      event.preventDefault();
      document.getElementById("overlay").style.display = "block";
      document.getElementById(formId).style.display = "block";
    }

    function closeForm(formId) {
      document.getElementById("overlay").style.display = "none";
      document.getElementById(formId).style.display = "none";
    }

    function closeForms() {
      document.getElementById("overlay").style.display = "none";
      document.querySelectorAll(".form-popup").forEach(function(form) {
        form.style.display = "none";
      });
    }
    var tab_lists = document.querySelectorAll(".tabs_list ul li");
    var tab_items = document.querySelectorAll(".tab_item");

    tab_lists.forEach(function(list) {
      list.addEventListener("click", function() {
        var tab_data = list.getAttribute("data-tc");

        tab_lists.forEach(function(list) {
          list.classList.remove("active");
        });
        list.classList.add("active");

        tab_items.forEach(function(item) {
          var tab_class = item.getAttribute("class").split(" ");
          if (tab_class.includes(tab_data)) {
            item.style.display = "block";
          } else {
            item.style.display = "none";
          }

        })

      })
    })
  </script>
</body>

</html>