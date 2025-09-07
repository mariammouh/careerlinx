<!DOCTYPE html>
<html lang="en">
<?php
$errors = [];
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email and password
    $email = $_POST["email"];
    $password = $_POST["password"];
    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password_db = ""; // Assuming no password is set
    $dbname = "careerlinx";
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connexion échouée: " . $conn->connect_error);
    }
    $userType = $_POST["switchValue"];

    // Now you can use $userType variable in your PHP code
    // For example, you can use it in conditional statements to perform different actions based on the selected value
    if ($userType === "user") {
        // Check if the user is in the utilisateur table
        $user_query = "SELECT * FROM utilisateur WHERE email = '$email'";
        $user_result = $conn->query($user_query);

        if ($user_result->num_rows > 0) {
            // User found in utilisateur table
            $user_row = $user_result->fetch_assoc();
            // Verify password
            
            if ($password===$user_row["pass_word"]) {
                $_SESSION['id_user']=$user_row["id_utilisateur"];
                $_SESSION["email"]=$email;
                if ($user_row["utilisateur_type"]==="école") {
                header("Location: dashboardEcole.php");
                exit();
                }elseif ($user_row["utilisateur_type"]==="entreprise") {
                    header("Location: dashboardEntreprise.php");
                    exit();
                    }elseif ($user_row["utilisateur_type"]==="étudiant") {
                        header("Location: dashboardEtud.php");
                        exit();
                        }
            } else {
                // Incorrect password
                $errors[] = "Mot de passe incorrect.";
            }
        } else {
            // User not found
            $errors[] = "Aucun utilisateur trouvé avec cet email.";
        }
    } elseif ($userType === "admin") {
        // Check if the user is in the admin table
        $admin_query = "SELECT * FROM admin WHERE email = '$email'";
        $admin_result = $conn->query($admin_query);

        if ($admin_result->num_rows > 0) {
            // User found in admin table
            $admin_row = $admin_result->fetch_assoc();
            $_SESSION['id_admin']=$user_row["id_admin"];
            // Verify password
            if ($password===$admin_row["pass_word"]) {
                // Password is correct, redirect to dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                // Incorrect password
                $errors[] = "Mot de passe incorrect.";
            }
        } else {
            // User not found
            $errors[] = "Aucun admin trouvé avec cet email.";
        }
    }

    // Close the connection
    $conn->close();
}


?>

<head>
    <meta charset="UTF-">
    <meta name="viewport" content="width-device-width,-scale=1.0">
    <title>Login Form</title>

    <style>
        * {

            margin: 0;

            padding: 0;

            box-sizing: border-box;

        }

        body {
            background-color: rgb(255, 255, 255);
        }


        .container {

            display: flex;

            height: 500px;

            width: 800px;

            /* /border: 1px solid black;/ */

            margin: auto;

            margin-top: 50px;
            box-shadow: 3px 3px 20px rgb(189, 188, 188);


        }


        .form {

            display: flex;

            flex-direction: column;

            width: 50%;

            align-items: center;

            background-color: rgb(210, 221, 237);

        }


        .form input {

            width: 70%;

            padding: 10px;

            margin: 10px 0;

            border: 1px solid lightgrey;

            border-radius: 50px;
            box-shadow: 3px 3px 2px rgb(189, 188, 188);


        }

        .form h2 {
            font-size: 3rem;
            /* You can change this value to your desired size */
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            margin: 40px;
            color: rgb(25, 51, 155);
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        }

        .box {
            padding: 12px;
            width: 65%;
            margin: 15px;
            border: 1px solid black;
            outline: none;
            border-radius: 20px;
        }

        #submit {
            padding: 12px 30px;
            width: 40%;
            margin-top: 40px;
            background-color: rgb(36, 74, 226);
            color: white;
            font-weight: bold;
            border: none;
            outline: none;
            border-radius: 20px;
        }

        #submit:hover {
            cursor: pointer;
            background-color: rgb(67, 112, 237);
        }

        .form a:hover {
            color: blueviolet;
        }

        .side {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50%;
            background-color: rgb(255, 255, 255);
        }

        .side img {
            width: 400px;
            height: 420px;
        }

        .checkbox-container {
            display: inline-block;
        }

        .checkbox-container label {
            display: inline-block;
            margin-right: 10px;
        }

        input[type="radio"] {
            width: 1.2em;
            height: 1.2em;
            box-shadow: 0px 0px 0px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
            margin-top: 20px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 50%;
        }

        label {
            margin-top: 10px;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="#" class="form" method="post">
            <h2>SIGN IN </h2>

            <input type="email" name="email" class="box" placeholder="Enter Email">
            <input type="password" name="password" class="box" placeholder="Enter Password">

            <!-- <div class="checkbox-container">
              
              <label><input type="radio" name="choice" value="admin"> Admin</label>
              <label><input type="radio" name="choice" value="etudiant"> Étudiant</label>
              <label><input type="radio" name="choice" value="ecole"> École</label>
              <label><input type="radio" name="choice" value="entreprise"> Entreprise</label>
          </div> -->
            <label class="switch">
                <input type="checkbox" id="userTypeSwitch" name="userType" value="user">
                <span class="slider round"></span>
            </label>
            <label for="userTypeSwitch" id="userLabel">Utilisateur</label>
            <label for="userTypeSwitch" id="adminLabel" style="display:none;">Admin</label>
            <!-- Hidden input field to store the selected value -->
            <input type="hidden" id="switchValue" name="switchValue" value="user">
            <div class="error" style="color: red; font-style: italic;">
                <?php
                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        echo "<p>$error</p>";
                    }
                }
                ?>
            </div>
            <input type="submit" value="SIGN IN" id="submit">
            <a href="#">Oblier mot de passe?</a>
        </form>
        <div class="side">
            <img src="yess.png" alt="">
        </div>
    </div>
</body>
<script>
    // Update the hidden input field value when the switch is toggled
    document.getElementById("userTypeSwitch").addEventListener("change", function() {
        document.getElementById("adminLabel").style.display = this.checked ? "block" : "none";
        document.getElementById("userLabel").style.display = this.checked ? "none" : "block";
        document.getElementById("switchValue").value = this.checked ? "admin" : "user";
    });
</script>

</html>