<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
$id_etud = $_SESSION["id_user"];
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
$sql = "select * from etudiant  where id_etudiant ='$id_etud'";
$result = $conn->query($sql);
if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $donnes = $row;
    }
}
$_SESSION["nom"] = $donnes['nom'];

?>
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

    <!-- Custom styles for this template-->
    <link href="styledashbord.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
 <style>

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f8f9fa;
}

.container {
  max-width: 800px;
  margin: 20px auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

h1 {
  text-align: center;
  color: #007bff;
}

.etapes-container {
  margin-top: 20px;
}

.etapes {
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
  padding: 20px;
  margin-bottom: 20px;
}

.etapes h2 {
  margin-top: 0;
  color: #333;
  font-size: 24px;
}

.etapes p {
  margin-top: 10px;
  color: #666;
  font-size: 18px;
}

 </style>
</head><body id="page-top">

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
            <div id="collapseUtilities" class="collapse show" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Notre platforme offre :</h6>
                        <a class="collapse-item" href="councours.php"><i class="fas fa-fw fa-folder"></i> Ancienne concours </a>
                        <a class="collapse-item active" href="entretiens.php"><i class="fa fa-handshake"></i> PFQ Entretiens </a>
                        <a class="collapse-item" href="archive.php"><i class="fa-solid fa-book-open"></i> Mes notes</a>
                        <a class="collapse-item" href="cv.php"><i class="fas fa-file-alt" style="margin-right: 5px; margin-left: 2px;"></i>  Création CV </a>

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
            <form
                class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Rechercher..."
                        aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                        aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small"
                                    placeholder="Search for..." aria-label="Search"
                                    aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

        
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-fw"></i>
                 
                        <span class="badge badge-danger badge-counter">3+</span>
                    </a>
                
                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="alertsDropdown">
                        <h6 class="dropdown-header">
                            Alerts Center
                        </h6>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                         <!-- notification -->   
                        </a>
                
                       
                <!-- Nav Item - Messages -->
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-envelope fa-fw"></i>
                        <!-- Counter - Messages -->
                        <span class="badge badge-danger badge-counter">7</span>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="messagesDropdown">
                        <h6 class="dropdown-header">
                            Message Center
                        </h6>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="dropdown-list-image mr-3">
                                <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                    alt="...">
                                <div class="status-indicator bg-success"></div>
                            </div>
                            <div class="font-weight-bold">
                                <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                    problem I've been having.</div>
                                <div class="small text-gray-500">Emily Fowler · 58m</div>
                            </div>
                        </a>
                        
                    </div>
                </li>

                <div class="topbar-divider d-none d-sm-block"></div>

<!-- Nav Item - User Information -->
<li class="nav-item dropdown no-arrow">
<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $donnes["nom"] ?></span>
    <img class="img-profile rounded-circle" src="<?php echo $donnes["image"] ?>">
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
           
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

  <div class="container">
 
    <h1>Gestion du stress et de l'anxiété - Étapes</h1>
    <div id="etapesContainer" class="etapes-container"></div>
  </div>
  <script src="script.js"></script>

  <script>
    // Données des étapes
const etapes = [
  {
    titre: "Identification des sources de stress",
    description: "Prenez le temps d'identifier les principales sources de stress dans votre vie, qu'elles soient liées au travail, aux relations personnelles, ou à d'autres aspects de votre quotidien. Cela pourrait inclure des délais serrés, des conflits interpersonnels, ou des préoccupations financières. La première étape pour gérer le stress est de comprendre ce qui le cause."
  },
  {
    titre: "Établissement d'un plan d'action",
    description: "Une fois que vous avez identifié les sources de stress, élaborez un plan d'action pour y faire face. Identifiez les aspects sur lesquels vous pouvez agir et ceux sur lesquels vous n'avez pas de contrôle direct. Concentrez-vous sur les actions que vous pouvez entreprendre pour atténuer le stress, comme la gestion du temps, la communication assertive, ou la recherche de soutien."
  },
  {
    titre: "Pratique de la relaxation",
    description: "Intégrez des techniques de relaxation dans votre quotidien pour vous aider à réduire le stress et l'anxiété. Cela peut inclure des exercices de respiration profonde, des séances de méditation, des pratiques de yoga, ou même des activités de loisirs relaxantes comme la lecture ou le jardinage. Trouvez ce qui fonctionne le mieux pour vous et faites-en une partie régulière de votre routine."
  },
  {
    titre: "Gestion de l'environnement",
    description: "Identifiez les aspects de votre environnement qui contribuent au stress et cherchez des moyens de les modifier. Cela pourrait impliquer de créer un espace de travail organisé et confortable, de limiter votre exposition aux sources de stress externes comme les médias sociaux ou les actualités, ou de planifier des moments de détente dans des endroits calmes et apaisants."
  },
  {
    titre: "Pratique d'une pensée positive",
    description: "Adoptez une attitude positive envers les défis et les obstacles que vous rencontrez. Travaillez sur la reframing des pensées négatives en pensées positives et constructives. Pratiquez la gratitude en prenant le temps de reconnaître et d'apprécier les aspects positifs de votre vie, même dans les moments difficiles."
  },
  {
    titre: "Recherche de soutien",
    description: "N'hésitez pas à demander de l'aide et du soutien à vos proches, à vos amis, ou à un professionnel de la santé mentale si nécessaire. Parler de vos préoccupations et de vos émotions peut vous aider à mieux les comprendre et à trouver des solutions adaptées. Ne sous-estimez pas l'importance du soutien social dans la gestion du stress."
  }
];

// Fonction pour générer les étapes
function genererEtapes() {
  const etapesContainer = document.getElementById("etapesContainer");

  // Pour chaque étape, créer un élément div avec le titre et la description
  etapes.forEach(etape => {
    const etapeDiv = document.createElement("div");
    etapeDiv.classList.add("etapes");
    etapeDiv.innerHTML = `
      <h2>${etape.titre}</h2>
      <p>${etape.description}</p>
    `;
    etapesContainer.appendChild(etapeDiv);
  });
}

// Appeler la fonction pour générer les étapes
genererEtapes();

  </script>
</body>
</html>
