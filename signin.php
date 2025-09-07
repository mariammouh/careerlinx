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
                header("Location: dashbeco.php");
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
          
           $_SESSION["email"]= $email ;
            // Verify password
            if ($password===$admin_row["pass_word"]) {
                $_SESSION['id_admin']=$admin_row["id_admin"];
                header("Location: dashboardAdmin.php");
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
    <title>Login Form</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');

body{
    font-family: 'Poppins', sans-serif;
    background: #ececec;
}



.box-area{
    width: 930px;
}



.right-box{
    padding: 40px 30px 40px 40px;
}



::placeholder{
    font-size: 16px;
}

.rounded-4{
    border-radius: 20px;
}
.rounded-5{
    border-radius: 30px;
}




@media only screen and (max-width: 768px){

     .box-area{
        margin: 0 10px;

     }
     .left-box{
        height: 100px;
        overflow: hidden;
     }
     .right-box{
        padding: 20px;
     }

}
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
            margin-top: 20px;
            left: 170px;
            
        }
        .lb{
            position: relative;
            display: inline-block;
            margin-bottom: 10px;
            left: 150px;
             
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
<form action="#" class="form" method="post">
    <!----------------------- Main Container -------------------------->

     <div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!----------------------- Login Container -------------------------->

       <div class="row border rounded-5 p-3 bg-white shadow box-area">

    <!--------------------------- Left Box ----------------------------->

    <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: -webkit-linear-gradient( #1d3ede, #01e6f8);">
           <div class="featured-image mb-3">
            <img src="2.png" class="img-fluid" style="width: 600px;">
           </div>
           
       </div>

    <!-------------------- ------ Right Box ---------------------------->
        
       <div class="col-md-6 right-box">
          <div class="row align-items-center">
                <div class="header-text mb-4">
                <h2>Bonjour, encore une fois</h2>
<p>Nous sommes heureux de vous revoir.</p>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="email" class="form-control form-control-lg bg-light fs-6" placeholder="Email address">
                </div>
                <div class="input-group mb-1">
                    <input type="password"  name="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password">
                </div>
                

                <label class="switch">
                <input type="checkbox" id="userTypeSwitch" name="userType" value="user">
                <span class="slider round"></span>
            </label>
            <label  class="lb"  for="userTypeSwitch" id="userLabel">Utilisateur</label>
            <label  class="lb" for="userTypeSwitch" id="adminLabel" style="display:none;">Admin</label>
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

                <div class="input-group mb-3">
                    <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Se connecter</button>
                </div>
                <div class="input-group mb-3">
                
                </div>
                <div class="row">
                <small>Vous n'avez pas de compte ? <a href="#">Inscrivez-vous</a></small>
                </div>
          </div>
       </div> 

      </div>
    </div>
</form>
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