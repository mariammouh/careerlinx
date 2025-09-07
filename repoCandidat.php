<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "careerlinx";
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check the connection
  if ($conn->connect_error) {
      die("Connexion échouée: " . $conn->connect_error);
  }
  function getnom($id) {
    global $conn; 
    $sqll = "SELECT Nom_Ecole FROM écoles_universités JOIN 
    diplomes ON écoles_universités.ID_Ecole = diplomes.ID_Ecole
WHERE 
    diplomes.ID_Diplome = '$id'";
        $result = $conn->query($sqll);
        if ($result !== false && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            return $row['Nom_Ecole'];
          }
        }
}function getGend($id_etudiant) {
    global $conn; 
    $sqll = "SELECT genre FROM etudiant WHERE id_etudiant = '$id_etudiant'";
        $result = $conn->query($sqll);
        if ($result !== false && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            return $row["genre"];
          }
        }
}
if ($_GET["page"] === "candida") {


    $id_etud = $_GET['id_etud'];
    $nom_di = $_GET['Nom_Diplome'];
    $id_d= $_GET['id_diplome'];
    $id_inscri = $_GET['id_inscri'];
    $action = $_GET['action'];
    if(isset($_GET['typ']))
    $typ = $_GET['typ'];
    $gender = getGend($id_etud);
    if ($action === "Accepter") {
        if ($typ === "Non") {
     
            $reponse = "Accepté";
            $ctn="Félicitations, vous avez été accepté(e) dans l\'inscription de ".$nom_di." chez l\'école".getnom($id_d) ;
        } else {
           $ctn="Félicitations, vous avez été accepté(e) lors de la première élection pour".$nom_di." chez l\'école".getnom($id_d) ;
            $reponse = "en attent";
        }
       
    } else if ($action==='adistance') {
        $reponse = "en attent";
        $ctn = "Félicitations, vous avez été accepté(e) lors de la première élection pour ".$nom_di." chez l\'école ".getnom($id_d)." L\'URL pour l\'entretien est ".$_GET['url'];        }
    
    
    elseif ($action === "Refuser"){
        $reponse = "Refusé"; 
    $ctn="Malheureusement, votre candidat(e) pour $nom_di  chez l\'école".getnom($id_d) ." a été refusé(e)";
    
    }

    if ($gender === "Homme") {
        $ctn = str_replace('(e)', '', $ctn); 
    }elseif ($gender === "Femme") {
        $ctn = str_replace('(e)', 'e', $ctn); 
    }
    // Connect to the database
    // echo '<script>alert("Erreur ' .$ctn . '");</script>';
    $sql_ecole = "update `resultat` set resultat='$reponse' where id_inscrir ='$id_inscri' and  id_etud='$id_etud'";
    if ($conn->query($sql_ecole) === FALSE) {
        echo '<script>alert("Erreur ' . $conn->error . '");</script>';
    }
    // echo '<script>alert("Erreur ' .now() . '");</script>';

    $sql_noti = "insert into  `notification`  (content,statut,date_creation,id_utilisateur) values ('$ctn','non lu',now(),'$id_etud')";
    if ($conn->query($sql_noti) === FALSE) {
        echo '<script>alert("Erreur ' . $conn->error . '");</script>';
    }

    header("Location:condidats.php");
}elseif ($_GET["page"] === "affiche") {


    $id_etud = $_GET['id_etud'];
    $nom_di = $_GET['Nom_Diplome'];
    $id_d= $_GET['id_diplome'];
    $id_inscri = $_GET['id_inscri'];
    $action = $_GET['action'];
    if(isset($_GET['typ']))
    $typ = $_GET['typ'];
    $gender = getGend($id_etud);
    if ($action === "Accepter") {
    $reponse = "Accepté";
            $ctn="Félicitations, vous avez été accepté(e) dans l\'inscription de ".$nom_di." chez l\'école".getnom($id_d) ;
    }elseif($action === "alistAttent") {
            $reponse = "dans list d\'attente";
            $ctn = "Vous êtes sur liste d\'attente pour ".$nom_di." à l\'école " . getnom($id_d) . ". Votre numéro dans la liste est " . $_GET['nbr'];   
         } elseif ($action === "Refuser"){
        $reponse = "Refusé"; 
    $ctn="Malheureusement, votre candidat(e) pour $nom_di  chez l\'école".getnom($id_d) ." a été refusé(e)";
    
    }
  
    if ($gender === "Homme") {
        $ctn = str_replace('(e)', '', $ctn); 
    }elseif ($gender === "Femme") {
        $ctn = str_replace('(e)', 'e', $ctn); 
    }
    // Connect to the database
    echo '<script>alert("Erreur ' .$ctn . '");</script>';
    $sql_ecole = "update `resultat` set resultat='$reponse' where id_inscrir ='$id_inscri' and  id_etud='$id_etud'";
    if ($conn->query($sql_ecole) === FALSE) {
        echo '<script>alert("Erreur ' . $conn->error . '");</script>';
    }
    // echo '<script>alert("Erreur ' .now() . '");</script>';

    $sql_noti = "insert into  `notification`  (content,statut,date_creation,id_utilisateur) values ('$ctn','non lu',now(),'$id_etud')";
    if ($conn->query($sql_noti) === FALSE) {
        echo '<script>alert("Erreur ' . $conn->error . '");</script>';
    }

    header("Location:afficheResulta.php");

    
}

?>