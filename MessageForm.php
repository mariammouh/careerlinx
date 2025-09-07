<?php
session_start();
$id_etud = $_SESSION["id_user"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["envoyerMessage"]) && !empty($_POST["envoyerMessage"])) {
        $messag = [];
       
        $message = $_POST["message"];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "careerlinx";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_POST["typeMessage"])) {
            $nom = $_POST["nom"];
            $email = $_POST["email"];
            $sql = "INSERT INTO probleme(date_premiere_apparition,description,statut) 
      VALUES (now(), '$message', 'nouveau')";
            if ($conn->query($sql) === TRUE) {
                array_push($messag, "Votre message était enregistrée  ");
                echo '<script>alert("CareerLinx says : Votre message était enregistrée avec succès.");</script>';
            } else {
                array_push($messag, "Erreur: " . $sql . "<br>" . $conn->error);
                echo '<script>alert("CareerLinx says : Désolé, votre message n`a pas été envoyé avec succès. Pouvez-vous le renvoyer?");</script>';
            }
        } else {
            $sql = "INSERT INTO consultation(id_admin , id_utilisateur ,
            question ,date_envoi_question,statut) 
            VALUES (1,$id_etud, '$message',now(), 'non lu')";
            if ($conn->query($sql) === TRUE) {
                array_push($messag, "Votre message était enregistrée  ");
                echo '<script>alert("CareerLinx says : Votre message était enregistrée avec succès.");</script>';
            } else {
                array_push($messag, "Erreur: " . $sql . "<br>" . $conn->error);
                echo '<script>alert("CareerLinx says : Désolé, votre message n`a pas été envoyé avec succès. Pouvez-vous le renvoyer?");</script>';
            }
        }
        $conn->close();
    }
}
