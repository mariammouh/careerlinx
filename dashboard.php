<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche</title>
</head>

<body>
    <h1>Résultats de recherche</h1>

    <form action="" method="get">
        <input type="text" name="query" placeholder="Entrez votre recherche">
        <button type="submit">Rechercher</button>
    </form>

    <?php
    require_once "function.php";
    session_start();
    $id_user=$_SESSION['id_user'];
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "careerlinx";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['query'])) {
        $query = $_GET['query'];

        // Construct SQL query to fetch data from 'ecoles_universites' table
        $sql_ecole = "SELECT * FROM écoles_universités WHERE Description LIKE '%$query%' OR Localisation LIKE '%$query%'";
        $result_ecole = $conn->query($sql_ecole);

        // Display search results for 'ecole'
        if ($result_ecole->num_rows > 0) {
            echo "<h2>Résultats pour 'école'</h2>";
            echo "<ul>";
            while ($row = $result_ecole->fetch_assoc()) {
                echo "<li>" . $row["Nom_Ecole"] . " - " . $row["Localisation"] . "</li>";
            }
            echo "</ul>";
        }

        // Construct SQL query to fetch data from 'entreprise' table
        $sql_entreprise = "SELECT * FROM entreprise WHERE Description LIKE '%$query%' OR Localisation LIKE '%$query%'";
        $result_entreprise = $conn->query($sql_entreprise);

        // Display search results for 'entreprise'
        if ($result_entreprise->num_rows > 0) {
            echo "<h2>Résultats pour 'entreprise'</h2>";
            echo "<ul>";
            while ($row = $result_entreprise->fetch_assoc()) {
                echo "<li>" . $row["name"] . " - " . $row["location"] . "</li>";
            }
            echo "</ul>";
        }
    }


    if (isset($_GET['query'])) {
        $query = $_GET['query'];

        // Keywords for database tables
        $keywords = array("ecole", "university", "entreprise", "stage", "emploi", "concour", "diplome", "entretien");
        foreach ($keywords as $keyword) {
            if (stripos($query, $keyword) !== false) {
                // Fetch data from the corresponding table
                $table = "";
                switch ($keyword) {
                    case "ecole" or "university":
                        if (isINecole($query) !== false) {
                            $data[] = isINecole($query);
                            foreach ($data as  $val[]) {
                                if (isInDiplome($query, $val['ID_Ecole']) !== false)
                                    $data[] = isInDiplome($query, $val['ID_Ecole']);
                                else  $data[] = isInDiplome(null, $val['ID_Ecole']);
                            }
                        } else {
                            $id_ecoles[] = showTable("écoles_universités");
                            $data[] = showTable("écoles_universités");
                            foreach ($id_ecoles as $id) {
                                if (isInDiplome($query, $val['ID_Ecole']) !== false)
                                    $data[] = isInDiplome($query, $id['ID_Ecole']);
                            }
                        }
                        break;

                    case "entreprise":
                        if (isINese($query) !== false) {
                            $data[] = isINese($query);
                            foreach ($data as  $val[]) {
                                if (isInOffre($query, $val['ID_Ecole']) !== false)
                                    $data[] = isInOffre($query, $val['ID_Entreprise']);
                                else  $data[] = isInOffre(null, $val['ID_Entreprise']);
                            }
                        } else {
                            $id_ecoles[] = showTable("entreprise");
                            $data[] = showTable("entreprise");
                            foreach ($id_ecoles as $id) {
                                if (isInOffre($query, $val['ID_Entreprise']) !== false)
                                    $data[] = isInOffre($query, $id['ID_Entreprise']);
                            }
                        }
                        break;
                        case "diplome":
                            if (isInDiplome($query, null) !== false)
                            $data[] = isInDiplome($query, null);
                            break;
                    case "stage" or "emploi":
                        if (isInOffre($query,null) !== false)
                        $data[] = isInOffre($query, null);
                        break;
                    case "concour" or "entretien":
                        if (isInDiplome($query, null) !== false)
                            $data[] = isInDiplome($query, null);
                            if (isInOffre($query,null) !== false)
                            $data[] = isInOffre($query, null);
                            break;
                }
                if (!empty($table)) {
                    $data = showTable($table);
                    if (!empty($data)) {
                        echo "<h2>Résultats pour '$keyword'</h2>";
                        echo "<ul>";
                        foreach ($data as $row) {
                            echo "<li>" . $row["Nom_Ecole"] . " - " . $row["Localisation"] . "</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>Aucun résultat trouvé pour '$keyword'</p>";
                    }
                }
            } else {
                if (isINecole($query) !== false) {
                    $data[] = isINecole($query);
                    foreach ($data as  $val[]) {
                        if (isInDiplome($query, $val['ID_Ecole']) !== false)
                            $data[] = isInDiplome($query, $val['ID_Ecole']);
                        else  $data[] = isInDiplome(null, $val['ID_Ecole']);
                    }
                }
               else if (isInDiplome($query, null) !== false)
                    $data[] = isInDiplome($query, null);
                if (isINese($query) !== false){
                $data[] = isINese($query);
                $Edata[] = isINese($query);
                foreach ($Edata as  $val[]) {
                    if (isInOffre($query, $val['ID_Entreprise']) !== false)
                        $data[] = isInOffre($query, $val['ID_Entreprise']);
                    else  $data[] = isInOffre(null, $val['ID_Entreprise']);
                }
            }
           else if (isInOffre($query, null) !== false)
                $data[] = isInDiplome($query, null);
            }
        }
    
    }
    $conn->close();
    ?>
</body>

</html>