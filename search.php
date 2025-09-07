<!DOCTYPE html>
<html lang="en">
<?php

session_start();
// $id_user=$_SESSION['id_user'];
function getEcole($id)
{
  global $conn;
  $sql = "SELECT * FROM écoles_universités where ID_Ecole ='$id'";
  $result = $conn->query($sql);

  if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row;
    }
  }
}
function getEse($id)
{
  global $conn;
  $sql = "SELECT * FROM entreprise where ID_Entreprise ='$id'";
  $result = $conn->query($sql);

  if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row;
    }
  }
}
function isCOUN($id)
{
  global $conn;
  $sql = "SELECT * FROM concours_entretiens WHERE id_concours='$id'	";
  $result = $conn->query($sql);
  $data = array();
  if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {


      return $row;
    }

    if (empty($data)) return false;
  } else
    return false;
}
function inscrir($id)
{
  global $conn;
  $sql = "SELECT * FROM inscription_concour WHERE ID_Diplome='$id'	";
  $result = $conn->query($sql);
  $data = array();
  if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

      if (strtotime($row['Date_limite_inscription']) > time()) {

        return $row;
      }
    }

    if (empty($data)) return false;
  } else
    return false;
}
function showTable($table)
{
  global $conn;
  $sql = "SELECT * FROM $table ";
  $result = $conn->query($sql);
  $data = array();
  if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }
  } else return false;
  return $data;
}
function isINecole($query)
{
  global $conn;
  $sql = "SELECT * FROM écoles_universités  WHERE description LIKE '%$query%' OR Localisation LIKE '%$query%' OR 	Nom_Ecole LIKE '%$query%'";
  $result = $conn->query($sql);
  $data = array();
  if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }
    return $data;
  } else
    return false;
}
function isINese($query)
{
  global $conn;
  $sql = "SELECT * FROM entreprise WHERE description LIKE '%$query%' OR Localisation LIKE '%$query%' OR 	Nom_Entreprise LIKE '%$query%' OR 	Secteur_Activite LIKE '%$query%'	";
  $result = $conn->query($sql);
  $data = array();
  if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }
    return $data;
  } else
    return false;
}
function isInDiplome($query, $id_e)
{
  global $conn;
  if ($query === null) $sql = "SELECT * FROM diplomes WHERE ID_Ecole='$id_e'";
  if ($id_e === null)
    $sql = "SELECT * FROM diplomes WHERE Nom_Diplome LIKE '%$query%' OR Niveau_Diplome LIKE '%$query%' OR 	Domaine_Etude LIKE '%$query%' 	";
  else  $sql = "SELECT * FROM diplomes WHERE (Nom_Diplome LIKE '%$query%' OR Niveau_Diplome LIKE '%$query%' OR Domaine_Etude LIKE '%$query%') AND ID_Ecole='$id_e'";
  $result = $conn->query($sql);
  $data = array();

  if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }
    return $data;
  } else
    return false;
}
function isInOffre($query, $id_e)
{
  global $conn;
  if ($query === null) $sql = "SELECT * FROM emploi_stage WHERE 	ID_Entreprise='$id_e'";
  if ($id_e === null)
    $sql = "SELECT * FROM emploi_stage WHERE Titre_Offre LIKE '%$query%' OR Description_Offre LIKE '%$query%' OR 	Type_Offre LIKE '%$query%' 	";
  else  $sql = "SELECT * FROM emploi_stage WHERE (Titre_Offre LIKE '%$query%' OR Description_Offre LIKE '%$query%' OR Type_Offre LIKE '%$query%') AND 	ID_Entreprise='$id_e'";
  $result = $conn->query($sql);
  $data = array();
  if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

      $data[] = $row;
    }
    return $data;
  } else
    return false;
}
function isInCoun($query)
{
  global $conn;
  $sql = "SELECT * FROM concours_entretiens WHERE description LIKE '%$query%' OR location LIKE '%$query%' OR 	Nom_Entreprise LIKE '%$query%' OR 	Secteur_Activite LIKE '%$query%'	";
  $result = $conn->query($sql);
  $data = array();
  if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }
    return $data;
  } else
    return false;
}
function sanitizeInput($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "careerlinx";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$query=" rechercher";
if (isset($_GET['query'])) {



$query = $_GET['query'];
$data = array();
// var_dump($_GET);
if (isset($_GET['category'])) {
  $category = isset($_GET['category']) ? sanitizeInput($_GET['category']) : '';
  $subFilterValue = isset($_GET['subFilterValue']) ? sanitizeInput($_GET['subFilterValue']) : '';

  if ($category !== "tous") {

    switch ($category) {
      case 'ecole':
        $sql = "SELECT * FROM écoles_universités where ( description LIKE '%$query%' OR Localisation LIKE '%$query%' OR 	Nom_Ecole LIKE '%$query%')";

        // var_dump($_GET);


        if (isset($_GET["ecole_type_d'ecole"]) && !empty($_GET["ecole_type_d'ecole"])) {
          $typeEcole = sanitizeInput($_GET["ecole_type_d'ecole"]);
          $sql .= " AND type_ecole = '$typeEcole'";
          // echo "typeEcole: $typeEcole<br>"; 
        }


        if (isset($_GET['ecole_accessibilité']) && !empty($_GET['ecole_accessibilité'])) {
          $accessibilite = sanitizeInput($_GET['ecole_accessibilité']);
          $sql .= " AND accessibilite LIKE '%$accessibilite%'";
          // echo "accessibilite: $accessibilite<br>"; 
        }

        if (isset($_GET['ecole_location']) && !empty($_GET['ecole_location'])) {
          $location = sanitizeInput($_GET['ecole_location']);
          $sql .= " AND localisation LIKE '%$location%'";
        }
        break;

      case 'entreprise':
        $sql = "SELECT * FROM entreprise WHERE ( description LIKE '%$query%' OR Localisation LIKE '%$query%' OR 	Nom_Entreprise LIKE '%$query%' OR 	Secteur_Activite LIKE '%$query%')";

        // var_dump($_GET);


        if (isset($_GET['entreprise_secteur_de_travail']) && !empty($_GET['entreprise_secteur_de_travail'])) {
          $secteurTravail = sanitizeInput($_GET['entreprise_secteur_de_travail']);
          $sql .= " AND Secteur_Activite LIKE '%$secteurTravail%'";
          // echo "secteurTravail: $secteurTravail<br>"; 
        }

        if (isset($_GET['entreprise_location']) && !empty($_GET['entreprise_location'])) {
          $location = sanitizeInput($_GET['entreprise_location']);
          $sql .= " AND localisation LIKE '%$location%'";
          // echo "location: $location<br>"; 
        }

        break;


      case 'offre':
        $sql = "SELECT * FROM emploi_stage WHERE (Titre_Offre LIKE '%$query%' OR Description_Offre LIKE '%$query%' )";

        if (isset($_GET['offre_type_offre']) && !empty($_GET['offre_type_offre'])) {
          $typeOffre = sanitizeInput($_GET['offre_type_offre']);
          $sql .= " AND type_offre = '$typeOffre'";
          // echo "typeOffre: $typeOffre<br>";
        }


        if (isset($_GET['offre_durée']) && !empty($_GET['offre_durée'])) {
          $duree = sanitizeInput($_GET['offre_durée']);
          $duree = ($duree === "descendant") ? " DESC" : " ASC";
          $sql .= " order by duree_formation $duree";
          // echo "duree: $duree<br>"; 
        }
        break;


      case 'diplome':
        $sql = "SELECT * FROM diplomes WHERE (Nom_Diplome LIKE '%$query%' OR Niveau_Diplome LIKE '%$query%' OR 	Domaine_Etude LIKE '%$query%')";


        if (isset($_GET['diplome_niveau_diplome']) && !empty($_GET['diplome_niveau_diplome'])) {
          $niveauDiplome = sanitizeInput($_GET['diplome_niveau_diplome']);
          $sql .= " and niveau_diplome = '$niveauDiplome'";
          // echo "niveauDiplome: $niveauDiplome<br>"; 
        }


        if (isset($_GET['diplome_domaine_etude']) && !empty($_GET['diplome_domaine_etude'])) {
          $domaineEtude = sanitizeInput($_GET['diplome_domaine_etude']);
          $sql .= " AND domaine_etude LIKE '%$domaineEtude%'";
          // echo "domaineEtude: $domaineEtude<br>"; 
        }


        if (isset($_GET['diplome_durée']) && !empty($_GET['diplome_durée'])) {
          $duree = sanitizeInput($_GET['diplome_durée']);
          $duree = ($duree === "descendant") ? " DESC" : " ASC";
          $sql .= " order by duree_formation $duree";
          // echo "duree: $duree<br>"; 
        }


        if (isset($_GET['diplome_seuil']) && !empty($_GET['diplome_seuil'])) {
          $seuil = sanitizeInput($_GET['diplome_seuil']);

          $seuil = ($seuil === "descendant") ? " DESC" : " ASC";
          $sql .= " order by seuil_selection $seuil";
          // echo "seuil: $seuil<br>"; 
        }
        break;
    }
    $result = $conn->query($sql);
    if ($result !== false && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
    }

    // echo $sql . " <br>";
  }
}
$keywords = array("entreprise", "ecole", "university",  "stage", "emploi", "concour", "diplome", "entretien");
foreach ($keywords as $keyword) {

  if (stripos($query, $keyword) !== false) {
    switch ($keyword) {
      case "stage":
        if (isInOffre($query, null) !== false) {
          $datau[] = isInOffre($query, null);
          foreach ($datau as  $valu)
            $data = $valu;
        } else {

          $sql = "SELECT * FROM offre where Type_Offre='stage' ";
          $result = $conn->query($sql);

          if ($result !== false && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $data[] = $row;
            }
          }
        }
        break;
      case "emploi":
        $datau = array();
        if (isInOffre($query, null) !== false) {
          $datau[] = isInOffre($query, null);
          foreach ($datau as  $valu) {
            $data = $valu;
          }
        } else {

          $sql = "SELECT * FROM offre where Type_Offre='emploi' ";
          $result = $conn->query($sql);

          if ($result !== false && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $data[] = $row;
            }
          }
        }
        break;
      case "diplome":
        if (isInDiplome($query, null) !== false)
          $data[] = isInDiplome($query, null);
        $sql = "SELECT * FROM diplomes ";
        $result = $conn->query($sql);
        $data = array();
        if ($result !== false && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $data[] = $row;
          }
        }
        break;
      case "entreprise":

        if (isINese($query) !== false) {

          $data = isINese($query);
          foreach ($data as  $val) {
            //   $data=$val;
            //   foreach($val as $v )
            //    echo$v;
            // echo array_values($val);
            if (isInOffre($query, $val['ID_Entreprise']) !== false)
              $data[] = isInOffre($query, $val['ID_Entreprise']);
            else  $data[] = isInOffre(null, $val['ID_Entreprise']);
          }
        }
        if ($query === "entreprise") {

          $id_ecoles[] = showTable("entreprise");
          // $data[] = showTable("entreprise");
          $sql = "SELECT * FROM entreprise";
          $result = $conn->query($sql);
          $data = array();
          if ($result !== false && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $data[] = $row;
            }
          }
          // foreach ($data as $id) {
          //   if (isInOffre($query, $val['ID_Entreprise']) !== false)"
          //     $data[] = isInOffre($query, $id['ID_Entreprise']);
          // }

        }
        break;
      case "école" or "university":
        if (isINecole($query) !== false) {
          $datau[] = isINecole($query);
          foreach ($datau as  $valu)
            $data = $valu;
          foreach ($data as  $val) {
            if (isInDiplome($query, $val['ID_Ecole']) !== false)
              $data[] = isInDiplome($query, $val['ID_Ecole']);
            else  $data[] = isInDiplome(null, $val['ID_Ecole']);
          }
        } else {
          $id_ecoles[] = showTable("écoles_universités");
          $sql = "SELECT * FROM écoles_universités ";
          $result = $conn->query($sql);

          if ($result !== false && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $data[] = $row;
            }
          }
          // foreach ($id_ecoles as $id) {
          //     if (isInDiplome($query, $id['ID_Ecole']) !== false)
          //         $data[] = isInDiplome($query, $id['ID_Ecole']);
          // }
        }
        break;
      case "concour" or "entretien":
        if (isInDiplome($query, null) !== false)
          $data[] = isInDiplome($query, null);
        if (isInOffre($query, null) !== false)
          $data[] = isInOffre($query, null);
        break;
    }
    // if (!empty($table)) {
    //     $data = showTable($table);
    //     if (!empty($data)) {
    //         echo "<h2>Résultats pour '$keyword'</h2>";
    //         echo "<ul>";
    //         foreach ($data as $row) {
    //             echo "<li>" . $row["Nom_Ecole"] . " - " . $row["Localisation"] . "</li>";
    //         }
    //         echo "</ul>";
    //     } else {
    //         echo "<p>Aucun résultat trouvé pour '$keyword'</p>";
    //     }
    // }
  } elseif (!in_array($query, $keywords)) {
    if (isINecole($query) !== false) {
      // $data[] = isINecole($query);
      $datau[] = isINecole($query);
      foreach ($datau as  $valu)
        $data = $valu;
      // foreach ($data as  $val) {
      //   if (isInDiplome($query, $val['ID_Ecole']) !== false) {
      //     $datar[] = isInDiplome($query, $val['ID_Ecole']);
      //     foreach ($datar as  $vale)
      //       array_push($data, $vale);
      //   } else {
      //     $datar[] = isInDiplome(null, $val['ID_Ecole']);
      //     foreach ($datar as  $vale)
      //       $data = $vale;
      //   }
      // }
    }
    if (isInDiplome($query, null) !== false) {
      $datar[] = isInDiplome($query, null);
      foreach ($datar as  $vale)
        $data = $vale;
    }
    if (isINese($query) !== false) {
      $datau[] = isINese($query);
      $data = array();
      foreach ($datau as  $vale)
        $data = $vale;
      // foreach ($Edata as  $val[]) {
      //   if (isInOffre($query, $val['ID_Entreprise']) !== false)
      //     $data[] = isInOffre($query, $val['ID_Entreprise']);
      //   else  $data[] = isInOffre(null, $val['ID_Entreprise']);
      // }
    }
    if (isInOffre($query, null) !== false) {
      $datau = isInOffre($query, null);

      $arrays = array_filter($datau, 'is_array');
      $arrayCount = count($arrays);
      if (($arrayCount) === 1) {
        $data = array_merge($data, $datau);
      } else {

        foreach ($datau as  $val) {
          $data = $val;
        }
      }
    }
  }
}
}

// $conn->close();
?>



<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>CareerLinx</title>

  <!-- Custom fonts for this template-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">


  <link href="styledashbord.css" rel="stylesheet">
  <style>
    .filter {
      display: inline-flex;
      align-items: center;
      padding: 10px;
      color: #858796;

    }

    .filter select {
      margin-right: 10px;
      padding: 5px;
      font-size: 16px;
      color: #858796;
      border-radius: 10px;
      max-height: min-content;
    }

    .disabled {
      opacity: 0.5;
      pointer-events: none;
      color: #858796;

    }



    .filter button {
      margin-right: 10px;

      background-color: transparent;
      color: #858796;

      border: 1px solid #858796;

      padding: 5px 10px;
      min-width: auto;
      cursor: pointer;
      border-radius: 10px;
    }

    .filter button,
    select:hover {
      background-color: #858796;

      color: #ffffff;

    }

    .navbar {
      height: fit-content;
    }

    .subFilter {
      display: flex;
    }

    .form-info {
      font-weight: normal;
      color: #858796;
    }

    .form-group .form-label {
      margin-left: 20px;
      color: black;

    }

    .content-form h4 {
      color: blue;

    }

    .content-form h2 {
      font-weight: bold;
      color: black;
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
      width: max-content;
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
.input-field{
  display: inline-flex;
}
    /* .navbar-nav {

      background-image: url('side_b.png');
      margin-bottom: auto;
      background-repeat: repeat;
      background-position: center center;
    } */

    /* section {
      width: 100%;
      height: 658px;
      background-image: url(side.jpg);
      background-size: cover;
     position: relative; 
      overflow: hidden;
    }

    .navbar-nav {
      /* position: absolute;
     
      width: 100%;
      height: 100%;
      background: rgba(blue, 0.5); 
    } */
    .logo{
      border-radius: 10px;
    }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
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
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fa-solid fa-user-gear"></i>
          <span> Services</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Notre platforme offre :</h6>
            <a class="collapse-item" href="councours.php"><i class="fas fa-fw fa-folder"></i> Ancienne concours </a>
            <a class="collapse-item" href="entretiens.php"><i class="fa fa-handshake"></i> PFQ Entretiens </a>
            <a class="collapse-item" href="mesNotes.php"><i class="fa-solid fa-book-open"></i> Mes notes</a>
            <a class="collapse-item" href="cv.php"><i class="fas fa-file-alt" style="margin-right: 5px; margin-left: 2px;"></i> Création CV </a>

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
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="get" action="search.php">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Rechercher..." name="query" value="<?php echo $query;?>" aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
            <div class="filter">
              <select id="categorySelect" name="category">
                <option value="tous">Tous</option>
                <option value="ecole">Ecole</option>
                <option value="entreprise">Entreprise</option>
                <option value="offre">Offre</option>
                <option value="diplome">Diplome</option>
                <!-- <option value="concour">Concours</option> -->
              </select>
              <div id="subFilter" name="subFilterValue" class="subFilter">
                <select class="disabled">
                  <option>...</option>
                </select>
                <select class="disabled">
                  <option>...</option>
                </select>
                <select class="disabled">
                  <option>...</option>
                </select>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->

        </nav>

        <div id="results">
          <div class="container-fluid">
            <?php
            if (empty($data) || !isset($data)) echo "Aucun résultat trouvé pour $query";
            else if (!empty($data) && isset($data)) {
              foreach ($data as $don) {
                if ($don !== false && !empty($don) && is_array($don)) {
                  if (array_key_exists('Nom_Ecole', $don)) {
                    echo '<div class="school"><div class="logoo"><img src="' . $don['logo'] . '" alt="Logo"></div><div class="school-info">';
                    echo "<h2>" . $don['Nom_Ecole'] . "</h2>";
                    echo "<p>	
                  " . $don['Description'] . "<br>";
                    echo  "<span  class='titre'>Localisation:</span> " . $don['Localisation'] . "<br>" .
                      "<span  class='titre'>Type d'école: </span>" . $don['typeEcole'] .
                      "<span class='titre'> Accessibilité: </span>" . $don['Accessibilité'] . "<br>" .
                      "<span class='titre'> Date de création:</span> " . $don['Date_Creation'] . "<br>" .
                      "<span  class='titre'> Nombre des filières: </span>" . $don['nbr_filière'] .
                      "<span class='titre'>   Nombre des étudiants: </span>" . $don['nbr_étud'] .
                      "<br><span class='titre'> Contact:</span> " . $don['Contact']  .
                      "<br><span class='titre'> Web site: </span> <a href='" . $don['siteWeb'] . "' >" . $don['Nom_Ecole'] . "</a><br></p>";
                    //         <a href="#" class="register-link">S'inscrire</a>
                    echo '
        </div> <div class="location"><iframe 
        src="' . $don["location_map"] . '" 
          width="250" height="250" style="border:0;" allowfullscreen="" loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade"></iframe></div>';
                    echo " </div>";
                  } elseif (array_key_exists('Nom_Entreprise', $don)) {
                    echo '<div class="school"><div class="logoo"><img src="' . $don['Logo'] . '" alt="Logo"></div><div class="school-info">';
                    echo "<h2>" . $don['Nom_Entreprise'] . "</h2>";
                    echo "<p> " . $don['Description'] . "<br>";
                    echo  "<span  class='titre'>Localisation:</span> " . $don['Localisation'] . "<br>" .
                      "<span class='titre'> Date de création:</span> " . $don['Date_Creation'] . "<br>" .
                      "<span class='titre'> Secteur d'Activite:</span> " . $don['Secteur_Activite'] . "<br>" .
                      "<span class='titre'> Contact:</span> " . $don['Contact'] . "<br>" .
                      "<br><span class='titre'> Web site: </span> <a href='" . $don['website'] . "' >" . $don['Nom_Entreprise'] . "</a><br></p>";
                      echo '
                      </div> <div class="location"><iframe 
                      src="' . $don["location_map"] . '" 
                        width="250" height="250" style="border:0;" allowfullscreen="" loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"></iframe></div>';
                                  echo " </div>";
                  } elseif (array_key_exists('Nom_Diplome', $don)) {
                    $donn_e = getEcole($don['ID_Ecole']);
                    echo '<div class="school"><div class="school-info">';
                    echo "<h2>" . $don['Nom_Diplome'] . "</h2>";
                    echo "<p>  <span class='titre'> Niveau de diplome:</span> " . $don['Niveau_Diplome'] . "<br>";
                    echo "<p>  <span class='titre'> Domaine d'etude:</span> " . $don['Domaine_Etude'] . "<br>";
                    echo "<p>  <span class='titre'> Duree de formation:</span> " . $don['duree_formation'] . "<br>";
                    echo "<p>  <span class='titre'> Seuil de selection:</span> " . $don['seuil_selection'] . "<br>";
                    echo "<p>  <span class='titre'> Nom d'école :</span> " . $donn_e['Nom_Ecole'] . "<br>";
                    if (inscrir($don['ID_Diplome'])  !== false) {
                      echo '<button  name="inscrir" value=' . $don['ID_Diplome'] . ' class="inscrir" onclick="openForm(`inscrire`, event)" >S\'inscrire</button>';
                      $_SESSION["id_inscri"] = $don['ID_Diplome'];
                    }
                    echo "</div> </div>";
                  } elseif (array_key_exists('Titre_Offre', $don)) {
                    $donn_e = getEse($don['ID_Entreprise']);
                    echo '<div class="school"><div class="school-info">';
                    echo "<h2>" . $don['Titre_Offre'] . "</h2>";
                    echo "<p>" . $don['Description_Offre'] . "<br>";
                    echo "<p>  <span class='titre'> 	Type d'offre:</span> " . $don['Type_Offre'] . "<br>";
                    echo "<p>  <span class='titre'> Nom d'entreprise :</span> " . $donn_e['Nom_Entreprise'] . "<br>";
                    if (inscrir($don['ID_Offre']) !== false) echo '<form ><button class="inscrir" openForm("inscrire", event) >S\'inscrire</button> <form>';
                    echo "</div> </div>";
                  }
                } else {
                  echo "Aucun résultat trouvé pour $query";
                  break;
                }
              }
            }
            // $data=[];
            ?>
          </div>
        </div>
      </div>
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <div id="overlay" class="overlay" onclick="closeForms()"></div>
  <div class="LancerSansCon form-popup" id="inscrire">
    <span class="close" onclick="closeForm('inscrire')">&times;</span>
    <div class="content-form">
      <?php
      // Database connection parameters
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "careerlinx";


      $conn = new mysqli($servername, $username, $password, $dbname);


      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $requirements = (inscrir($_SESSION['id_inscri']));
      $councour=false;
      if($requirements["id_concours"]!==null)
      $councour = isCOUN($requirements["id_concours"]);

      ?>
      <?php if ($councour !== false && $requirements["id_concours"]!==null ) { ?>
        <h2>Inscription au  <?php echo $councour["Titre"]; ?> </h2>

        <h4>Des information de concour : </h4>
        <div class="form-group">
          <label class="form-label" for="type">Type de Concours: <span class="form-info"><?php echo $councour["type"]; ?> </label>

          <label class="form-label" for="location">Lieu du Concours: <span class="form-info"><?php echo $councour["location"]; ?> </label>
          <label class="form-label" for="duree">Durée: <span class="form-info"><?php echo $councour["Duree"]; ?> </label>
        </div>
        <div class="form-group">
          <label class="form-label" for="date">Date du Concours: <span class="form-info"><?php echo $councour["Date_concourEntretien"]; ?> </label>

          <label class="form-label" for="heure">Heure du Concours: <span class="form-info"><?php echo $councour["Heure_h"]; ?> </label>


        </div><?php } else  echo"<h2>Inscription :</h2> ";?>
      <h4>Des information de l'inscription : </h4>
      <div class="form-group">
        <label class="form-label" for="date_limite">Date Limite d'Inscription: <span class="form-info"><?php echo $requirements["Date_limite_inscription"]; ?> </label>
      </div>
      <div class="form-group">
        <label class="form-label" for="seuil_selection">Seuil de Sélection: <span class="form-info"><?php echo $requirements["seuil_selection"]; ?> </label>
      </div>
      <div class="form-group">
        <label class="form-label">Fichiers Requis: <span class="form-info"><?php echo $requirements["fichier_necessaire"]; ?> </label><br>
      </div>
      <form action="inscri.php" method="POST" class="container_lancer" enctype="multipart/form-data" >
        <h4>Les fichiers de l'inscription : </h4>

        <label for="image" class="form-label">Semmetre les fichiers necessaires : (pdf ou docx)</label>
        <div class="form-group"> <?php 
        $files = explode(" ", $requirements["fichier_necessaire"]);
        foreach ($files as $fich) {  ?>
          <div class="input-field ">
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
                <span> <?php echo$fich; ?></span>
              <input type="file" id="file" name="<?php echo$fich; ?>">
          </div></div>
        <?php } ?>
        </div>
       
        <button class="form-button" name="enregistre" value="<?php echo $requirements["id_concours"]; ?>" type="submit">Enregistrer</button>
      </form>
    </div>


  </div>
  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script>
    const subFilters = {
      ecole: {
        'Type d\'ecole': ['Private', 'Public'],
        'Accessibilité': ['Université', 'Polarisation limitée', 'Polarisation ouverte'],
        'Location': ['Rabat', 'Casablanca', 'Marrakech', 'Fes', 'Tangier', 'Agadir', 'Essaouira', 'Meknes', 'Ouarzazate', 'Chefchaouen', 'Tetouan', 'Oujda', 'Kenitra', 'El Jadida', 'Taroudant']
      },
      entreprise: {
        'Secteur de travail': ['Construction', 'Commercial', 'Industriel', 'Technologie de l\'information et des communications', 'Finance et services bancaires', 'Santé et pharmaceutique', 'Énergie et environnement', 'Industrie manufacturière', 'Commerce de détail et commerce électronique', 'Éducation et formation', 'Tourisme et hôtellerie', 'Transport et logistique', 'Services professionnels :conseil- juridique- comptabilité- etc.'],
        'Location': ['Rabat', 'Casablanca', 'Marrakech', 'Fes', 'Tangier', 'Agadir', 'Essaouira', 'Meknes', 'Ouarzazate', 'Chefchaouen', 'Tetouan', 'Oujda', 'Kenitra', 'El Jadida', 'Taroudant']
      },
      offre: {
        'Type offre': ['Stage', 'Emploi'],
        'Durée': ['Ascendant', 'Descendant']
      },
      diplome: {
        'Niveau Diplome': ['Baccalauréat', 'Licence', 'Diplôme', 'Master', 'Doctorat'],
        'Domaine Etude': ['Sciences', 'Ingénierie', 'Médecine et sciences de la santé', 'Sciences humaines et sociales', 'Commerce et gestion', 'Arts et lettres', 'Éducation', 'Droit', 'Agriculture et environnement', 'Tourisme et hôtellerie', 'Communication et médias', 'Architecture et urbanisme', 'Technologie et innovation', 'Énergie et développement durable', 'Arts culinaires'],
        'Durée': ['Ascendant', 'Descendant'],
        'Seuil': ['Ascendant', 'Descendant']
      }
      // Add more subfilters for other categories if needed
    };

    const categorySelect = document.getElementById('categorySelect');
    const subFilterDiv = document.getElementById('subFilter');
    const resultsDiv = document.getElementById('results');

    categorySelect.addEventListener('change', function() {
      const category = this.value;
      subFilterDiv.innerHTML = '';
      if (category !== 'tous') {
        Object.entries(subFilters[category]).forEach(([label, options]) => {
          const select = document.createElement('select');
          select.classList.add('subSelect');
          select.name = `${category}_${label.replace(/\s+/g, '_').toLowerCase()}`;
          const optionLabel = document.createElement('option');
          optionLabel.textContent = label;
          optionLabel.disabled = true;
          optionLabel.selected = true; // Initially selected label
          select.appendChild(optionLabel);
          if (Array.isArray(options)) {
            options.forEach(option => {
              const subOption = document.createElement('option');
              subOption.textContent = option;
              subOption.value = option.toLowerCase().replace(/ /g, '_');
              select.appendChild(subOption);
            });
          } else {
            options.forEach(option => {
              const subOption = document.createElement('option');
              subOption.textContent = option === 'Ascendant' ? 'Ascendant' : 'Descendant';
              subOption.value = option.toLowerCase();
              select.appendChild(subOption);
            });
          }
          subFilterDiv.appendChild(select);
        });
      } else {
        const disabledSelect = document.createElement('select');
        disabledSelect.classList.add('subSelect', 'disabled');
        const disabledOption = document.createElement('option');
        disabledOption.textContent = "Select...";
        disabledSelect.appendChild(disabledOption);
        subFilterDiv.appendChild(disabledSelect);
      }
    });

    function fetchResults() {
      const category = document.getElementById('categorySelect').value;
      const subFilterValue = document.querySelector('#subFilter select:not(.disabled)').value;

      // Construct the URL with parameters
      const url = `search.php?category=${encodeURIComponent(category)}&subFilterValue=${encodeURIComponent(subFilterValue)}`;

      // AJAX request to PHP backend
      const xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById('results').innerHTML = this.responseText;
        }
      };

      xhttp.open("GET", url, true);
      xhttp.send();
    }



    function additionalAction() {
      // Your additional action here
      console.log('Additional action performed!');
    }

    document.addEventListener("DOMContentLoaded", function() {
      var form = document.getElementById("myForm");

      form.addEventListener("submit", function(event) {
        // Prevent default form submission
        event.preventDefault();

        // Perform form submission
        var formData = new FormData(form);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", form.action);
        xhr.onload = function() {
          if (xhr.status === 200) {
            console.log("Form submitted successfully");
            // Perform additional action after form submission
            additionalAction();
          } else {
            console.log("Form submission failed");
          }
        };
        xhr.send(formData);
      });

      // Button click event
      var button = document.getElementById("yourButtonId");
      button.addEventListener("click", function(event) {
        event.preventDefault();
        // Perform additional action when button is clicked
        additionalAction();
      });
    });




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

</body>

</html>