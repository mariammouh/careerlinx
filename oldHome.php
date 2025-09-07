<!DOCTYPE html>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
  if (isset($_POST["envoyerMessage"]) && !empty($_POST["envoyerMessage"])) {
    $messag=[];
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    if (isset($_POST["typeMessage"])) {
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "careerlinx";

      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $sql = "INSERT INTO probleme(date_premiere_apparition,description,statut) 
      VALUES (now(), '$message', 'nouveau')";
      if ($conn->query($sql) === TRUE) {
       array_push($messag,"Votre message était enregistrée  ");
       echo '<script>alert("CareerLinx says : Votre message était enregistrée avec succès.");</script>';
        
      } else {
        array_push($messag,"Erreur: " . $sql . "<br>" . $conn->error);
        echo '<script>alert("CareerLinx says : Désolé, votre message n`a pas été envoyé avec succès. Pouvez-vous le renvoyer?");</script>';
      }
      $conn->close();
    }
    $to = "careerlinx@gmail.com";
    $subject = "Nouveau message de contact";
    $body = "Nom: $nom\n";
    $body .= "Email: $email\n";
    $body .= "Message:\n$message\n";
    $checkBox = isset($_POST["typeMessage"]) ? "problem" : "consultation";
    $body .= "Type de message : $checkBox";
    $headers = "From: $email";
    if (mail($to, $subject, $body, $headers)) {
    
    echo '<script>alert("Email envoyé avec succès.");</script>';
     } else {
     echo '<script>alert("Désolé, votre message n`a pas été envoyé avec succès. Pouvez-vous le renvoyer?");</script>';
   }
  }
}
?>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.0/css/boxicons.min.css">
  <link rel="stylesheet" href="acceuil.css">
  <title>CareerLinx</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      display: block;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      justify-content: center;
      align-items: center;

    }

    /* Create a contactForm for the text and images */
    .text-contactForm {
      display: block;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 300px auto;
      width: 90%;
      justify-content: center;
      align-items: center;
      margin-bottom: 400px;
      padding-inline-start: 0%;
    }

    .text-contactForm .text {
      font-size: 18px;
      line-height: 1.5;
      max-width: 100px;
      /* margin: 50px;
      margin: 150px auto; */
      width: 50%;
      position: static;
      display: flex;
      justify-content: center;
      align-items: center;
      transition: 0.5s;
      margin: 40px;
      padding-left: 45%;
      
      margin-bottom: 50px;
      padding-bottom: 0%;


    }

    .text-contactForm p {
      line-height: 1.5;
      height: 300px;
      min-width: 80vh;
      text-align: justify;
      /*         
        font-size: 35px;
        float: left;
        font-weight: lighter;
        font-style: normal; */
      font-weight: 100;
      text-shadow: 0px 0px 2px rgba(0, 0, 0, 0.37);
      font-size: 30px;
      color: #464e57;
      line-height: 1.5;
      margin: 5px 0;
      margin-top: 0px;
      font-family: Arial, Helvetica, sans-serif;
      text-shadow: 0px 0px 2px black;
      font-family: Comic Sans MS;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      font-size: 18px;
      font-family: "Poppins", sans-serif;
    }

    .text-contactForm .image {
      width: 400px;
      height: 400px;

      float: right;
      object-fit: contain;
      margin: 80px;
    }

    #image1 {
      float: right;
    }

    #image2 {
      float: left;
    }

    #image3 {
      float: right;
    }

    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

    * {
      /* margin: 0;
  padding: 0;
  box-sizing: border-box; */
      font-family: 'Poppins', sans-serif;
    }

    .body {
      display: flex;
      min-height: 100vh;
      align-items: center;
      justify-content: center;
      background: #f2f2f2;
      position: relative;
      padding-top: 1px;
      border: 0px 0px 22px solid black;
      padding-left: 0px;
      margin-left: 0%;
      margin-inline-start: 0%;
    }

    /* .body::before {
      content: '';
      position: absolute;
      width: 100%;
      background: #FF676D;
      clip-path: inset(47% 0 0 0);
      z-index: -1;
      height: 100%;
    } */

    .container {
      
      width: 100%;
      overflow: hidden;
      padding: 80px 0;

      display: flex;
      min-height: 170vh;
      min-width: 50vh;
      align-items: center;
      justify-content: center;
      /* background: #f2f2f2; */
      position: relative;
      padding: 1px;
      padding-top: 1px;
      padding-top: 1px;
      margin-left: 0px;
      /* box-shadow: 0px 0px 22px rgba(0, 0, 0, 0.37); */
      /* padding-left: 0px;
      margin-left: 0%;
      margin-inline-start: 0%;
      padding-inline-start: 0%; */
      margin-bottom: 250px;
    }



    .container .main-card {
      display: flex;
      justify-content: space-evenly;
      width: 100%;
      transition: 1s;
      padding-top: 1px;
      margin-top: 1px;
      
      /* box-shadow: 0px 0px 22px rgba(0, 0, 0, 0.37); */
      display: inline-block;
      min-height: 150vh;
      /* padding-left: 0px;
      margin-left: 0%;
      
      margin-inline-start: 0%;
      padding-inline-start: 0%; */

    }

    .container .main-card .cards {
      /* width: calc(100% - 15px); */
      width: 50em;
      display: flex;
      flex-wrap: wrap;
      /*margin: 0 20px ;*/
      justify-content: center;
      margin: 150px;

      padding: 0;
    height: auto;
      margin-top: 90px;
      padding-left: 0px;
      margin-inline-start: 10px;
      padding-inline-start: 10px;
    }

    .container h1 {
      font-size: 30px;
      margin-left: 780px;


      color: #333;
      /* Change the color to your preference */



      text-shadow: 0px 1px 2px black;
      text-decoration: underline;

      text-decoration-style: solid;
      /* Change the style: dashed, dotted, solid, double, wavy, etc. */
      text-decoration-thickness: 3px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      font-family: Arial, Helvetica, sans-serif;
      text-underline-offset: 15px;
      color: rgb(30, 30, 114);
      margin-top: 150px;
      font-family: "Poppins", sans-serif;
      /* margin-inline-start: 550px; */
    }

    .container.letter {

      color: #219EBC;
      color: #CDB4DB;

      color: #023047;
      color: #A2D2FF;
      font-size: 25px;
      color: #FFAFCC;
      color: #5e3d7f;
    }

    .main-card .cards .card {
      width: calc(100% / 4.2 - 10px);
      width: fit-content;
      background: #fff;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.25);
      transition: all 0.4s ease;
      box-shadow: 0 5px 10px #222a43;

      height: 400px;
      margin-inline: 100px;

    }

    .main-card .cards .card:hover {
      transform: translateY(-15px);

    }

    #proff {
      margin-left: 100px;
      ;
    }

    .cards .card .content {
      width: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;

    }

    .cards .card .content .img {
      height: 200px;
      width: 200px;
      border-radius: 50%;
      padding: 3px;
      background: #340dd2c4;
      margin-bottom: 14px;
    }

    .card .content .img img {
      height: 100%;
      width: 100%;
      border: 3px solid #ffff;
      border-radius: 50%;
      object-fit: cover;
    }

    .card .content .name {
      font-size: 25px;
      font-weight: 500;
      text-shadow: 0px 1px 2px black;
      padding: 5px;
    }

    .card .content .job {
      font-size: 20px;
      color: #FF676D;
      padding: 5px;
      text-shadow: 0px 1px 2px black;
    }

    .card .content .media-icons {
      margin-top: 10px;
      display: flex;

    }

    .media-icons a {
      text-align: center;
      line-height: 33px;
      height: 35px;
      width: 35px;
      margin: 0 4px;
      font-size: 14px;
      color: #FFF;
      border-radius: 50%;
      border: 2px solid transparent;
      background: #340dd2c4;
      transition: all 0.3s ease;
    }

    .media-icons a:hover {
      color: #FF676D;
      background-color: #fff;
      border-color: #340dd2c4;
    }


    input[type="radio"] {
      display: none;
    }

    @media (max-width: 768px) {
      .main-card .cards .card {
        margin: 20px 0 10px 0;
        width: calc(100% / 2 - 10px);
      }
    }

    @media (max-width: 600px) {
      .main-card .cards .card {
        /* margin: 20px 0 10px 0; */
        width: 100%;
      }
    }

    .cssbuttons-io-button {
      background: rgb(103, 80, 233);
      color: white;
      font-family: inherit;
      padding: 0.35em;
      padding-left: 1.2em;
      font-size: 20px;
      font-weight: 500;
      border-radius: 0.9em;
      border: none;
      letter-spacing: 0.05em;
      display: flex;
      align-items: center;
      box-shadow: inset 0 0 1.6em -0.6em #714da6;
      overflow: hidden;
      position: relative;
      height: 3.5em;
      padding-right: 3.3em;
      cursor: pointer;
      margin-top: 50px;
      margin-bottom: 1px;
    }

    .cssbuttons-io-button .icon {
      background: white;
      margin-left: 1em;
      position: absolute;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 2.5em;
      width: 2.2em;
      border-radius: 0.7em;
      box-shadow: 0.1em 0.1em 0.6em 0.2em navy;
      right: 0.3em;
      transition: all 0.3s;
    }

    .cssbuttons-io-button:hover .icon {
      width: calc(100% - 0.6em);
    }

    .cssbuttons-io-button .icon svg {
      width: 1.1em;
      transition: transform 0.3s;
      color: navy;
    }

    .cssbuttons-io-button:hover .icon svg {
      transform: translateX(0.1em);
    }

    .cssbuttons-io-button:active .icon {
      transform: scale(0.95);
    }

    #mid {
      margin-inline: 10px;
    }

    .title {
      font-size: 55px;
      margin-left: 100px;
      color: #333;
      margin-bottom: 20px;
      text-shadow: 0px 1px 1px black;
      font-family: Comic Sans MS;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #023047;

      white-space: nowrap;
      font-family: "Poppins", sans-serif;

    }

    #HEAD {
      padding-left: 30%;
    }

    * {
      padding: 0;
      margin: 0;
      text-decoration: none;
      list-style: none;
      font-family: 'work sans', sans-serif;
    }



    section {
      padding: 80px 13% 70px;

    }

    .footer {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, auto));
      gap: 2.5rem;
      background: linear-gradient(to right, #01134a, #2d0b00);
      position: absolute;
      left: 0;
      right: 0;
      bottom: 1000;
      border-top-left-radius: 125px;
      font-size: 13px;
    }

    .foter-content h4 {
      color: #fff;
      margin-bottom: 50px;
      margin-top: 40px;
      font-size: 20px;
      width: fit-content;
      position: relative;

    }

    .foter-content li {
      margin-bottom: 16px;
    }

    .foter-content li a {
      display: block;
      color: #d6d6d6;
      font-size: 15px;
      font-weight: 400;
      transition: all .40s ease;
    }

    .foter-content li a:hover {
      transform: translateY(-3px) translateX(-5px);
      color: #fff;
    }

    .foter-content p {
      color: #d6d6d6;
      font-size: 16px;
      line-height: 30px;
      margin: 20px 0;
    }

    .icons a {
      display: inline-block;
      font-size: 15px;
      color: #d6d6d6;
      margin-right: 20px;
      transition: all .40s ease;
      line-height: 40px;
    }

    .icons a:hover {
      color: #fff;
      transform: translateY(-5px);
    }

    .icons i {
      margin-right: 10px;
      font-size: 25px;

    }


    @media (max-width:1690px) {
      section {
        padding: 50px 5% 40px;
      }
    }

    @media (max-width:1120px) {
      .footer {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, auto));
        gap: 2rem;

      }
    }

    @media (max-width:700px) {
      .footer {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, auto));
        gap: 2.5rem;

      }
    }

    .copyright {
      color: #fff;
    }

    .copyright {
      text-align: center;
    }

    @keyframes moving {
      0% {
        left: -20px;
      }

      100% {
        left: 100px;
      }

    }

    img {
      width: 40%;
      height: auto;
    }

    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");

    :root {
      --primary-color: #5c48ee;
      --primary-color-dark: #0f1e6a;
      --secondary-color: #f9fafe;
      --text-color: #333333;
      --white: #ffffff;
      --max-width: 1200px;
    }

    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Poppins", sans-serif;
      background-color: var(--white);
    }

    nav {
      max-width: var(--max-width);
      margin: auto;
      padding: 1rem;
      height: 100px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .nav__logo img {
      height: 50%;
      width: 37%;

      size: 20%;
    }


    .nav__links {
      list-style: none;
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .link a {
      padding: 0.5rem 1rem;
      font-size: 1rem;
      font-weight: 500;
      color: var(--text-color);

      text-decoration: none;
      transition: 0.3s;
    }

    .link a:hover {
      color: var(--primary-color);
    }

    .link .nav__btn {
      padding: 0.5rem 2rem;
      color: var(--white) !important;
      background-color: var(--primary-color);
      border-radius: 5px;
    }

    .link .nav__btn:hover {
      background-color: var(--primary-color-dark);
    }

    .contactForm-h {
      max-width: var(--max-width);
      margin: auto;
      padding: 1rem;
      min-height: calc(100vh - 100px);
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 5rem;
    }

    .content__contactForm {
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
   
    overflow: auto; 
    }

    .content__contactForm h1 {
      font-size: 3rem;
      font-weight: 400;
      line-height: 3.5rem;
      color: var(--primary-color-dark);
      margin-bottom: 1rem;
      position: absolute;
      top: 0;
    right: 0;
    }

    .heading__1 {
      font-weight: 600;
    }

    .heading__2 {
      font-weight: 700;
      color: var(--primary-color);
    }

    .content__contactForm p {
      font-size: 1rem;
      color: var(--text-color);
      margin-bottom: 2rem;
      position: absolute;
    bottom: 0;
    left: 0;
    }

    .content__contactForm form {
      display: flex;
      align-items: center;
    }

    .content__contactForm input {
      width: 100%;
      max-width: 300px;
      padding: 1rem;
      font-size: 0.8rem;
      outline: none;
      border: none;
      box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.2);
    }

    .content__contactForm button {
      width: fit-content;
      padding: 1rem;
      font-size: 0.8rem;
      white-space: nowrap;
      background-color: var(--primary-color);
      color: var(--white);
      outline: none;
      border: none;
      box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.2);
      transition: 0.3s;
      cursor: pointer;
    }

    .content__contactForm button:hover {
      background-color: var(--primary-color-dark);
    }

    .image__contactForm {
      position: relative;
      display: flex;
      grid-template-columns: repeat(2, 1fr);
      gap: 2rem;
      place-content: center;


    }

    .image__contactForm img {


      margin: 0%;
      border-radius: 10px;
      width: 500px;
      height: 450px;
      padding: 0%;
    }



    .image__content {
      position: absolute;
      width: 100%;
      max-width: 310px;
      left: 50%;
      top: 50%;
      transform: translate(-35%, 50%);
      background: linear-gradient(to right,
          var(--primary-color),
          var(--primary-color-dark));
      color: var(--white);
      padding: 1rem 2rem;
      border-radius: 10px;
    }

    .image__content li {
      margin-bottom: 0.5rem;
    }

    @media (width < 900px) {
      .link a:not(.nav__btn) {
        display: none;
      }

      .contactForm-h {
        grid-template-columns: repeat(1, 1fr);
      }

      .content__contactForm {
        text-align: center;
      }

      .logo {
        height: 10%;
        width: 10%;
        border-radius: 50px;
      }

      .content__contactForm form {
        margin-right: auto;
        margin-left: auto;
      }

      .link .nav1__btn {
        padding: 0.5rem 2rem;

        border: var(--primary-color);
        border-radius: 5px;
      }

    }

    #eqi {
      margin-inline-start: 900px;

    }

    .contactForm {
      z-index: 12;
      max-width: 1050px;
      width: 100%;
      background: #fff;
      border-radius: 12px;
      margin: 0 20px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
      margin-bottom: 0%;
      padding-bottom: 0%;
    }

    .contactForm .content-form {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 25px 20px;
      margin-bottom: 0%;
      padding-bottom: 0%;
    }

    .content-form .image-box {
      max-width: 55%;
    }

    .content-form .image-box img {
      width: 100%;
    }

    .content-form .topic {
      font-size: 22px;
      font-weight: 500;
      color: #3692e9;
    }

    .content-form form {
      width: 40%;
      margin-right: 30px;
      margin-bottom: 0%;
    }

    .content-form .input-box {
      height: 50px;
      width: 100%;
      margin: 16px 0;
      position: relative;
    }

    .content-form .input-box input {
      position: absolute;
      height: 100%;
      width: 100%;
      border-radius: 6px;
      font-size: 16px;
      outline: none;
      padding: 0 16px;
      background: #fae9fb;
      border: 2px solid transparent;
      transition: all 0.3s ease;
    }

    .content-form .input-box input:focus,
    .content-form .input-box input:valid {
      border-color: #3692e9;
      background-color: #fff;
    }

    .content-form .input-box label {
      position: absolute;
      left: 18px;
      top: 50%;
      color: #636c72;
      font-size: 15px;
      pointer-events: none;
      transform: translateY(-50%);
      transition: all 0.3s ease;
    }

    .content-form .input-box input:focus~label,
    .content-form .input-box input:valid~label {
      top: 0;
      left: 12px;
      display: 14px;
      color: #3692e9;
      background: #fff;
    }

    .content-form .message-box {
      min-height: 100px;
      position: relative;
    }

    .content-form .message-box textarea {
      position: absolute;
      height: 100%;
      width: 100%;
      resize: none;
      background: #fae9fb;
      border: 2px solid transparent;
      border-radius: 6px;
      outline: none;
      padding: 5px 16px;
      transition: all 0.3s ease;
    }

    .content-form .message-box textarea:focus {
      border-color: #3692e9;
      background-color: #fff;
    }

    .content-form .message-box label {
      position: absolute;
      font-size: 16px;
      color: #636c72;
      left: 18px;
      top: 6px;
      pointer-events: none;
      transition: all 0.3s ease;
    }

    .content-form .message-box textarea:focus~label {
      left: 12px;
      top: -10px;
      color: #3692e9;
      font-size: 14px;
      background: #fff;
    }

    .content-form .input-box input[type="submit"] {
      color: #fff;
      background: #3692e9;
      padding-left: 0;
      font-size: 18px;
      font-weight: 500;
      cursor: pointer;
      letter-spacing: 1px;
      transition: all 0.3s ease;
    }

    .content-form .input-box input[type="submit"]:hover {
      background-color: #524feb;
    }

    @media (max-width: 1000px) {
      .content .image-box {
        max-width: 70%;
      }

      .content-form {
        padding: 10px 0;
      }
    }

    @media (max-width: 900px) {
      .content .image-box {
        display: none;
      }

      .content-form form {
        width: 100%;
        margin-left: 30px;
      }
    }

    .flex_align_justify {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .wrapper {
      min-height: 10vh;
      padding: 0 20px;
    }

    .tc_wrap {
      width: 700px;
      max-width: 100%;
      height: 450px;
      background: var(--white);
      display: flex;
      border-radius: 3px;
      overflow: hidden;
    }

    .tc_wrap .tabs_list {
      width: 200px;
      background: var(--tabs-list-bg-clr);
      height: 100%;
    }

    .tc_wrap .tabs_content {
      width: calc(100% - 200px);
      padding: 0 10px 0 20px;
      height: 100%;
    }

    .tc_wrap .tabs_content .tab_head,
    .tc_wrap .tabs_content .tab_foot {
      color: var(--primary-clr);
      padding: 25px 0;
      height: 70px;
    }

    .tc_wrap .tabs_content .tab_head {
      text-align: center;
    }

    .tc_wrap .tabs_content .tab_body {
      height: calc(100% - 140px);
      overflow: auto;
    }

    .tc_wrap .tabs_list ul {
      padding: 70px 20px;
      text-align: right;
    }

    .tc_wrap .tabs_list ul li {
      padding: 10px 0;
      position: relative;
      margin-bottom: 3px;
      cursor: pointer;
      font-weight: bold;
      transition: all 0.5s ease;
    }

    .tc_wrap .tabs_list ul li:before {
      content: "";
      position: absolute;
      top: 0;
      right: -20px;
      width: 2px;
      height: 100%;
      background: var(--primary-clr);
      opacity: 0;
      transition: all 0.5s ease;
    }

    .tc_wrap .tabs_list ul li.active,
    .tc_wrap .tabs_list ul li:hover {
      color: var(--primary-clr);
    }

    .tc_wrap .tabs_list ul li.active:before {
      opacity: 1;
    }

    .tc_wrap .tabs_content .tab_body .tab_item h3 {
      padding-top: 10px;
      margin-bottom: 10px;
      color: var(--primary-clr);
    }

    .tc_wrap .tabs_content .tab_body .tab_item p {
      margin-bottom: 20px;
    }

    .tc_wrap .tabs_content .tab_body .tab_item.active {
      display: block !important;
    }

    .tc_wrap .tabs_content .tab_foot button {
      width: 125px;
      padding: 5px 10px;
      background: transparent;
      border: 1px solid;
      border-radius: 25px;
      cursor: pointer;
      transition: all 0.5s ease;
    }

    .tc_wrap .tabs_content .tab_foot button.decline {
      margin-right: 15px;
      border-color: var(--tabs-list-bg-clr);
      color: var(--tabs-list-bg-clr);
    }

    .tc_wrap .tabs_content .tab_foot button.agree {
      background: var(--primary-clr);
      border-color: var(--primary-clr);
      color: var(--white);
    }

    .tc_wrap .tabs_content .tab_foot button.decline:hover {
      background: var(--tabs-list-bg-clr);
      color: var(--white);
    }

    .tc_wrap .tabs_content .tab_foot button.agree:hover {
      background: var(--btn-hvr);
      border-color: var(--btn-hvr);
    }


    .contactForm {
      /* display: none; 
        position: fixed;
        top: 50%; 
        left: 50%; 
        transform: translate(-50%, -50%) scale(0); 
        max-width: 400px;
        padding: 20px;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        border-radius: 5px;
        z-index: 999; 
        transition: transform 0.3s ease;  */
      margin-bottom: 0%;
      padding-bottom: 0%;
      min-height: 400px;
      min-width: 500px;

    }

    /* Style for overlay */
    .containerHome {
      position: relative;
    }

    :root {
      --primary-clr: #6c00f9;
      --white: #fff;
      --text-clr: #464646;
      --tabs-list-bg-clr: #dfc8fd;
      --btn-hvr: #4e03b0;
    }

    .overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 998;
    }

    /* Style for forms */
    .form-popup {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 20px;
      background-color: #f9f9f9;
      border: 1px solid #ccc;
      border-radius: 5px;
      z-index: 999;
    }



    /* Style for close button */
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }
    

  </style>
</head>

<body>
  <div class="containerHome">

    <nav class="home-content">
      <div class="nav__logo"><img src="careerLinx (3).png" class="logo"></div>
      <ul class="nav__links">
        <li class="link"><a href="#info">Apropos-nous</a></li>
        <li class="link"><a href="#" onclick="openForm('contactForm', event)">Contactez-nous</a></li>
        <li class="link"><a href="#" class="nav1__btn">Sign Up</a></li>
        <li class="link"><a href="#" class="nav__btn">Sign In</a></li>
      </ul>
    </nav>

    <section class="contactForm-h" id="home">
      <div class="content__contactForm">
        <h1>

          Bienvennue sur <span class="heading__1 ">CareerLinx</span><br />
          <span class="heading__2 typing"> </span>
        </h1>
        <p >
          Nous vous accompagnons dans votre parcours pour trouver l'école et la carrière de vos rêves, tout en mettant en avant les établissements et entreprises partenaires. Ensemble, construisons un avenir prometteur !
        </p>

      </div>
      <div class="image__contactForm">
        <!-- <img src="pic2.png" alt="header" /> -->
        <img src="pic1.jpeg" alt="header" />
        <!-- <div class="image__content">
          <ul>
            <li>Get 30% off on every 1st month</li>
            <li>Expert teachers</li>
          </ul>
        </div> -->
      </div>
    </section>
    <div class="text-contactForm" id="info">
      <h1 class="title" id="HEAD"> A quoi sert notre site ?</h1>
      <div class="text">

        <img src="https://th.bing.com/th/id/R.13e4177418b704708a5cff420dd8869d?rik=p5Or3dppzO7SdA&riu=http%3a%2f%2fwww.newcambridgecollege.com%2fblog%2fwp-content%2fuploads%2f2016%2f01%2fIELTS.jpg&ehk=iWZoZuclDfmF86x%2bYgvX0dXrr80t5xxIG4hkzlsW7ZE%3d&risl=&pid=ImgRaw&r=0" class="image">

        <p >
          Sur notre site, on est là pour aider les étudiants à trouver leur
          voie. Peu importe s'ils cherchent une formation, un métier, ou des
          opportunités de carrière, on les guide à chaque étape. On comprend que
          c'est un moment crucial, alors on met à leur disposition toutes les
          infos et l'assistance dont ils ont besoin pour réaliser leurs rêves.
          <button class="cssbuttons-io-button">
            Commencez
            <div class="icon">
              <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
              </svg>
            </div>
          </button>
        </p>


      </div>
      <br />
      <div class="text">

        <p >
          Notre site aide les écoles à se faire connaître et à attirer de
          nouveaux étudiants. Grâce à notre plateforme conviviale, les écoles
          peuvent partager leurs programmes et leurs réussites, et discuter
          directement avec les visiteurs. En résumé, nous offrons aux écoles une
          vitrine moderne pour attirer l'attention des futurs élèves.
          <button class="cssbuttons-io-button">
            Commencez
            <div class="icon">
              <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
              </svg>
            </div>
          </button>
        </p>

        <img src="https://th.bing.com/th/id/OIP.6sQo26u-Xw-OMnuXnOka0wHaE7?rs=1&pid=ImgDetMain" class="image">

      </div>
      <br />
      <div class="text">
        <img src="https://th.bing.com/th/id/OIP.g92urBPqxki53SXBY2FIWgHaDw?rs=1&pid=ImgDetMain" class="image">
        <p>
          Notre site aide les entreprises à trouver de futurs employés et
          formateurs tout en renforçant leur visibilité. Grâce à notre
          plateforme en ligne, les entreprises peuvent publier des offres
          d'emploi, présenter leur culture d'entreprise, et dialoguer
          directement avec les candidats potentiels. En bref, nous offrons aux
          entreprises un moyen efficace de recruter de nouveaux talents et de
          renforcer leur image de marque.
          <button class="cssbuttons-io-button">
            Commencez
            <div class="icon">
              <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
              </svg>
            </div>
          </button>
        </p>

      </div>
    </div>
    <br />
    <h1 class="title">Rencontrez les esprits créatifs qui donnent vie à notre site !</h1>
    <div class="container" id="equipe">

      <div class="main-card">
        <h1><span class="letter">S</span>uperviseur </h1>
        <div class="cards">
          <div class="card" id="proff">
            <div class="content">
              <div class="img">
                <img src="images/img1.jpg" alt="">
              </div>
              <div class="details">
                <div class="name">Hicham <br>El MOUBTAHIJ</div>
                <div class="job"></div>
              </div>
              <div class="media-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
              </div>
            </div>
          </div>
        </div>

        <h1 id="eqi"><span class="letter">E</span>quipe </h1>
        <div class="cards">
          <div class="card">
            <div class="content">
              <div class="img">
                <img src="me.jpeg" alt="">
              </div>
              <div class="details">
                <div class="name">Mariam MOUH</div>
                <div class="job"></div>
              </div>
              <div class="media-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
              </div>
            </div>
          </div>
          <div class="card" id="mid">
            <div class="content">
              <div class="img">
                <img src="images/img2.jpg" alt="">
              </div>
              <div class="details">
                <div class="name">Nadia BOUKHALI</div>
                <div class="job"></div>
              </div>
              <div class="media-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="content">
              <div class="img">
                <img src="images/img3.jpg" alt="">
              </div>
              <div class="details">
                <div class="name">Salma CHLIH</div>
                <div class="job"></div>
              </div>
              <div class="media-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
    <br>



    <footer>
      <section class="footer">
        <div class="foter-content">
          <img src="logo 2.jpeg">
          <p> Ici, vous pouvez trouver une solution intégrée à la gestion des informations académiques.
            Simplifiez vos démarches avec des interfaces dédiées aux étudiants, aux écoles et aux entreprises, le tout
            en un seul endroit</p>


        </div>
        <div class="foter-content">
          <h4>Office <div class="underline"><span></span></div>
          </h4>
          <li><a href="#">creerlinx@gmail.com</a></li>
          <li><a href="#">City Dakhla , Agadir</a></li>
          <li><a href="#">+212 6 20 88 32 14</a></li>

        </div>

        <div class="foter-content">
          <h4>Liens <div class="underline"><span></span></div>
          </h4>
          <li><a href="#home">Aceuil</a></li>
          <li><a href="#info">Services</a></li>
          <li><a href="#equipe">Equipe</a></li>
          <li><a href="#" onclick="openForm('contactForm', event)">Contactez-nous</a></li>
          <li><a href="#" onclick="openForm('termsForm', event)">Conditions</a></li>

        </div>

        <div class="foter-content">
          <h4>Reseaux Sociaux<div class="underline"><span></span></div>
          </h4>
          <div class="icons">
            <a href="#"><i class='bx bxl-facebook-circle'></i>Facebook </a></br>
            <a href="#"><i class='bx bxl-instagram-alt'></i>Instagram</a></br>
            <a href="#"><i class='bx bxl-twitter'></i>Twitter</a></br>
            <a href="#"><i class='bx bxl-linkedin-square'></i>LinkedIn</a></br>
          </div>
        </div>

        <div class="copyright">
          <p>Product of creerlinx, Inc. © 2024</p>
        </div>

      </section>
    </footer>


    <div id="overlay" class="overlay" onclick="closeForms()"></div>


    <div class="contactForm form-popup" id="contactForm">
      <span class="close" onclick="closeForm('contactForm')">&times;</span>
      <div class="content-form">
        <div class="image-box">
          <img src="contact.jpg" alt="" />
        </div>
        <form action="#" method="post">
          <div class="topic">Envoyez nous votre message </div>
          <div class="input-box">
            <input type="text" name="nom" required id="nom" />
            <label>Entrez votre nom</label>
          </div>
          <div class="input-box">
            <input type="text" id="email" name="email" required />
            <label>Entrez votre email</label>
          </div>
          <div class="message-box" >
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

    <div id="termsForm" class="form-popup">
      <div class="form-container">
        <span class="close" onclick="closeForm('termsForm')">&times;</span>
        <div class="wrapper flex_align_justify">
          <div class="tc_wrap">
            <div class="tabs_list">
              <ul>
                <li data-tc="tab_item_1" class="active">Conditions d'utilisation</li>
                <li data-tc="tab_item_2">Droits de propriété intellectuelle</li>
                <li data-tc="tab_item_3">Activités interdites</li>
                <li data-tc="tab_item_4">Clause de résiliation</li>
                <li data-tc="tab_item_5">Loi applicable</li>
              </ul>
            </div>

            <div class="tabs_content">
              <div class="tab_head">
                <h2>Conditions Générales d'Utilisation</h2>
              </div>
              <div class="tab_body">
                <div class="tab_item tab_item_1">
                  <h3>Conditions d'utilisation</h3>
                  <p> Cette section décrit les conditions générales d'utilisation du site, régissant l'accès et l'utilisation des services proposés. En acceptant ces conditions, l'utilisateur s'engage à respecter les règles énoncées et à utiliser le site de manière légale et appropriée. Les conditions d'utilisation définissent également les droits et responsabilités de l'utilisateur, ainsi que les obligations du site envers ses utilisateurs. En cas de non-respect de ces conditions, le site se réserve le droit de prendre des mesures appropriées, y compris la résiliation du compte utilisateur.</p>
                </div>
                <div class="tab_item tab_item_2" style="display: none;">
                  <h3>Droits de propriété intellectuelle</h3>
                  <p> Dans cette section, sont abordés les droits de propriété intellectuelle liés au contenu du site. Ces droits comprennent les droits d'auteur, les marques déposées et d'autres droits de propriété intellectuelle associés au contenu publié sur le site. L'utilisateur reconnaît et accepte que tout le contenu du site est protégé par des lois sur la propriété intellectuelle et ne peut être utilisé ou reproduit sans autorisation préalable. Toute utilisation non autorisée du contenu peut entraîner des poursuites judiciaires.</p>
                </div>
                <div class="tab_item tab_item_3" style="display: none;">
                  <h3>Activités interdites</h3>
                  <p>Cette section énumère les activités qui sont strictement interdites sur le site. Ces activités incluent, mais ne se limitent pas à, la fraude, le harcèlement, la diffusion de contenu illicite, la violation des droits d'auteur et tout comportement considéré comme contraire aux lois en vigueur. Le site se réserve le droit de prendre des mesures appropriées contre tout utilisateur qui se livre à de telles activités, y compris la suspension ou la résiliation de son compte.</p>

                </div>
                <div class="tab_item tab_item_4" style="display: none;">
                  <h3>Clause de résiliation</h3>
                  <p>La clause de résiliation énonce les conditions dans lesquelles le site peut résilier le compte d'un utilisateur. Ces conditions peuvent inclure le non-respect des conditions d'utilisation, le comportement inapproprié, la violation des lois ou toute autre activité contraire aux politiques du site. En cas de résiliation du compte, l'utilisateur peut perdre l'accès à certaines fonctionnalités du site et peut ne pas être autorisé à créer un nouveau compte sans autorisation préalable.</p>
                </div>
                <div class="tab_item tab_item_5" style="display: none;">
                  <h3>Loi applicable</h3>
                  <p>Cette section précise la loi applicable aux conditions d'utilisation du site. En acceptant ces conditions, l'utilisateur reconnaît que toute utilisation du site est soumise à la législation en vigueur dans le pays où le site est exploité. En cas de litige, les tribunaux compétents seront ceux du pays où le site est hébergé. L'utilisateur accepte de se conformer à ces lois et de respecter les décisions des tribunaux compétents.</p>
                </div>
              </div>
              <!-- <div class="tab_foot flex_align_justify">
                <button class="decline">
                    Refuser
                </button>
                <button class="agree">
                    Accepter
                </button>
            </div>
        </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
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

    //   function openTermsForm() {
    //     document.getElementById("termsForm").classList.toggle("active");
    // }
    // document.getElementById("contact").addEventListener("click", function() {
    //   var contactForm = document.getElementById("contactForm");
    //   contactForm.style.display = (contactForm.style.display === "none" ? "block" : "none");
    // });
    // document.getElementById("contact2").addEventListener("click", function() {
    //   var contactForm = document.getElementById("contactForm");
    //   contactForm.style.display = (contactForm.style.display === "none" ? "block" : "none");
    // });
    // document.getElementById("terms").addEventListener("click", function() {
    //   var termsForm = document.getElementById("termsForm");
    //   termsForm.style.display = (termsForm.style.display === "none" ? "block" : "none");
    // });
    //////////
    var tab_lists = document.querySelectorAll(".tabs_list ul li");
    var tab_items = document.querySelectorAll(".tab_item");

    tab_lists.forEach(function(list) {
      list.addEventListener("click", function() {
        var tab_data = list.getAttribute("data-tc");

        tab_lists.forEach(function(list) {
          list.classList.remove("active");
        });
        list.classList.add("active");

        tab_items.forEach(function(item) {
          var tab_class = item.getAttribute("class").split(" ");
          if (tab_class.includes(tab_data)) {
            item.style.display = "block";
          } else {
            item.style.display = "none";
          }

        })

      })
    })
    const text = `Explorez votre avenir scolaire et professionnel avec nous.`;

  

  const typingElement = document.querySelector('.typing');
  let i = 0;

  function typeWriter() {
    if (i < text.length) {
      typingElement.innerHTML += text.charAt(i);
      i++;
    } else {
      // Reset the index to start over
      i = 0;
      typingElement.innerHTML = ''; // Clear the content
    }
    setTimeout(typeWriter, 100);
  }

  // Start the typing effect qutori poindeur
  typeWriter();

 
  </script>

</body>

</html>