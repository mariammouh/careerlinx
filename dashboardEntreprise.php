<!DOCTYPE html>
<?php
session_start();
$id_ese = $_SESSION["id_user"];

$email = $_SESSION["email"];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "careerlinx";
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function checkStatus($variable)
{
    // Convert the variable to lowercase for case-insensitive matching
    $lowercase_variable = strtolower($variable);

    // Check if the variable contains specific words
    if (strpos($lowercase_variable, 'refusée') !== false) {
        return "fas fa-times-circle fa-3x text-danger";
    } elseif (strpos($lowercase_variable, 'accepté') !== false) {
        return "fas fa-check-circle fa-3x text-success";
    } else {
        // Default case if none of the specific words are found
        return "fas fa-bell fa-3x text-white  fa-fw text-primary";
    }
}
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "select * from entreprise where ID_Entreprise ='$id_ese'";
$result = $conn->query($sql);
if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $donnes = $row;
    }
}

$_SESSION["nom"] = $donnes['Nom_Entreprise'];
$sql_noti = "SELECT * FROM notification WHERE id_utilisateur = $id_ese order by date_creation DESC";
$unread_count = 0;
// Execute the query
$result = $conn->query($sql_noti);
$notifications = [];
// Check if there are any results
if ($result->num_rows > 0) {
    // Initialize a counter for unread notifications


    // Loop through each row of the result set
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
        // Check the status of each notification
        if ($row['statut'] === 'non lu') {
            // Increment the unread count if the notification status is 'non lu'
            $unread_count++;
        }
    }
}

function readALL($table)
{
    global $conn;
    global $id_etud;
    $sql_Update_noti = "UPDATE $table SET statut = 'lu' WHERE id_utilisateur =  ";
    if ($conn->query($sql_Update_noti) === FALSE) {
        echo '<script>alert("Erreur lors de l\'insertion des données de l\'étudiant: ' . $conn->error . '");</script>';
    }
}
function getAdminName($id)
{
    global $conn;
    $sql = "SELECT nom FROM admin WHERE id_admin = '$id'";
    $result = $conn->query($sql);
    if ($result !== false && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['nom'];
    }
}
/////
$sql_message = "  SELECT * FROM `consultation` WHERE id_utilisateur = $id_ese ORDER BY `date_reponse` DESC";
$unread_mesages = 0;
// Execute the query
$result = $conn->query($sql_message);
$messages = [];
// Check if there are any results
if ($result !== false)
    if ($result->num_rows > 0) {
        // Initialize a counter for unread notifications
        $unread_mesages = 0;

        // Loop through each row of the result set
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
            // Check the status of each notification
            if ($row['statut'] === 'non lu') {
                // Increment the unread count if the notification status is 'non lu'
                $unread_mesages++;
            }
        }
    }
// Loop through each row of the result set

$pourcentageSucces = 0;
$nombreResultats = 0;


$nombreDiplomes = 12;
$nombreConcours = 14;
$pourcentageSucces = 0;
$nombreResultats = 0;

// Requête SQL pour récupérer le nombre de visites par jour pour l'entreprise X
$sql = "SELECT DATE(Date_Creation) AS Jour, COUNT(*) AS Nombreentreprise FROM entreprise   GROUP BY DATE(Date_Creation)";
$result = $conn->query($sql);

// Création des tableaux pour les labels et les données du graphique
$labels = [];
$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Ajouter le label au format 'Jour'
        $labels[] = $row["Jour"];
        $data[] = $row["Nombreentreprise"];
    }
}


$query = $conn->query("
SELECT Secteur_Activite, COUNT(*) as Nombre_Entreprises FROM entreprise GROUP BY Secteur_Activite
");

$niveaux = [];
$nombre_etudiants = [];

while ($data = $query->fetch_assoc()) {
    $niveaux[] = $data['Secteur_Activite'];
    $nombre_etudiants[] = $data['Nombre_Entreprises'];
}

$sql = "SELECT DATE(Date_Creation) AS Jour, COUNT(*) AS NombreVisites FROM entreprise    GROUP BY DATE(Date_Creation)";
$result = $conn->query($sql);

// Création des tableaux pour les labels et les données du graphique
$labels = [];
$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Ajouter le label au format 'Jour'
        $labels[] = $row["Jour"];
        $data[] = $row["NombreVisites"];
    }
}


?>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CareerLinx</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom styles for this template-->
    <link href="styledashbord.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .sidebar {

            background-color: salmon;
        }

        .cree_btn {
            border: 2px solid #24b4fb;
            background-color: #24b4fb;
            border-radius: 0.9em;
            padding: 0.8em 1.2em 0.8em 1em;
            transition: all ease-in-out 0.2s;
            font-size: 16px;
            width: 100px;
            height: 50px;
        }

        .cree_btn span {
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-weight: 600;
        }

        .cree_btn:hover {
            background-color: #0071e2;
        }

        .Btn {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: 100px;
            height: 40px;
            border: none;
            padding: 0px 20px;
            background-color: rgb(168, 38, 255);
            color: white;
            font-weight: 500;
            cursor: pointer;
            border-radius: 10px;
            box-shadow: 5px 5px 0px rgb(140, 32, 212);
            transition-duration: .3s;
        }

        .svg {
            width: 13px;
            position: absolute;
            right: 0;
            margin-right: 20px;
            fill: white;
            transition-duration: .3s;
        }

        .Btn:hover {
            color: transparent;
        }

        .Btn:hover svg {
            right: 43%;
            margin: 0;
            padding: 0;
            border: none;
            transition-duration: .3s;
        }

        .Btn:active {
            transform: translate(3px, 3px);
            transition-duration: .3s;
            box-shadow: 2px 2px 0px rgb(140, 32, 212);
        }


        .bin-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgb(255, 95, 95);
            cursor: pointer;
            border: 2px solid rgb(255, 201, 201);
            transition-duration: 0.3s;
            position: relative;
            overflow: hidden;
        }

        .bin-bottom {
            width: 15px;
            z-index: 2;
        }

        .bin-top {
            width: 17px;
            transform-origin: right;
            transition-duration: 0.3s;
            z-index: 2;
        }

        .bin-button:hover .bin-top {
            transform: rotate(45deg);
        }

        .bin-button:hover {
            background-color: rgb(255, 0, 0);
        }

        .bin-button:active {
            transform: scale(0.9);
        }

        .garbage {
            position: absolute;
            width: 14px;
            height: auto;
            z-index: 1;
            opacity: 0;
            transition: all 0.3s;
        }

        .bin-button:hover .garbage {
            animation: throw 0.4s linear;
        }

        @keyframes throw {
            from {
                transform: translate(-400%, -700%);
                opacity: 0;
            }

            to {
                transform: translate(0%, 0%);
                opacity: 1;
            }
        }

        .editBtn {
            width: 40px;
            height: 40px;
            border-radius: 20px;
            border: none;
            background-color: rgb(93, 93, 116);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.123);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
            margin-bottom: 5px;
        }

        .editBtn::before {
            content: "";
            width: 200%;
            height: 200%;
            background-color: rgb(102, 102, 141);
            position: absolute;
            z-index: 1;
            transform: scale(0);
            transition: all 0.3s;
            border-radius: 50%;
            filter: blur(10px);
        }

        .editBtn:hover::before {
            transform: scale(1);
        }

        .editBtn:hover {
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.336);
        }

        .editBtn svg {
            height: 17px;
            fill: white;
            z-index: 3;
            transition: all 0.2s;
            transform-origin: bottom;
        }

        .editBtn:hover svg {
            transform: rotate(-15deg) translateX(5px);
        }

        .editBtn::after {
            content: "";
            width: 25px;
            height: 1.5px;
            position: absolute;
            bottom: 19px;
            left: -5px;
            background-color: white;
            border-radius: 2px;
            z-index: 2;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s ease-out;
        }

        .editBtn:hover::after {
            transform: scaleX(1);
            left: 0px;
            transform-origin: right;
        }

        .button {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 9px 12px;
            gap: 8px;
            height: 45px;
            width: 150px;
            border: none;
            background: rgb(74, 180, 50);
            border-radius: 50px;
            cursor: pointer;
            position: relative;
        }

        .lable {
            line-height: 22px;
            font-size: 17px;
            color: #fff;
            margin-left: 20px;
            font-family: sans-serif;
            letter-spacing: 1px;
        }

        .button .span {
            border-radius: 50%;
            background-color: rgb(48, 129, 29);
            padding: 10px;
            position: absolute;
            left: 0;
        }

        .button:hover {
            background: rgb(48, 129, 29);
        }

        .button:hover .svg-icon {
            animation: slope 0.8s linear infinite;
        }

        @keyframes slope {
            0% {}

            50% {
                transform: rotate(15deg);
            }

            100% {}
        }

        .cssbuttons-io-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .2em;
            font-family: inherit;
            font-weight: 600;
            font-size: 16px;
            padding: .5em 1.5em;
            color: white;
            background: linear-gradient(0deg, rgb(0, 120, 255), rgb(100, 200, 255));

            border: none;
            outline: none;
            border-bottom: 3px solid rgb(100, 200, 255);
            box-shadow: 0 .5em .5em -.4em rgb(0, 0, 0, .5);
            letter-spacing: 0.08em;
            border-radius: 20em;
            cursor: pointer;
            transition: .5s;
        }

        .cssbuttons-io-button:hover {
            filter: brightness(1.2);
            color: rgb(0, 0, 0, .5);
        }

        td input {
            width: 80px;
        }

        .container_lancer {
            max-width: 600px;
            margin: auto;
            padding: 20px;

            border-radius: 5px;

        }

        .form-group {
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 10px;

        }

        .formLancer {

            background-color: #0071e2;
            padding: 0%;
        }

        .content-form h2 {
            margin: 50px;
            margin-left: 25%;
        }

        .form-label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            color: inherit;
        }

        .form-checkbox {
            margin: 5px;
            height: 10px;
        }

        .btnsZ {
            display: inline-flex;

        }

        .form-button {
            background-color: sandybrown;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            left: 50%;
            margin-left: 40%;
        }

        .form-button:hover {
            background-color: sienna;
        }

        /* .cssbuttons-io-button:active {
            transition: 0s;
            transform: rotate(-10deg);
        } */
        .container form {
            height: fit-content;
            left: 20%;
            width: 600px;
        }

        .container form input {
            width: fit-content;
            width: auto;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboardEcole.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <!-- <i class="fa-solid fa-graduation-cap"></i> -->
                </div>
                <div class="sidebar-brand-text mx-3"><img class="logo" src="logo 2.jpeg"> <sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="dashboardEcole.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Tableau de bord </span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->


            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span> Paramètres</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Vous cherchez ceci:</h6>
                        <a class="collapse-item" href="forgotmodpass.php"><i class="fa-solid fa-key"></i> Oublier mot de passe </a>
                        <a class="collapse-item" href="changmodpass.php"><i class="fa-solid fa-unlock"></i> Changer mot de passe </a>
                    </div>
                </div>
            </li>



            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <!-- <div class="sidebar-heading">
                Services
            </div> -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-tools"></i>
                    <span> Services</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Notre platforme offre :</h6>
                        <a class="collapse-item" href="offres.php"><i class="fas fa-fw fa-file-alt"></i> Vos offres</a>
                        <a class="collapse-item" href="candidatsE.php"><i class="fas fa-user-graduate"></i> Les candidats inscrits </a>
                        <a class="collapse-item" href="councours.php"><i class="fa fa-handshake"></i> Publier les résultats</a>

                    </div>
                </div>
            </li>
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">

            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">

                    <i class="fas fa-address-book"></i>
                    <span>Informations de contact </span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Contactez-nous:</h6>
                        <a class="collapse-item"><i class="fa fa-envelope"></i> contact@CreerLinx.ma</a>
                        <a class="collapse-item"><i class="fa fa-map"></i> City Dakhla , Agadir</a>
                        <a class="collapse-item"><i class="fa fa-phone"></i> +212 6 20 88 32 14</a>

                    </div>
                </div>
            </li>




            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <ul class="navbar-nav ml-auto">


                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter" id="noti_nbr"><?php echo $unread_count; ?></span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notifications
                                </h6><?php foreach ($notifications as $noti) {
                                            if ($noti['statut'] === 'non lu') {
                                                echo '
                                  <a class="dropdown-item d-flex align-items-center" id="noti_div" onclick="read_noti(\'noti\',\'noti_nbr\')" >
                                    <div class="mr-3">
                                        <div class="icon-circle ">
                                            <i class="' . checkStatus($noti["content"]) . ' text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">' . $noti['date_creation'] . '</div>
                                        <span id="noti" class="font-weight-bold">' . $noti["content"] . '</span>
                                    </div>
                                </a> ';
                                            } else {
                                                echo ' <a class="dropdown-item d-flex align-items-center" href="#">
                                                <div class="mr-3">
                                                    <div class="icon-circle">
                                                        <i class=" ' . checkStatus($noti["content"]) . ' text-white"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="small text-gray-500">' . $noti['date_creation'] . '</div>
                                                    ' . $noti["content"] . '
                                                </div>
                                            </a> ';
                                            }
                                        } ?>
                                <a class="dropdown-item text-center small text-gray-500" href="<?php readALL("notification"); ?>">Fermer</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter" id="mess_nbr"><?php echo $unread_mesages; ?></span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Centre
                                </h6><?php foreach ($messages as $mes) {
                                            if ($mes['statut'] === 'non lu') {
                                                echo '
                                <a class="dropdown-item d-flex align-items-center" href="#" onclick="read_noti(\'mess\',\'mess_nbr\')" >
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold" id="mess">
                                        <div class="text-truncate">' . $mes['reponse'] . '</div>
                                        <div class="small text-gray-500">' . $mes['date_reponse'] . '</div>
                                    </div>
                                </a>';
                                            } else {
                                                echo '
                                                <a class="dropdown-item d-flex align-items-center" href="#">
                                                    <div class="dropdown-list-image mr-3">
                                                        <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                                                        <div class="status-indicator bg-success"></div>
                                                    </div>
                                                    <div  >
                                                        <div class="text-truncate">' . $mes['reponse'] . '</div>
                                                        <div class="small text-gray-500">' . getAdminName($mes['id_admin']) . " " . $mes['date_reponse'] . '</div>
                                                    </div>
                                                </a>';
                                            }
                                        } ?> <a class="dropdown-item text-center small text-gray-500" href="<?php readALL("consultation"); ?>">Fermer</a>


                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $donnes["Nom_Entreprise"] ?></span>
                                <img class="img-profile rounded-circle" src="<?php echo $donnes["Logo"] ?>">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" onclick="openForm('profile', event)">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="home.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Deconnexion
                                </a>
                            </div>


                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tableau de bord</h1>
                        <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="#" onclick="openForm('contactForm', event)"><i class="fas fa-question-circle fa-sm text-white-50"></i> Assistance disponible</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Nombre d'offres de votre établissement:</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $nombreDiplomes; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Nombre de votre concours/entretiens que nous gérons:</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $nombreConcours; ?> </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Taux de réussite
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $pourcentageSucces; ?></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $pourcentageSucces; ?>%" aria-valuenow="<?php echo $pourcentageSucces; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Nombre total de candidatures soumises.</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $nombreResultats; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->



                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-8 col-lg-2">

                            <!-- Area Chart -->
                            <div class="card shadow mb-4">
                                <div width="70" class="card-header py-3">

                                    <h6 class="m-0 font-weight-bold text-primary">Nombre d'entreprises créées chaque année</h6>
                                </div>
                                <div class="card-body">

                                    <body>
                                        <div style="width: 800px; height: 400px;">
                                            <canvas id="myChart" width="600" height="300"></canvas>
                                        </div>

                                        <script>
                                            const labels = <?php echo json_encode($labels);  ?>;
                                            const data = {
                                                labels: labels,
                                                datasets: [{
                                                    label: 'Nombre des entreprises',
                                                    data: <?php echo json_encode($data); ?>,
                                                    fill: false,
                                                    borderColor: 'rgb(75, 192, 192)',
                                                    tension: 0.1
                                                }]
                                            };

                                            const config = {
                                                type: 'line',
                                                data: data,
                                            };
                                            var myChart = new Chart(
                                                document.getElementById('myChart'),
                                                config
                                            );
                                        </script>

                                    </body>


                                </div>
                            </div>



                        </div>

                        <!-- Donut Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">la répartition des secteurs d'activité des entreprises inscrit</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body ml-3">


                                    <divwidth="300" height="300" ><canvas id="pieChart" width="250" height="250"></canvas></divwidth=>

                                    <script>
                                        var ctx = document.getElementById('pieChart').getContext('2d');
                                        var myChart = new Chart(ctx, {
                                            type: 'pie',
                                            data: {
                                                labels: <?php echo json_encode($niveaux); ?>,
                                                datasets: [{
                                                    label: 'Secteur_Activite',
                                                    data: <?php echo json_encode($nombre_etudiants); ?>,
                                                    backgroundColor: [
                                                        'rgba(255, 99, 132, 0.2)',
                                                        'rgba(54, 162, 235, 0.2)',
                                                        'rgba(255, 206, 86, 0.2)',
                                                        'rgba(75, 192, 192, 0.2)',
                                                        'rgba(153, 102, 255, 0.2)',
                                                        'rgba(255, 159, 64, 0.2)'
                                                    ],
                                                    borderColor: [
                                                        'rgba(255, 99, 132, 1)',
                                                        'rgba(54, 162, 235, 1)',
                                                        'rgba(255, 206, 86, 1)',
                                                        'rgba(75, 192, 192, 1)',
                                                        'rgba(153, 102, 255, 1)',
                                                        'rgba(255, 159, 64, 1)'
                                                    ],
                                                    borderWidth: 1
                                                }]
                                            },
                                            options: {
                                                responsive: false,
                                                maintainAspectRatio: false
                                            }
                                        });
                                    </script>

                                </div>
                                <hr>


                            </div>
                        </div>
                    </div>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; CreerLinx 2024</span>
                    </div>
                </div>
            </footer>


        </div>


    </div>


    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Prêt à partir ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Sélectionnez "Déconnexion" ci-dessous si vous êtes prêt à mettre fin à votre session actuelle.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-primary" href="home.php">Déconnexion</a>
                </div>
            </div>
        </div>
    </div>
    <div id="overlay" class="overlay" onclick="closeForms()"></div>

    <div class="contactForm form-popup" id="contactForm">
        <span class="close" onclick="closeForm('contactForm')">&times;</span>
        <div class="content-form">
            <div class="image-box">
                <img src="contact.jpg" alt="" />
            </div>
            <form action="MessageForm.php" method="post" enctype="multipart/form-data">
                <div class="topic">Envoyez nous votre message </div>
                <div class="input-box" style="display: none;">
                    <input type="text" name="nom" value="<?php echo $donnes['nom']; ?>" id="nom" />
                    <label>Entrez votre nom</label>
                </div>

                <div class="input-box" style="display: none;">
                    <input type="text" id="email" value="<?php echo $email; ?>" name="email" />
                    <label>Entrez votre email</label>
                </div>
                <div class=" message-box">
                    <textarea id="message" name="message"></textarea>
                    <label>Entrez votre message</label>
                </div>
                <div style="margin: 10px;">
                    <label for="typeMessage">S'agit-il d'un problème concernant notre site ?</label>
                    <input type="checkbox" id="typeMessage" name="typeMessage" value="probleme" />
                </div>

                <div class="input-box">
                    <input type="submit" name="envoyerMessage" id="envoyerMessage" value="Envoyez votre message" />
                </div>
            </form>
        </div>
    </div>


    <div id="profile" class="form-popup">

        <span class="close" onclick="closeForm('profile')">&times;</span>

        <div class="container">
            <form action="profile.php" method="post" enctype="multipart/form-data">
                <div class="">
                    <div class="card">
                        <img src="<?php echo $donnes['Logo'] ?>" alt="Logo" class="image_etu" width="140" height="140">
                        <div class="pic">
                            <label for="pic" class="label">Changer le logo</label>
                            <label class="custum-file-upload" for="file">
                                <div class="icon">
                                    <svg class="w-[35px] h-[35px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2M8 9l4-5 4 5m1 8h.01" />
                                    </svg>
                                </div>
                                <input type="file" id="file" name="logo">
                            </label>
                        </div>
                        <h4><?php echo $donnes['Nom_Entreprise'] ?></h4>
                    </div>
                    <div class="">
                        <div class="card">
                            <table>
                                <tr>
                                    <td>
                                        <h6 class="mb-0">Email</h6>
                                        <input type="email" name="email" class="form-control" value="<?php echo $email ?>">
                                    </td>
                                    <td>
                                        <h6 class="">Téléphone</h6>
                                        <input type="tel" name="tel" class="form-control" value="<?php echo $donnes['Contact'] ?>">
                                    </td>
                                </tr>
                                <tr>

                                    <td>
                                        <h6 class="">Description</h6>
                                        <input type="text" class="form-control" name="domaine_etude" value="<?php echo sanitizeInput($donnes['Description']); ?>">
                                    </td>
                                    <td>
                                        <h6 class="">Web site:</h6>
                                        <input type="text" class="form-control" name="note" value="<?php echo $donnes['website'] ?>">
                                    </td>
                                </tr>
                                <tr>

                                    <td>
                                        <h6 class="">Localisation :</h6>
                                        <input type="text" class="form-control" name="note" value="<?php echo $donnes['Localisation'] ?>">
                                    </td>

                                </tr>
                            </table>
                            <div class="err"></div>
                            <button class="save">
                                <input type="submit" name="Sauvegarder" class="btn btn-primary px-4 " value="Sauvegarder">
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>




    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js">
        (function($) {
            "use strict"; // Start of use strict

            // Toggle the side navigation
            $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
                $("body").toggleClass("sidebar-toggled");
                $(".sidebar").toggleClass("toggled");
                if ($(".sidebar").hasClass("toggled")) {
                    $('.sidebar .collapse').collapse('hide');
                };
            });

            // Close any open menu accordions when window is resized below 768px
            $(window).resize(function() {
                if ($(window).width() < 768) {
                    $('.sidebar .collapse').collapse('hide');
                };

                // Toggle the side navigation when window is resized below 480px
                if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
                    $("body").addClass("sidebar-toggled");
                    $(".sidebar").addClass("toggled");
                    $('.sidebar .collapse').collapse('hide');
                };
            });

            // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
            $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
                if ($(window).width() > 768) {
                    var e0 = e.originalEvent,
                        delta = e0.wheelDelta || -e0.detail;
                    this.scrollTop += (delta < 0 ? 1 : -1) * 30;
                    e.preventDefault();
                }
            });

            // Scroll to top button appear
            $(document).on('scroll', function() {
                var scrollDistance = $(this).scrollTop();
                if (scrollDistance > 100) {
                    $('.scroll-to-top').fadeIn();
                } else {
                    $('.scroll-to-top').fadeOut();
                }
            });

            // Smooth scrolling using jQuery easing
            $(document).on('click', 'a.scroll-to-top', function(e) {
                var $anchor = $(this);
                $('html, body').stop().animate({
                    scrollTop: ($($anchor.attr('href')).offset().top)
                }, 1000, 'easeInOutExpo');
                e.preventDefault();
            });

        })(jQuery); // End of use strict
    </script>
    <script>
        function showInput() {
            var selectElement = document.getElementById("type");
            var selectedValue = selectElement.value;
            var inputContainer = document.getElementById("inputContainer");

            if (selectedValue === "interviewOnlineGroup") {
                inputContainer.style.display = "block";
            } else {
                inputContainer.style.display = "none";
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Add event listener to the "Add Row" button
            document.getElementById("addRowBtn").addEventListener("click", function(event) {
                event.preventDefault(); // Prevent the default form submission

                console.log("Add Row button clicked");

                // Clone the template row
                var newRow = document.getElementById("newRowTemplate").cloneNode(true);
                newRow.removeAttribute("id"); // Remove the ID to avoid duplication
                newRow.style.display = ""; // Make the cloned row visible

                // Append the new row to the table body
                document.querySelector("#dataTable tbody").appendChild(newRow);
            });
        });
        // function deleteRow(this) {
        //           var row = button.parentNode.parentNode;
        //           row.parentNode.removeChild(row);
        //       }



        function read_noti(id, id_nbr) {
            // document.getElementById('noti_div').addEventListener('click', function() {
            // document.getElementById('noti').classList.add('.font-weight-normal');
            var element = document.getElementById(id);
            element.classList.remove("font-weight-bold");
            var elementToModify = document.getElementById(id_nbr);
            elementToModify.innerHTML = "0";
            // });
        }

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
    </script>
    <script>
        /*!
         * Start Bootstrap - SB Admin 2 v4.1.3 (https://startbootstrap.com/theme/sb-admin-2)
         * Copyright 2013-2021 Start Bootstrap
         * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin-2/blob/master/LICENSE)
         */

        ! function(l) {
            "use strict";
            l("#sidebarToggle, #sidebarToggleTop").
            on("click", function(e) {
                l("body").toggleClass("sidebar-toggled"), l(".sidebar").
                toggleClass("toggled"), l(".sidebar").hasClass("toggled") && l(".sidebar .collapse")
                    .collapse("hide")
            }), l(window).resize(function() {
                l(window).width() < 768 && l(".sidebar .collapse")
                    .collapse("hide"), l(window).width() < 480 && !l(".sidebar").hasClass("toggled") && (l("body")
                        .addClass("sidebar-toggled"), l(".sidebar").addClass("toggled"), l(".sidebar .collapse").collapse("hide"))
            }), l("body.fixed-nav .sidebar").on("mousewheel DOMMouseScroll wheel", function(e) {
                var o;
                768 < l(window).width() && (o = (o = e.originalEvent).wheelDelta || -o.detail, this.scrollTop += 30 * (o < 0 ? 1 : -1), e.preventDefault())
            }), l(document).on("scroll", function() {
                100 < l(this).scrollTop() ? l(".scroll-to-top").fadeIn() : l(".scroll-to-top").fadeOut()
            }), l(document).on("click", "a.scroll-to-top", function(e) {
                var o = l(this);
                l("html, body").stop().animate({
                        scrollTop: l(o.attr("href")).offset().top
                    }, 1e3, "easeInOutExpo"),
                    e.preventDefault()
            })
        }(jQuery);
    </script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/chart-bar-demo.js"></script>
    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
</body>

</html>