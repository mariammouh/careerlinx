<!DOCTYPE html>
<?php
session_start();
$id_admin = $_SESSION['id_admin'];
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

$sql = "select * from admin  where id_admin ='$id_admin'";
$result = $conn->query($sql);
if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $donnes = $row;
    }
}

$_SESSION["nom"] = $donnes['nom'];
// $sql_noti = "SELECT * FROM notification WHERE id_utilisateur = $id_etud order by date_creation DESC";

// Execute the query
// $result = $conn->query($sql_noti);
$notifications = [];
// // Check if there are any results
// if ($result->num_rows > 0) {
//     // Initialize a counter for unread notifications
//     $unread_count = 0;

//     // Loop through each row of the result set
//     while ($row = $result->fetch_assoc()) {
//         $notifications[] = $row;
//         // Check the status of each notification
//         if ($row['statut'] === 'non lu') {
//             // Increment the unread count if the notification status is 'non lu'
//             $unread_count++;
//         }
//     }
// }
function readALL($table)
{
    global $conn;
    global $id_etud;
    $sql_Update_noti = "UPDATE $table SET statut = 'lu' WHERE id_utilisateur = $id_etud ";
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
$sql_message = "  SELECT * FROM `consultation` WHERE id_admin = $id_admin ORDER BY `date_reponse` DESC";

// Execute the query
$result = $conn->query($sql_message);
$messages = [];
// Check if there are any results
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
function getNombreUsers( $conn) {
    $sql = "SELECT COUNT(*) AS count  FROM resultat ";
    $result = $conn->query($sql);
    $count = 0;
    if($result!==false)
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id_concours = $row['id_concours'];
            $sqlDiplome = "SELECT COUNT(*) AS count FROM diplomes WHERE id_concours = $id_concours ";
            $resultDiplome = $conn->query($sqlDiplome);
            if ($resultDiplome->num_rows > 0) {
                $rowDiplome = $resultDiplome->fetch_assoc();
                $count += $rowDiplome['count'];
            }
        }
    }
    return $count;
}

// Fonction pour récupérer le nombre de stages acceptés pour un étudiant
function getNombreStagesAcceptes($id_etudiant, $conn) {
    $sql = "SELECT COUNT(*) AS count ,id_concours FROM resultat WHERE id_etud = $id_etudiant AND resultat = 'accepte' group by id_etud";
    $result = $conn->query($sql);
    $count = 0;
    if($result!==false)
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id_concours = $row['id_concours'];
            $sqlStage = "SELECT COUNT(*) AS count FROM emploi_stage WHERE id_concours = $id_concours ";
            $resultStage = $conn->query($sqlStage);
            if ($resultStage->num_rows > 0) {
                $rowStage = $resultStage->fetch_assoc();
                $count += $rowStage['count'];
            }
        }
    }
    return $count;
}
function NombreUsers( $conn) {
    $sql = "SELECT COUNT(*) AS count FROM utilisateur ";
    $result = $conn->query($sql);
    $count = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    }
    return $count;
}
// Fonction pour calculer le pourcentage de succès global
function calculerPourcentageSucces($id_etudiant, $conn) {
    $nombreDiplomesAcceptes = getNombreDiplomesAcceptes($id_etudiant, $conn);
    $nombreStagesAcceptes = getNombreStagesAcceptes($id_etudiant, $conn);
    $total = $nombreDiplomesAcceptes + $nombreStagesAcceptes;
    $nombreResultats=nombreResultats($id_etudiant, $conn);
    if ($total > 0) {
        $pourcentage = ($total / $nombreResultats) * 100;
        return $pourcentage;
    } else {
        return 0;
    }
}
function nombreEtud( $conn) {
    $sql = "SELECT COUNT(*) AS count FROM utilisateur where utilisateur_type='étudiant' ";
    $result = $conn->query($sql);
    $count = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    }
    return $count;
}
function nombreEcole( $conn) {
    $sql = "SELECT COUNT(*) AS count FROM utilisateur where utilisateur_type='école' ";
    $result = $conn->query($sql);
    $count = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    }
    return $count;
}
function nombreEse( $conn) {
    $sql = "SELECT COUNT(*) AS count FROM utilisateur where utilisateur_type='entreprise' ";
    $result = $conn->query($sql);
    $count = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    }
    return $count;
}
$nombreDiplomesAcceptes = 0;
$nombreStagesAcceptes = 0;
$nombreResultats=   0;
// Appel de la fonction pour obtenir le pourcentage de succès global
$pourcentageSucces = 0;
$NombreUsers=NombreUsers( $conn) ;
if(isset($_GET["reponse"])){
$reponse=$_GET['reponse'];

$id_consultation=$_GET["id"];
$sql = "UPDATE consultation set id_admin='$id_admin' , 
reponse='$reponse' ,date_reponse='now()',statut='non lu' where id_consultation= '$id_consultation'
";
if ($conn->query($sql) === TRUE) {
} else {
    echo '<script>alert("CareerLinx says : Désolé, votre message n`a pas été envoyé avec succès. Pouvez-vous le renvoyer?'.$conn->error.'");</script>';
}



}
$query = $conn->query("
    SELECT Nom_Ecole AS ecole, nbr_étud AS nombre_etudiants
    FROM écoles_universités
");

$ecoles = [];
$nombre_etudiants = [];

while ($data = $query->fetch_assoc()) {
    $ecoles[] = $data['ecole'];
    $nombre_etudiants[] = $data['nombre_etudiants'];
}
$sql = "SELECT COUNT(*) as total,utilisateur_type FROM utilisateur group by utilisateur_type ";
$result = $conn->query($sql);
$utilisateur_type = [];
$nombres = [];

while ($data = $result ->fetch_assoc()) {
    $utilisateur_type[] = $data['utilisateur_type'];
    $nombres[] = $data['total'];
}

// // Récupérer le nombre d'inscriptions d'écoles
// $sql = "SELECT COUNT(*) as total_ecoles FROM écoles_universités";
// $result_ecoles = $conn->query($sql);
// $row_ecoles = $result_ecoles->fetch_assoc();
// $total_ecoles = $row_ecoles['total_ecoles'];

// // Récupérer le nombre d'inscriptions d'entreprises
// $sql = "SELECT COUNT(*) as total_entreprises FROM entreprise";
// $result_entreprises = $conn->query($sql);
// $row_entreprises = $result_entreprises->fetch_assoc();
// $total_entreprises = $row_entreprises['total_entreprises'];



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
    
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom styles for this template-->
    <link href="styledashbord.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashbord.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <!-- <i class="fa-solid fa-graduation-cap"></i> -->
                </div>
                <div class="sidebar-brand-text mx-3"><img class="logo" src="logo 2.jpeg"> <sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="dashboardEtud.php">
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
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
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
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fa-solid fa-user-gear"></i>
                    <span>  Services</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Gestion de notre platforme :</h6>
                    <a class="collapse-item " href="problems.php"><i class="fas fa-fw fa-exclamation-triangle"></i> Gestion de problèmes</a>                  
                          <!-- <a class="collapse-item" href="entretiens.php"><i class="fa fa-handshake"></i> PFQ Entretiens </a>
                        <a class="collapse-item" href="entretiens.php"><i class="fa fa-handshake"></i> PFQ Entretiens </a>
                        <a class="collapse-item" href="archive.php"><i class="fa-solid fa-book-open"></i> Mes notes</a>
                        <a class="collapse-item" href="cv.php"><i class="fas fa-file-alt" style="margin-right: 5px; margin-left: 2px;"></i>  Création CV </a> -->

                    </div>
                </div>
            </li>
            <hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        
        <i class="fa-solid fa-comment"></i>
        <span>Informations de contact </span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Contactez-nous:</h6>
            <a class="collapse-item" ><i class="fa fa-envelope"></i> contact@CreerLinx.ma</a>
            <a class="collapse-item" ><i class="fa fa-map"></i> City Dakhla , Agadir</a>
            <a class="collapse-item" ><i class="fa fa-phone"></i> +212 6 20 88 32 14</a>
          
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
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
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
                        </li>

                        <!-- <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle"  id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                            
                                <span class="badge badge-danger badge-counter" id="noti_nbr"><?php echo $unread_count; ?></span>
                            </a>
                    
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
                        </li> -->

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
                                <a class="dropdown-item d-flex align-items-center" href="#"onclick="read_noti(\'noti\',\'noti_nbr\')">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold" id="mess">
                                        <div class="text-truncate">' . $mes['question'] . '</div>
                                        <div class="small text-gray-500">' . $mes['date_envoi_question'] . '</div>';
                                        if($mes['reponse']===null)
                                        echo '<form action="#" method="get">
                                        <input type="text" id="textInput" placeholder="reponse" name="reponse">
                                        <button class="button bg" type="button" id="sendButton">Envoyer</button>
                                      </form>
                                
                                      <script>
                                        document.getElementById("sendButton").addEventListener("click", function() {
                                          var inputUrl = document.getElementById("textInput").value;
                                          if (inputUrl) {
                                            var url = "dashboardAdmin.php?reponse=" + encodeURIComponent(inputUrl)&id=' . urlencode($mes["id_consultation"]) . '";
                                            window.location.href = url;
                                          }
                                        });
                                      </script>';
                                        echo'        </div>
                                </a>';
                                            } else {           echo '
                                                <a class="dropdown-item d-flex align-items-center"  onclick="read_noti(\'noti\',\'noti_nbr\')">
                                                    <div class="dropdown-list-image mr-3">
                                                        <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                                                        <div class="status-indicator bg-success"></div>
                                                    </div>
                                                    <div  >
                                                        <div class="text-truncate">' . $mes['question'] . '</div>
                                                        <div class="small text-gray-500">'  . $mes['date_envoi_question']. '</div>';
                                                     if($mes['reponse']===null)
                                                     echo '<form action="dashboardAdmin.php" method="get">
                                                     <input type="text" id="textInput" placeholder="reponse" name="reponse">
                                                     <button class="button bg" type="button" id="sendButton">Envoyer</button>
                                                   </form>
                                             
                                                   <script>
                                                     document.getElementById("sendButton").addEventListener("click", function() {
                                                       var inputUrl = document.getElementById("textInput").value;
                                                       if (inputUrl) {
                                                         var url = "dashboardAdmin.php?reponse=" + encodeURIComponent(inputUrl)+"&id=' . urlencode($mes["id_consultation"]) . '";
                                                         window.location.href = url;
                                                       }
                                                     });
                                                   </script>';
                                                        echo'        </div>
                                                </a>';
                                            }
                                        } ?> <a class="dropdown-item text-center small text-gray-500" href="<?php readALL('consultation'); ?>">Fermer</a>


                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $donnes["nom"] ?></span>
                                <img class="img-profile rounded-circle" src="utilisateur.jpg">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" onclick="openForm('profile', event)">
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tableau de bord </h1>
                        <!-- <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="#" onclick="openForm('contactForm', event)"><i class="fas fa-download fa-sm text-white-50"></i> Assistance disponible</a> -->
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
                                            Nombre de utilisateur de site :</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo$NombreUsers; ?></div>
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
                                            Nombre d'entreprises </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo  nombreEse($conn); ?> </div>
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
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Nombre des étudiants 
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo nombreEtud($conn); ?></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo nombreEtud($conn); ?>%" aria-valuenow="<?php echo nombreEtud($conn); ?>" aria-valuemin="0" aria-valuemax="100"></div>
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
                                            Nombre des écoles </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo nombreEcole($conn);?></div>
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

                    <div class="row">

<!-- Area Chart -->


<!-- Pie Chart -->

</div>

<!-- Content Row -->
<div class="row">

<div class="col-xl-8 col-lg-7">

    <!-- Area Chart -->
    

    <!-- Bar Chart -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Nombre d'étudiants inscrits selon les écoles sur le site</h6>
        </div>
        <div class="card-body">
         
<div style="width: 700px; height: 400px;">
  <canvas id="myChart" width="700" height="400"></canvas>
</div>

<script>
      // Data du graphique
      const labels = <?php echo json_encode($ecoles) ?>;
const data = {
  labels: labels,
  datasets: [{
    label: 'Nombre d\'étudiants',
    data: <?php echo json_encode($nombre_etudiants) ?> ,
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)'
    ],
    borderColor: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
    ],
    borderWidth: 1
  }]
};
// </block:setup>

// <block:config:0>
const config = {
  type: 'bar',
  data: data,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
};
// </block:config>


var myChart = new Chart(
    document.getElementById('myChart'),
    config
  );

  

</script>

            <hr>
   
            <!-- <code>/js/demo/chart-bar-demo.js</code>  -->
        </div>
    </div>

</div>

<!-- Donut Chart -->
<div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Taux d'inscription des étudiants, des écoles et des entreprises sur Creerlinx</h6>
            </div>
        <!-- Card Body -->
        <div class="card-body ml-3">

                
                <div><canvas id="pieChart" width="300" height="300"></canvas></div>
   
    <script>
        var ctx = document.getElementById('pieChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($utilisateur_type); ?>,
                datasets: [{
                    label: 'Nombre d\'étudiants',
                    data: <?php echo json_encode($nombres); ?>,
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
                
   
            <hr>
            <!-- Styling for the donut chart can be found in the
            <code>/js/demo/chart-pie-demo.js</code> file. -->
        </div>
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
 <!--
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
                                     <div id="overlay" class="overlay" onclick="closeForms()"></div>

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

                                        <input type="tel" name="tel" class="form-control" value="<?php echo $donnes['tel'] ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <h6 class="">Address</h6>

                                        <textarea class="form-control" name="adresse" height="20" rows="1"><?php echo $donnes['adresse']; ?></textarea>
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

    <div id="message" class="form-popup">

<span class="close" onclick="closeForm('message')">&times;</span>

<div class="container">
    <form action="profile.php" method="post" enctype="multipart/form-data">
        <div class="">
            <div class="card">    
           

<input type="text" name="reponse" class="form-control" value=""> <button class="save">
                                <input type="submit" name="Sauvegarder" class="btn btn-primary px-4 " value="Sauvegarder">
                            </button>
                            <h6 class="mb-0">Reponse</h6>
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
        function read_noti(id,id_nbr) {
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

</body>

</html>