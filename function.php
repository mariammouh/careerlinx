<?php
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

    } else return false ;
    return $data;
}
function isINecole( $query)
{
    global $conn;
    $sql = "SELECT * FROM écoles_universités  WHERE description LIKE '%$query%' OR location LIKE '%$query%' OR 	Nom_Ecole LIKE '%$query%'";
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
function isINese( $query)
{
    global $conn;
    $sql = "SELECT * FROM entreprise WHERE description LIKE '%$query%' OR location LIKE '%$query%' OR 	Nom_Entreprise LIKE '%$query%' OR 	Secteur_Activite LIKE '%$query%'	";
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
function isInDiplome( $query,$id_e)
{
    global $conn;
    if($query===null) $sql = "SELECT * FROM diplomes WHERE ID_Ecole='$id_e'";
    if($id_e===null)
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
function isInOffre( $query,$id_e)
{
    global $conn;
    if($query===null) $sql = "SELECT * FROM emploi_stage WHERE 	ID_Entreprise='$id_e'";
    if($id_e===null)
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
function isInCoun( $query)
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