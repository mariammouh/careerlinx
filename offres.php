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
    global $id_ecole;
    $sql_Update_noti = "UPDATE $table SET statut = 'lu' WHERE id_utilisateur = $id_ecole  ";
    if ($conn->query($sql_Update_noti) === FALSE) {
        echo '<script>alert("Erreur lors de l\'insertion des données : ' . $conn->error . '");</script>';
    }
}

// Initialize a counter for unread notifications
$unread_mesages = 0;

// Loop through each row of the result set

$pourcentageSucces = 0;
$nombreResultats = 0;

/////////// HA LM39OL
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add new row or edit existing row
    $titreOffre = $_POST['Titre_Offre'];
    $descriptionOffre = $_POST['Description_Offre'];
    $typeOffre = $_POST['Type_Offre'];
    $duree = $_POST['duree'];
    $dateCreation = date("Y-m-d"); // Assuming you want the current date
    $situation = $_POST['situation'];
    
    // Check if ID_Offre is set for editing
    if (isset($_POST['enregistre'])) {
        $idOffre = $_POST['enregistre'];
    
        // Perform update operation
        $sql = "UPDATE emploi_stage SET Titre_Offre='$titreOffre', Description_Offre='$descriptionOffre', Type_Offre='$typeOffre', duree='$duree', Date_Creation='$dateCreation', situation='$situation' WHERE ID_Offre = $idOffre";
    
        if ($conn->query($sql) === TRUE) {
        } else {
            echo '<script>alert("Erreur lors de la mise à jour des données : ' . $conn->error . '");</script>';
        }
    }
    if (isset($_POST['enregistrer'])) {
        $titreOffre = $_POST['Titre_Offre'];
        $descriptionOffre = str_replace("'", "\'", $_POST['Description_Offre']);
        $typeOffre = $_POST['Type_Offre'];
        $duree = $_POST['duree'];
        $dateCreation = date("Y-m-d"); // Assuming you want the current date
        $situation = $_POST['situation'];
        
        $sql = "INSERT INTO emploi_stage (ID_Entreprise, Titre_Offre, Description_Offre, Type_Offre, duree, Date_Creation, situation) VALUES ('$id_ese', '$titreOffre', '$descriptionOffre', '$typeOffre', '$duree', '$dateCreation', '$situation')";
        if ($conn->query($sql) === TRUE) {
            ///im the best B) maaaaaatzaaaaaaapiiiiiiiiiixxxxxxxxxxxxxx 
        } else {
            echo '<script>alert("Erreur lors de l\'insertion  des données : ' . $conn->error . '");</script>';
        }
    }


    // Delete existing row
    if (isset($_POST["Effacer"])) {

        $id_diplome = $_POST["Effacer"];
        $sql_delete_diplome = "Delete from emploi_stage  WHERE ID_Offre = $id_diplome ";
        if ($conn->query($sql_delete_diplome) === FALSE) {
            echo '<script>alert("Erreur lors de l\'effacement des données de  diplome: ' . $conn->error . '");</script>';
        }
    }


    if (isset($_POST["LancerAvecCon"])) {


        $_SESSION["id_dip"] =  $_POST["LancerAvecCon"];
        echo '<script>alert("Erreur ' . $_SESSION["id_dip"] . '  ");</script>';
    }

    if (isset($_POST["LancerSansCon"])) {

        $id_diplome = $_POST["LancerSansCon"];
        $_SESSION["id_dip"] = $id_diplome;
        echo '<script>alert("Erreur ' . $_SESSION["id_dip"] . '  ");</script>';
    }
}


$diplomes = [];
$sql = "SELECT *  FROM emploi_stage WHERE ID_Entreprise = $id_ese ";
$result = $conn->query($sql);
$count = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $diplomes[] = $row;
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

    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="styledashbord.css" rel="stylesheet">
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
        td input{
            width: 150px;
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
            <!-- <div class="sidebar-heading">
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
               
            </div> -->

            <!-- Nav Item - Pages Collapse Menu -->

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
            <!-- <li class="nav-item">
                <a class="nav-link" href="changmodpass.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span></span></a>
            </li> -->

            <!-- <li class="nav-item">
                <a class="nav-link" href="forgotmodpass.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span></span></a>
            </li> -->




            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <!-- <div class="sidebar-heading">
                Services
            </div> -->
            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fa-solid fa-user-gear"></i>
                    <span> Services</span>
                </a>
                <div id="collapseUtilities" class="collapse show" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Notre platforme offre :</h6>
                        <a class="collapse-item active" href="offres.php"><i class="fas fa-fw fa-file-alt"></i> Vos offres</a>
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

                    <i class="fa-solid fa-comment"></i>
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

            <!-- Nav Item - Pages Collapse Menu -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="ecoles.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Ecoles</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="entreprise.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Entreprise</span></a>
            </li> -->

            <!-- <li class="nav-item">
                <a class="nav-link" href="blannk.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Ancienne concours</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="try.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>PFQ Entretiens</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="blnk.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Création CV</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="try.php">
                    <i class="fas fa-fw fa-notebook"></i>
                    <span>Mes notes</span></a>
            </li> -->


            <!-- <li class="nav-item">
                <a class="nav-link" href="try.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Deconnexion </span></a>
            </li> -->




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

                    <!-- Topbar Search -->
                    <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="get" action="search.php">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" name="query" placeholder="Rechercher..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" onclick="window.location.href = 'search.php';">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <!-- <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                         
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li> -->

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
                                        } ?> <a class="dropdown-item text-center small text-gray-500" href="<?php readALL("notification"); ?>">Fermer</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                            <a class="nav-link dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $donnes["Nom_Entreprise"] ?></span>
                                <img class="img-profile rounded-circle" src="<?php echo $donnes["Logo"] ?>">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" onclick="openForm('profile', event)">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <!-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="home.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Deconnexion
                                </a>
                            </div>

                            <!-- Dropdown - User Information -->

                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800"></h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Vos offres : </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form method="post" action="offres.php" id="myForm">

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Titre de l'offre</th>
                                                <th>Description de l'offre</th>
                                                <th>Type de l'offre</th>
                                                <th>Durée</th>
                                                <th>Date de création</th>
                                              
                                                <th>Lancer inscription </th>

                                                <th>Action </th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Titre de l'offre</th>
                                                <th>Description de l'offre</th>
                                                <th>Type de l'offre</th>
                                                <th>Durée</th>
                                                <th>Date de création</th>
                                       
                                                <th>Lancer inscription </th>
                                                <th>Action </th>
                                            </tr>
                                        </tfoot>

                                        <tbody>
                                            <!-- Your PHP loop to populate table rows -->
                                            <?php foreach ($diplomes as $diplome) {
                                                $id = $diplome['ID_Offre']; ?>
                                                <tr>

                                                    <td><input name="Titre_Offre[<?php echo $id; ?>]" value="<?php echo $diplome['Titre_Offre']; ?>"></td>
                                                    <td><input name="Description_Offre[<?php echo $id; ?>]" value="<?php echo $diplome['Description_Offre']; ?>"></td>
                                                    <td><input name="Type_Offre[<?php echo $id; ?>]" value="<?php echo $diplome['Type_Offre']; ?>"></td>
                                                    <td><input name="duree[<?php echo $id; ?>]" value="<?php echo $diplome['duree']; ?>"></td>
                                                    <td><input name="Date_Creation[<?php echo $id; ?>]" value="<?php echo $diplome['Date_Creation']; ?>"></td>

                                                    <td><button class="cree_btn" type="submit" onclick="openForm('LancerAvecCon', event)" name="LancerAvecCon" id="yourButtonId" value="<?php echo   (int)$id; ?>"> <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                                                    <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path>
                                                                </svg> Lancer
                                                            </span></button></td>

                                                    <td>
                                                        <button class="editBtn" type="submit" name="enregistre" value="<?php echo $diplome['ID_Offre']; ?>"> <svg height="1em" viewBox="0 0 512 512">
                                                                <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
                                                            </svg>
                                                        </button>
                                                        <!-- Uncomment if you want to add delete functionality -->
                                                        <button class="bin-button" type="submit" name="Effacer" value="<?php echo $diplome['ID_Offre']; ?>" onclick="deleteRow(this)"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 39 7" class="bin-top">
                                                                <line stroke-width="4" stroke="white" y2="5" x2="39" y1="5"></line>
                                                                <line stroke-width="3" stroke="white" y2="1.5" x2="26.0357" y1="1.5" x1="12"></line>
                                                            </svg>
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 33 39" class="bin-bottom">
                                                                <mask fill="white" id="path-1-inside-1_8_19">
                                                                    <path d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z"></path>
                                                                </mask>
                                                                <path mask="url(#path-1-inside-1_8_19)" fill="white" d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z"></path>
                                                                <path stroke-width="4" stroke="white" d="M12 6L12 29"></path>
                                                                <path stroke-width="4" stroke="white" d="M21 6V29"></path>
                                                            </svg>
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 89 80" class="garbage">
                                                                <path fill="white" d="M20.5 10.5L37.5 15.5L42.5 11.5L51.5 12.5L68.75 0L72 11.5L79.5 12.5H88.5L87 22L68.75 31.5L75.5066 25L86 26L87 35.5L77.5 48L70.5 49.5L80 50L77.5 71.5L63.5 58.5L53.5 68.5L65.5 70.5L45.5 73L35.5 79.5L28 67L16 63L12 51.5L0 48L16 25L22.5 17L20.5 10.5Z"></path>
                                                            </svg></button>
                                                        <!-- <input type="hidden" name="ID_dip" value="<?php echo $diplome['ID_Diplome']; ?>"> -->
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <tr id="newRowTemplate" style="display: none;">
                                                <td><input name="Titre_Offre" value="Titre de l'Offre"></td>
                                                <td><input name="Description_Offre" value="Description de l'Offre"></td>
                                                <td><input name="Type_Offre" value="Type de l'Offre"></td>
                                                <td><input name="duree" value="Durée"></td>
                                                <td><input name="Date_Creation" value="Date de Création"></td>
                                                <td><input name="situation" value="Situation"></td>
                                                <td><button class="cree_btn" type="submit" name="LancerAvecCon" value="<?php echo $diplome['ID_Offre']; ?>"> <span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                                                <path fill="none" d="M0 0h24v24H0z"></path>
                                                                <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path>
                                                            </svg> Lancer
                                                        </span></button></td>

                                                <td>
                                                    <button class="editBtn" type="submit" name="enregistrer" value="enregistrer"> <svg height="1em" viewBox="0 0 512 512">
                                                            <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
                                                        </svg>
                                                    </button>
                                                    <!-- Uncomment if you want to add delete functionality -->
                                                    <button class="bin-button" onclick="deleteRow(this)"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 39 7" class="bin-top">
                                                            <line stroke-width="4" stroke="white" y2="5" x2="39" y1="5"></line>
                                                            <line stroke-width="3" stroke="white" y2="1.5" x2="26.0357" y1="1.5" x1="12"></line>
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 33 39" class="bin-bottom">
                                                            <mask fill="white" id="path-1-inside-1_8_19">
                                                                <path d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z"></path>
                                                            </mask>
                                                            <path mask="url(#path-1-inside-1_8_19)" fill="white" d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z"></path>
                                                            <path stroke-width="4" stroke="white" d="M12 6L12 29"></path>
                                                            <path stroke-width="4" stroke="white" d="M21 6V29"></path>
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 89 80" class="garbage">
                                                            <path fill="white" d="M20.5 10.5L37.5 15.5L42.5 11.5L51.5 12.5L68.75 0L72 11.5L79.5 12.5H88.5L87 22L68.75 31.5L75.5066 25L86 26L87 35.5L77.5 48L70.5 49.5L80 50L77.5 71.5L63.5 58.5L53.5 68.5L65.5 70.5L45.5 73L35.5 79.5L28 67L16 63L12 51.5L0 48L16 25L22.5 17L20.5 10.5Z"></path>
                                                        </svg></button>
                                                    <!-- <input type="hidden" name="ID_dip" value="<?php echo $diplome['ID_Diplome']; ?>"> -->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="edit-buttons">
                                        <button id="addRowBtn" class="cssbuttons-io-button">
                                            <svg height="25" width="25" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor"></path>
                                            </svg>
                                            <span>Ajouter</span>
                                        </button>
                                    </div>
                                </form>


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
    <div class="LancerSansCon form-popup" id="LancerAvecCon">
        <span class="close" onclick="closeForm('LancerAvecCon')">&times;</span>
        <div class="content-form">

            <h2>Formulaire de L'inscription</h2>
            <form action="traitement.php" method="POST" class="container_lancer">
                <!-- <input type="hidden" name="ID_dip" value="<?php echo $_POST["LancerAvecCon"]; ?>"> -->
                <div class="form-group">
                    <label class="form-label" for="titre">Titre du Concours/Entretien:</label>
                    <input class="form-input" type="text" id="titre" name="titre" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="location">Lieu du Concours/Entretien:</label>
                    <input class="form-input" type="text" id="location" name="location" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="date">Date du Concours/Entretien:</label>
                    <input class="form-input" type="date" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="heure">Heure du Concours/Entretien:</label>
                    <input class="form-input" type="time" id="heure" name="heure" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="duree">Durée:</label>
                    <input class="form-input" type="text" id="duree" name="duree">
                </div>
                <div class="form-group">
                    <label class="form-label" for="date_limite">Date Limite d'Inscription:</label>
                    <input class="form-input" type="date" id="date_limite" name="date_limite" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="seuil_selection">Seuil de Sélection:</label>
                    <input class="form-input" type="text" id="seuil_selection" name="seuil_selection">
                </div>
                <div class="form-group">
                    <label class="form-label" for="type">Type de Concours:</label>
                    <select class="form-input" id="type" name="type" onchange="showInput()" required>
                        <option value="">Choisir le type...</option>
                        <option value="exam">Examen</option>
                        <option value="interview">Entretien</option>
                        <option value="interviewOnlineOne">Entretien à distance individual</option>
                        <option value="interviewOnlineGroup">Entretien à distance en group</option>
                    </select>
                </div>
                <div id="inputContainer" style="display: none;" class="form-group">
                    <label for="textInput" class="form-label">Entrez l'URL de l'entretien en group sur Zoom, Teams, Google Meet ou d'autres plateformes:</label>
                    <input type="url" id="textInput" class="form-input" name="url" >
                </div>
                <label class="form-label">Fichiers Requis:</label><br>

                <div class="btnsZ">
                    <input class="form-checkbox" type="checkbox" id="note" name="files[]" value="réveil de note">
                    <label class="" for="note">Réveil de Note</label>
                    <input class="form-checkbox" type="checkbox" id="cv" name="files[]" value="CV">
                    <label class="" for="cv">CV</label>
                    <input class="form-checkbox" type="checkbox" id="bac" name="files[]" value="bacalauréat">
                    <label class="" for="bac">Baccalauréat</label>
                    <input class="form-checkbox" type="checkbox" id="diplome" name="files[]" value="diplôme">
                    <label class="" for="diplome">Diplôme</label>
                    <input class="form-checkbox" type="checkbox" id="carte_identite" name="files[]" value="copie de la carte nationale d'identité">
                    <label class="" for="carte_identite">Copie de la Carte Nationale d'Identité</label><br>
                </div>
                <button class="form-button" name="lanceravec" type="submit">Enregistrer</button>
            </form>
        </div>


    </div>


    <div class="LancerSansCon form-popup" id="LancerSansCon">
        <span class="close" onclick="closeForm('LancerSansCon')">&times;</span>
        <div class="content-form">

            <h2>Formulaire de L'inscription</h2>
            <form action="traitementSans.php" method="POST" class="container_lancer ">

                <div class="form-group">
                    <label class="form-label" for="date_limite">Date Limite d'Inscription:</label>
                    <input class="form-input" type="date" id="date_limite" name="date_limite" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="seuil_selection">Seuil de Sélection:</label>
                    <input class="form-input" type="text" id="seuil_selection" name="seuil_selection">
                </div>

                <label class="form-label">Fichiers Requis:</label><br>

                <div class="btnsZ">
                    <input class="form-checkbox" type="checkbox" id="note" name="files[]" value="réveil de note">
                    <label class="" for="note">Réveil de Note</label>
                    <input class="form-checkbox" type="checkbox" id="cv" name="files[]" value="CV">
                    <label class="" for="cv">CV</label>
                </div>
                <div class="btnsZ">
                    <input class="form-checkbox" type="checkbox" id="bac" name="files[]" value="bacalauréat">
                    <label class="" for="bac">Baccalauréat</label>
                    <input class="form-checkbox" type="checkbox" id="diplome" name="files[]" value="diplôme">
                    <label class="" for="diplome">Diplôme</label>
                </div>
                <div class="btnsZ">
                    <input class="form-checkbox" type="checkbox" id="carte_identite" name="files[]" value="copie de la carte nationale d'identité">
                    <label class="" for="carte_identite">Copie de la Carte Nationale d'Identité</label><br>
                </div>
                <button class="form-button" name="lanceravec" type="submit">Enregistrer</button>
            </form>
        </div>


    </div>


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
    </div><!--
							<hr class="my-4">
							<ul class="list-group list-group-flush">
								<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
									<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe me-2 icon-inline"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>Website</h6>
									<span class="text-secondary">https://bootdey.com</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
									<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github me-2 icon-inline"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>Github</h6>
									<span class="text-secondary">bootdey</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
									<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter me-2 icon-inline text-info"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>Twitter</h6>
									<span class="text-secondary">@bootdey</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
									<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram me-2 icon-inline text-danger"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>Instagram</h6>
									<span class="text-secondary">bootdey</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
									<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook me-2 icon-inline text-primary"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>Facebook</h6>
									<span class="text-secondary">bootdey</span>
								</li>
							</ul>--><!-- <p class="text-secondary mb-1">Full Stack Developer</p>
									<p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p>
									 -->
    <div id="profile" class="form-popup">

        <span class="close" onclick="closeForm('profile')">&times;</span>

        <div class="container">
            <form action="profile.php" method="post" enctype="multipart/form-data">
                <div class="">
                    <div class="card">

                        <img src="<?php echo $donnes['image'] ?>" alt="Admin" class="image_etu" width="140" height="140">
                        <!-- <button class="btn btn-outline-primary imjU" name="image" onclick="">Changer l'image</button> -->
                        <div class="pic"> <label for="pic" class="label">Changer l'image</label><label class="custum-file-upload" for="file">
                                <div class="icon">
                                    <svg class="w-[35px] h-[35px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2M8 9l4-5 4 5m1 8h.01" />
                                    </svg>
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4M17 8l-5-5-5 5M12 4.2v10.3"/></svg> -->
                                </div>
                                <input type="file" id="file" name="image">
                            </label></div>
                        <h4><?php echo $donnes['nom'] ?></h4>

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

                                        <input type="tel" name="tel" class="form-control" value="<?php echo $donnes['num_telephone'] ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <h6 class="">Address</h6>

                                        <textarea class="form-control" name="adresse" height="20" rows="1"><?php echo $donnes['adresse']; ?></textarea>
                                    </td>
                                    <td>
                                        <h6 class="">Domaine d'étude</h6>

                                        <input type="text" class="form-control" name="domaine_etude" value=" <?php echo sanitizeInput($donnes['domaine_etude']); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6 class="">Niveau academique</h6>

                                        <input type="text" class="form-control" name="niveau_academique" value="<?php echo $donnes['niveau_academique'] ?>">
                                    </td>
                                    <td>
                                        <h6 class="">Note</h6>

                                        <input type="text" class="form-control" name="note" value="<?php echo $donnes['note'] ?>">
                                    </td>
                                </tr>
                            </table>

                            <div class="err"></div>
                            <button class="save">
                                <input type="submit" name="Sauvegarder" class="btn btn-primary px-4 " value="Sauvegarder">
                            </button>



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