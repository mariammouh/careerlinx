<!DOCTYPE html>
<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "testt";
    if (!empty($_FILES["image"]["name"])) {
    $targetDir = "imglogo/"; // Specify the directory where you want to store the uploaded files
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    
    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "testt";
            $conn = new mysqli($servername, $username, $password, $dbname);
        
            // Vérifier la connexion
            if ($conn->connect_error) {
              die("Connexion échouée: " . $conn->connect_error);
            }
            $sql_ecole = "INSERT INTO images(image) VALUES('$targetFile')";
            $conn->query($sql_ecole);
            session_start(); 
            $_SESSION['gg']['first_section_data'] = $_FILES["image"];
            header("Location: dashboard.php");
       
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }} echo"deosnt exist"; }
    ?>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Image Upload Form</title>
</head>
<body>

<form action="#" method="post" enctype="multipart/form-data">
    <br><br>
    <label for="image">Select Image:</label>
    <input type="file" id="image" name="image"><br><br>
    <input type="submit" value="Upload" name="submit">
</form>

</body>
</html>