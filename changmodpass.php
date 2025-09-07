<?php session_start();
$id_user = $_SESSION["id_user"];
$errors = [];

if (isset($_POST["password"]) && !empty($_POST["password"]) && !empty($_POST["password_confirmation"]) && isset($_POST["password_confirmation"])) {
    $password = $_POST["password"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "careerlinx";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connexion échouée: " . $conn->connect_error);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST["password"] !== $_POST["password_confirmation"]) {
            $errors[] = "Le mot de passe n'est pas confirmé.";
        }
        $old_password=$_POST["old_password"];
        $password=$_POST["password"];
            // Check if the user is in the utilisateur table
            $user_query = "SELECT * FROM utilisateur WHERE id_utilisateur = $id_user";
            $user_result = $conn->query($user_query);

            if ($user_result->num_rows > 0) {
                // User found in utilisateur table
                $user_row = $user_result->fetch_assoc();
                // Verify password

                if ($old_password !== $user_row["pass_word"]) {
                    $errors[] = "Le mot de passe n'est pas correct.";
                }


                if (empty($errors)) {


                    $sql_Update_noti = "UPDATE utilisateur SET pass_word = '$password' WHERE id_utilisateur = $id_user ";
                    if ($conn->query($sql_Update_noti) === FALSE) {
                        echo '<script>alert("Erreur lors de l\'insertion des données de l\'étudiant: ' . $conn->error . '");</script>';
                    }
                }
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> Forgot Password</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        /*!
 * Start Bootstrap - SB Admin 2 v4.1.3 (https://startbootstrap.com/theme/sb-admin-2)
 * Copyright 2013-2021 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin-2/blob/master/LICENSE)
 */
.mr-6{

margin: 50px;
}
        /*!
 * Bootstrap v4.6.0 (https://getbootstrap.com/)
 * Copyright 2011-2021 The Bootstrap Authors
 * Copyright 2011-2021 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
 */
    </style>
    <link href="styledashbord.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">


            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">

                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">

                            <div class="col-lg-6 d-none d-lg-block hhhhh">
                            <div class="mr-6" ><img height="350" width="350" src="change_p.svg"></div>
                            </div>
                            <div class="col-lg-6">

                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Vous voulez changer votre m ot de passe  ?</h1>
                                        <p class="mb-4">Nous comprenons, des choses se produisent. Entrez simplement votre nouveau mot de passe et le confirmer ci-dessous

                                    <form class="user" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <div class="form-group">
                                            <input type="password" name="old_password" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Ancien mot de passe ...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Nouveau mot de passe ...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_confirmation" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Confirmer mot de passe ...">
                                        </div>
                                        <input type="submit" value="Réinitialiser mot de passe" class="btn btn-primary btn-user btn-block">

                                    </form>
                                    <hr>
                                    <!-- <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="login.html">Already have an account? Login!</a>
                                    </div> -->
                                    <div class="text-center" style="color: red; font-style: italic;">
                                        <?php
                                        if (!empty($errors)) {
                                            foreach ($errors as $error) {
                                                echo "<p>$error</p>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>



</body>

</html>