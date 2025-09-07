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
  :root {
      --primary-color: #007bff;
      --secondary-color: #0056b3;
      --text-color: #333;
    }

    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      color: var(--text-color);
    }

    .questionBtn {
      width: 100%;
      padding: 15px 25px;
      margin: 10px 0;
      background-color: var(--primary-color);
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .questionBtn:hover {
      background-color: var(--secondary-color);
      transform: translateY(-2px);
    }

    .response {
      padding: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-top: 10px;
      transition: opacity 0.3s ease;
    }

    .response p {
      margin: 10px 0;
    }

    .hidden {
      display: none;
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
    <h1>Questions d'entretien d'embauche</h1>
    
    <button class="questionBtn" data-question="Parlez-moi de vous">Parlez-moi de vous?</button>
    <div id="Parlez-moi-de-vous" class="response hidden">
      <p><strong>Réponse :</strong> Je suis [votre nom]. J'ai une solide expérience dans [votre domaine] et j'ai travaillé sur [mentionnez vos réalisations]. Je suis passionné par [votre domaine] et j'aspire à [vos objectifs professionnels].</p>
      <p><strong>Exemple :</strong> "Je suis Sarah Johnson. Au cours des cinq dernières années, j'ai travaillé dans le domaine du marketing digital, en me concentrant principalement sur les stratégies de contenu et les médias sociaux. L'une de mes réalisations les plus marquantes a été de diriger une campagne de marketing viral qui a accru la visibilité de notre entreprise de 150 % en six mois seulement. Ce qui me passionne le plus dans le marketing digital, c'est la capacité à créer des connexions authentiques avec notre public et à influencer positivement leur perception de la marque. Mon objectif professionnel est de continuer à développer mes compétences en marketing digital et de contribuer à la croissance d'une entreprise innovante dans ce domaine."</p>
    </div>

    <button class="questionBtn" data-question="Quelles sont vos principales forces et faiblesses ?">Quelles sont vos principales forces et faiblesses ?</button>
    <div id="Quelles-sont-vos-principales-forces-et-faiblesses-?" class="response hidden">
      <p><strong>Réponse (forces) :</strong> Mes principales forces sont ma capacité à [compétence pertinente], ma créativité pour [aptitude spécifique] et ma capacité à [autre compétence pertinente].</p>
      <p><strong>Réponse (faiblesses) :</strong> Je dirais que l'une de mes faiblesses est parfois mon désir d'assurer la perfection, ce qui peut me rendre trop critique envers moi-même. Cependant, j'ai appris à reconnaître cela et à chercher un équilibre.</p>
      <p><strong>Exemple :</strong> Mes principales forces résident dans ma capacité à résoudre les problèmes de manière créative et efficace. Par exemple, dans mon précédent poste, j'ai été confronté à un défi complexe où nous devions réorganiser notre processus de gestion des stocks pour minimiser les erreurs et réduire les coûts. Grâce à ma capacité à analyser rapidement les problèmes et à proposer des solutions innovantes, j'ai pu mettre en place un nouveau système qui a amélioré l'efficacité de l'ensemble de l'équipe.</p>

    </div>

    <button class="questionBtn" data-question="Où vous voyez-vous dans cinq ans ?">Où vous voyez-vous dans cinq ans ?</button>
    <div id="Où-vous-voyez-vous-dans-cinq-ans-?" class="response hidden">
      <p><strong>Réponse :</strong> Dans cinq ans, j'espère avoir développé mes compétences et mes responsabilités au sein de cette entreprise, éventuellement en occupant un rôle de [poste souhaité] où je pourrais contribuer de manière significative à [objectif spécifique de l'entreprise].</p>
      <p><strong>Exmple :</strong> Dans cinq ans, je me vois occupant un poste de responsabilité au sein de cette entreprise, ayant consolidé mes compétences et acquis une expertise approfondie dans mon domaine. Mon objectif est de contribuer de manière significative à la réussite de l'entreprise, en apportant des idées novatrices et en collaborant étroitement avec mes collègues pour atteindre les objectifs stratégiques fixés. Par exemple, je pourrais envisager d'occuper un poste de chef de projet, où je serais chargé de piloter des initiatives clés et d'assurer la coordination entre les différentes équipes. Je suis motivé par l'idée de relever de nouveaux défis et de continuer à évoluer professionnellement au sein de cette organisation dynamique.</p>

    </div>

    <button class="questionBtn" data-question="Pourquoi voulez-vous travailler pour notre entreprise ?">Pourquoi voulez-vous travailler pour notre entreprise ?</button>
    <div id="Pourquoi-voulez-vous-travailler-pour-notre-entreprise-?" class="response hidden">
      <p><strong>Réponse :</strong> Je suis très attiré par la culture d'entreprise de votre entreprise, ainsi que par ses projets innovants dans [domaine spécifique]. Je crois que mes compétences et mon expérience pourraient contribuer de manière significative à votre équipe.</p>
      <p><strong>Exmple :</strong>Je suis profondément attiré par votre entreprise en raison de sa réputation d'innovation et de leadership dans l'industrie. Vos valeurs d'excellence, d'intégrité et de collaboration résonnent avec mes propres convictions professionnelles. De plus, j'ai suivi de près vos projets et réalisations, et je suis impressionné par l'impact positif que vous avez eu dans le domaine. En travaillant pour votre entreprise, je vois l'opportunité de contribuer à des projets stimulants, de travailler aux côtés de professionnels talentueux et de continuer à apprendre et à croître dans un environnement dynamique. Je suis convaincu que ma passion, mes compétences et mon engagement seraient des atouts précieux pour votre équipe, et je suis enthousiaste à l'idée de faire partie de votre succès continu.</p>

    </div>

    <button class="questionBtn" data-question="Parlez-moi d'une situation où vous avez surmonté un défi ?">Parlez-moi d'une situation où vous avez surmonté un défi?</button>
    <div id="Parlez-moi-d'une-situation-où-vous-avez-surmonté-un-défi-?" class="response hidden">
      <p><strong>Réponse :</strong>Dans mon poste précédent chez [nom de l'entreprise], nous étions confrontés à [défi spécifique]. J'ai pris l'initiative de [action spécifique], ce qui a permis à l'équipe de surmonter cet obstacle avec succès.</p>
      <p><strong>Exmple :</strong> Lorsque j'étais responsable d'un projet de développement logiciel, l'un de nos principaux développeurs est tombé malade juste avant la date limite de livraison. Pour surmonter ce défi, j'ai organisé une réunion d'urgence, réaffecté les tâches, assumé une partie du travail du développeur malade, et encouragé une collaboration étroite au sein de l'équipe. Malgré le stress, nous avons réussi à respecter la date limite sans compromettre la qualité du produit, renforçant ainsi ma capacité à gérer efficacement les situations imprévues et à mener mon équipe vers le succès.</p>

    </div>
    <button class="questionBtn" data-question="Décrivez votre style de travail ?">Décrivez votre style de travail ?</button>
    <div id="Décrivez-votre-style-de-travail-?" class="response hidden">
      <p><strong>Réponse :</strong> Je suis quelqu'un de très organisé et axé sur les résultats. J'apprécie la collaboration avec mes collègues pour atteindre nos objectifs communs. Je suis également flexible et capable de m'adapter aux changements de priorités.</p>
      <p><strong>Exmple :</strong>  Mon style de travail est axé sur l'organisation et les résultats. Je suis méthodique dans la planification de mes tâches et je m'efforce constamment de respecter les délais. Je crois en une approche collaborative, où je peux travailler efficacement en équipe pour atteindre nos objectifs communs. Je suis également adaptable et capable de m'adapter aux changements de priorités, ce qui me permet de rester productif même dans des environnements dynamiques. En résumé, je suis orienté vers les résultats, organisé et collaboratif dans ma façon de travailler.</p>

    </div>

    <button class="questionBtn" data-question="Comment gérez-vous le stress au travail ?">Comment gérez-vous le stress au travail ?</button>
    <div id="Comment-gérez-vous-le-stress-au-travail-?" class="response hidden">
      <p><strong>Réponse :</strong> Je gère le stress en organisant efficacement mon temps, en communiquant ouvertement avec mon équipe et en prenant des pauses régulières pour recharger mes batteries. Je trouve également utile de pratiquer la respiration profonde et la méditation.</p>
      <p><strong>Exmple :</strong> Pour gérer le stress au travail, j'ai développé plusieurs stratégies. Tout d'abord, j'organise efficacement mon temps en établissant des priorités et en planifiant mes tâches. Cela me permet de rester concentré sur ce qui est le plus important. De plus, je communique ouvertement avec mon équipe pour partager les responsabilités et résoudre les problèmes ensemble. Prendre des pauses régulières est également essentiel pour recharger mes batteries et maintenir ma productivité. Enfin, je trouve utile de pratiquer des techniques de relaxation telles que la respiration profonde et la méditation pour rester calme et concentré, même dans des situations stressantes.</p>

    </div>

    <button class="questionBtn" data-question="Quelles sont vos attentes salariales ?">Quelles sont vos attentes salariales ?</button>
    <div id="Quelles-sont-vos-attentes-salariales-?" class="response hidden">
      <p><strong>Réponse :</strong> Je suis ouvert à discuter de la rémunération en fonction de mes compétences, de mon expérience et des normes du marché pour ce poste. Mon objectif est d'obtenir une rémunération équitable et alignée sur mes contributions à l'entreprise.</p>
      <p><strong>Exmple :</strong> En ce qui concerne mes attentes salariales, je suis ouvert à discuter d'une rémunération qui reflète à la fois mes compétences, mon expérience ainsi que les normes du marché pour ce poste. Mon objectif est d'obtenir une rémunération équitable et alignée sur la valeur que je peux apporter à l'entreprise. Je suis flexible et prêt à négocier de manière constructive pour parvenir à un accord mutuellement avantageux.</p>

    </div>

    <button class="questionBtn" data-question="Avez-vous des questions pour nous ?">Avez-vous des questions pour nous ?</button>
    <div id="Avez-vous-des-questions-pour-nous-?" class="response hidden">
      <p><strong>Réponse :</strong> Oui, j'aimerais en savoir plus sur [aspect spécifique de l'entreprise ou du poste]. Pourriez-vous m'en dire plus sur [sujet spécifique] </p>
      <p><strong>Exmple :</strong><br> -Pouvez-vous me décrire la culture d'entreprise ici ?<br>
                                -Quels sont les principaux défis auxquels l'équipe est confrontée actuellement ?<br>
        -Comment envisagez-vous la croissance de l'entreprise dans les prochaines années ?<br>
        -Quelles sont les opportunités de développement professionnel offertes aux employés au sein de l'entreprise ?<br>
        -Comment se déroule le processus d'intégration des nouveaux employés dans l'équipe ?<br>
        -Y a-t-il des projets ou des initiatives spécifiques sur lesquels l'équipe travaille actuellement et dans lesquels je pourrais être impliqué ?</p>

    </div>

    <button class="questionBtn" data-question="Pourquoi devrions-nous vous embaucher ?">Pourquoi devrions-nous vous embaucher ?</button>
    <div id="Pourquoi-devrions-nous-vous-embaucher-?" class="response hidden">
      <p><strong>Réponse :</strong> Je pense que vous devriez m'embaucher car je possède les compétences, l'expérience et la passion nécessaires pour exceller dans ce poste. Je suis déterminé à contribuer de manière significative à votre entreprise et à aider à atteindre ses objectifs.</p>
      <p><strong>Exmple :</strong> Vous devriez m'envisager pour ce poste car je suis convaincu que ma combinaison de compétences, d'expérience et de passion peut apporter une réelle valeur ajoutée à votre équipe. Avec une solide expérience dans [votre domaine], j'ai démontré ma capacité à [réalisation spécifique pertinente pour le poste]. En outre, ma volonté d'apprendre et de m'adapter me permet de m'intégrer rapidement et efficacement dans de nouveaux environnements. Je suis également motivé par [aspect spécifique de l'entreprise ou du poste] et je suis convaincu que mon enthousiasme et mon engagement contribueront positivement à la réalisation des objectifs de l'équipe. Enfin, je suis prêt à relever les défis et à travailler avec détermination pour atteindre l'excellence dans ce rôle.</p>

    </div>

    
    <button class="questionBtn" data-question="Quelle est votre expérience dans ce domaine ?">Quelle est votre expérience dans ce domaine ?</button>
    <div id="Quelle-est-votre-expérience-dans-ce-domaine-?" class="response hidden">
      <p><strong>Réponse :</strong> J'ai accumulé X années d'expérience dans ce domaine, travaillant sur divers projets et acquérant des compétences telles que [compétence 1], [compétence 2], et [compétence 3]. J'ai travaillé avec des entreprises de différentes tailles, ce qui m'a permis de développer une compréhension approfondie des défis et des opportunités dans ce secteur.</p>

    </div>

    <button class="questionBtn" data-question="Comment décririez-vous votre approche de la résolution de problèmes ?">Comment décririez-vous votre approche de la résolution de problèmes ?</button>
    <div id="Comment-décririez-vous-votre-approche-de-la-résolution-de-problèmes-?" class="response hidden">
      <p><strong>Réponse :</strong>Ma méthode de résolution de problèmes implique d'abord une analyse approfondie de la situation pour identifier les causes sous-jacentes. Ensuite, je développe des solutions créatives et pragmatiques en collaborant avec mon équipe et en tenant compte des objectifs à long terme de l'entreprise. Enfin, je mets en œuvre et évalue les solutions pour assurer leur efficacité.</p>

    </div>
    
    <button class="questionBtn" data-question="Pouvez-vous nous parler d'un projet dont vous êtes particulièrement fier ?">Pouvez-vous nous parler d'un projet dont vous êtes particulièrement fier ?</button>
    <div id="Pouvez-vous-nous-parler-d'un-projet-dont-vous-êtes-particulièrement-fier-?" class="response hidden">
      <p><strong>Réponse :</strong> Un projet dont je suis particulièrement fier est [nom du projet]. Dans ce projet, nous avons été confrontés à [défi spécifique], et grâce à une collaboration étroite avec mon équipe, nous avons pu [résultat obtenu]. Cela a non seulement eu un impact positif sur l'entreprise, mais cela m'a également permis de développer mes compétences en [compétence spécifique] et en [compétence spécifique].</p>

    </div>


  </div>
  <script src="script.js"></script>
  <script>

document.addEventListener("DOMContentLoaded", function() {
  const questionBtns = document.querySelectorAll(".questionBtn");

  questionBtns.forEach(function(btn) {
    btn.addEventListener("click", function() {
      const responseId = this.getAttribute("data-question").replace(/ /g, '-');
      const response = document.getElementById(responseId);
      // Inverse la classe "hidden" pour afficher ou cacher la réponse
      response.classList.toggle("hidden");
    });
  });
});

</script>
</body>
</html>