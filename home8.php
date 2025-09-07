<!doctype html>
<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "careerlinx";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["envoyerMessage"]) && !empty($_POST["envoyerMessage"])) {
        echo '<script>alert("CareerLinx says : pls work");</script>';

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
        }
    }
}
function nombreTotalEcole()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS count FROM écoles_universités";
    $result = $conn->query($sql);
    $count = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    }
    return $count;
}
function nombreTotalEse()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS count FROM entreprise";
    $result = $conn->query($sql);
    $count = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    }
    return $count;
}
function nombreTotalEtud()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS count FROM etudiant";
    $result = $conn->query($sql);
    $count = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    }
    return $count;
}
function nombreTotalCon()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS count FROM concours_entretiens";
    $result = $conn->query($sql);
    $count = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    }
    return $count;
}
?>
<!--
	Solution by GetTemplates.co
	URL: https://gettemplates.co
-->
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- awesone fonts css-->
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
    <!-- owl carousel css-->
    <link rel="stylesheet" href="owl-carousel/assets/owl.carousel.min.css" type="text/css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <title>CareerLinx</title>
    <style>
        .part {
            display: inline-flex;
            padding: 0;

        }

        .part img {
            width: 300px;
            height: 300px;
        }

        .part button {
            background-color: transparent;
            height: inherit;
        }

        .form-container {
            display: inline-flex;
            height: 500px;
            padding: 50px;
        }

        .form-container h1 {
            text-align: center;
            margin-left: 50px;
        }

        a::after {
            border-color: none;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light bg-transparent" id="gtco-main-nav">
        <div class="container"><a class="navbar-brand"><img src="logo.jpeg" height="80px" width="80px"> Careerlinx</a>
            <button class="navbar-toggler" data-target="#my-nav" onclick="myFunction(this)" data-toggle="collapse"><span class="bar1"></span> <span class="bar2"></span> <span class="bar3"></span></button>
            <div id="my-nav" class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">à propos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#news">Nouvelles</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>

                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <a href="signin.php" class="btn btn-outline-dark my-2 my-sm-0 mr-3 text-uppercase">se connecter</a> <a href="#" onclick="openForm('inscrir', event)" class="btn btn-info my-2 my-sm-0 text-uppercase">inscrire</a>
                </form>
            </div>
        </div>
    </nav>
    <div class="container-fluid gtco-banner-area">
        <div class="container">
            <div class="row">
                <div class="col-md-6" style="margin-top:0%; ">
                    <h1> Bienvennue sur <span>CareerLinx</span> Explorez votre avenir scolaire et professionnel avec nous. </h1>
                    <p> Nous vous accompagnons dans votre parcours pour trouver l'école et la carrière de vos rêves, tout en mettant en avant les établissements et entreprises partenaires. Ensemble, construisons un avenir prometteur ! </p>

                    <button class="cssbuttons-io-button" aria-hidden="true" onclick='window.location.href ="signin.php";'>
                        Commencez
                        <div class="icon">
                            <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                            </svg>
                        </div>
                    </button>

                </div>
                <div class="col-md-6">
                    <div class="card"><img class="card-img-top img-fluid" src="images/banner-img.png" alt=""></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid gtco-feature" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="cover">
                        <div class="card">
                            <svg class="back-bg" width="100%" viewBox="0 0 900 700" style="position:absolute; z-index: -1">
                                <defs>
                                    <linearGradient id="PSgrad_01" x1="64.279%" x2="0%" y1="76.604%" y2="0%">
                                        <stop offset="0%" stop-color="rgb(1,230,248)" stop-opacity="1" />
                                        <stop offset="100%" stop-color="rgb(29,62,222)" stop-opacity="1" />
                                    </linearGradient>
                                </defs>
                                <path fill-rule="evenodd" opacity="0.102" fill="url(#PSgrad_01)" d="M616.656,2.494 L89.351,98.948 C19.867,111.658 -16.508,176.639 7.408,240.130 L122.755,546.348 C141.761,596.806 203.597,623.407 259.843,609.597 L697.535,502.126 C748.221,489.680 783.967,441.432 777.751,392.742 L739.837,95.775 C732.096,35.145 677.715,-8.675 616.656,2.494 Z" />
                            </svg>
                            <!-- *************-->

                            <svg width="100%" viewBox="0 0 700 500">
                                <clipPath id="clip-path">
                                    <path d="M89.479,0.180 L512.635,25.932 C568.395,29.326 603.115,76.927 590.357,129.078 L528.827,380.603 C518.688,422.048 472.661,448.814 427.190,443.300 L73.350,400.391 C32.374,395.422 -0.267,360.907 -0.002,322.064 L1.609,85.154 C1.938,36.786 40.481,-2.801 89.479,0.180 Z"></path>
                                </clipPath>
                                <!-- xlink:href for modern browsers, src for IE8- -->
                                <image clip-path="url(#clip-path)" xlink:href="https://th.bing.com/th/id/R.13e4177418b704708a5cff420dd8869d?rik=p5Or3dppzO7SdA&riu=http%3a%2f%2fwww.newcambridgecollege.com%2fblog%2fwp-content%2fuploads%2f2016%2f01%2fIELTS.jpg&ehk=iWZoZuclDfmF86x%2bYgvX0dXrr80t5xxIG4hkzlsW7ZE%3d&risl=&pid=ImgRaw&r=0" width="100%" height="465" class="svg__image"></image>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <h2> Sur Notre Site, On Est Là Pour Aider Les Etudiants à Trouver Leur
                        Voie. </h2>
                    <p>Peu importe s'ils cherchent une formation, un métier, ou des
                        opportunités de carrière, on les guide à chaque étape. On comprend que
                        c'est un moment crucial, alors on met à leur disposition toutes les
                        infos et l'assistance dont ils ont besoin pour réaliser leurs rêves. </p>

                    <button class="cssbuttons-io-button" aria-hidden="true">
                        EN SAVOIR PLUS
                        <div class="icon">
                            <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                            </svg>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid gtco-feature" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="cover">
                        <div class="card">
                            <svg class="back-bg" width="100%" viewBox="0 0 900 700" style="position:absolute; z-index: -1">
                                <defs>
                                    <linearGradient id="PSgrad_01" x1="64.279%" x2="0%" y1="76.604%" y2="0%">
                                        <stop offset="0%" stop-color="rgb(1,230,248)" stop-opacity="1" />
                                        <stop offset="100%" stop-color="rgb(29,62,222)" stop-opacity="1" />
                                    </linearGradient>
                                </defs>
                                <path fill-rule="evenodd" opacity="0.102" fill="url(#PSgrad_01)" d="M616.656,2.494 L89.351,98.948 C19.867,111.658 -16.508,176.639 7.408,240.130 L122.755,546.348 C141.761,596.806 203.597,623.407 259.843,609.597 L697.535,502.126 C748.221,489.680 783.967,441.432 777.751,392.742 L739.837,95.775 C732.096,35.145 677.715,-8.675 616.656,2.494 Z" />
                            </svg>
                            <!-- *************-->

                            <svg width="100%" viewBox="0 0 700 500">
                                <clipPath id="clip-path">
                                    <path d="M89.479,0.180 L512.635,25.932 C568.395,29.326 603.115,76.927 590.357,129.078 L528.827,380.603 C518.688,422.048 472.661,448.814 427.190,443.300 L73.350,400.391 C32.374,395.422 -0.267,360.907 -0.002,322.064 L1.609,85.154 C1.938,36.786 40.481,-2.801 89.479,0.180 Z"></path>
                                </clipPath>
                                <!-- xlink:href for modern browsers, src for IE8- -->
                                <image clip-path="url(#clip-path)" xlink:href="images/universit.webp" width="100%" height="465" class="svg__image"></image>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <h2> Notre Site Aide Les Ecoles à Se Faire Connaître Et à Attirer De
                        Nouveaux Etudiants. </h2>
                    <p>Grâce à notre plateforme conviviale, les écoles
                        peuvent partager leurs programmes et leurs réussites, et discuter
                        directement avec les visiteurs. En résumé, nous offrons aux écoles une
                        vitrine moderne pour attirer l'attention des futurs élèves. </p>

                    <button class="cssbuttons-io-button" aria-hidden="true">
                        EN SAVOIR PLUS
                        <div class="icon">
                            <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                            </svg>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>




    <div class="container-fluid gtco-feature" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="cover">
                        <div class="card">
                            <svg class="back-bg" width="100%" viewBox="0 0 900 700" style="position:absolute; z-index: -1">
                                <defs>
                                    <linearGradient id="PSgrad_01" x1="64.279%" x2="0%" y1="76.604%" y2="0%">
                                        <stop offset="0%" stop-color="rgb(1,230,248)" stop-opacity="1" />
                                        <stop offset="100%" stop-color="rgb(29,62,222)" stop-opacity="1" />
                                    </linearGradient>
                                </defs>
                                <path fill-rule="evenodd" opacity="0.102" fill="url(#PSgrad_01)" d="M616.656,2.494 L89.351,98.948 C19.867,111.658 -16.508,176.639 7.408,240.130 L122.755,546.348 C141.761,596.806 203.597,623.407 259.843,609.597 L697.535,502.126 C748.221,489.680 783.967,441.432 777.751,392.742 L739.837,95.775 C732.096,35.145 677.715,-8.675 616.656,2.494 Z" />
                            </svg>
                            <!-- *************-->

                            <svg width="100%" viewBox="0 0 700 500">
                                <clipPath id="clip-path">
                                    <path d="M89.479,0.180 L512.635,25.932 C568.395,29.326 603.115,76.927 590.357,129.078 L528.827,380.603 C518.688,422.048 472.661,448.814 427.190,443.300 L73.350,400.391 C32.374,395.422 -0.267,360.907 -0.002,322.064 L1.609,85.154 C1.938,36.786 40.481,-2.801 89.479,0.180 Z"></path>
                                </clipPath>
                                <!-- xlink:href for modern browsers, src for IE8- -->
                                <image clip-path="url(#clip-path)" xlink:href="images/learn-img.jpg" width="100%" height="465" class="svg__image"></image>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <h2> Notre Site Aide Les Entreprises à Trouver De Futurs Employés Et
                        Formateurs Tout En Renforçant Leur Visibilité. </h2>
                    <p>Grâce à notre
                        plateforme en ligne, les entreprises peuvent publier des offres
                        d'emploi, présenter leur culture d'entreprise, et dialoguer
                        directement avec les candidats potentiels. En bref, nous offrons aux
                        entreprises un moyen efficace de recruter de nouveaux talents et de
                        renforcer leur image de marque. </p>

                    <button class="cssbuttons-io-button" aria-hidden="true">
                        EN SAVOIR PLUS
                        <div class="icon">
                            <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                            </svg>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>











    <div class="container-fluid gtco-features" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h2> Découvrez Les Servicess <br />
                        Que Nous Vous Proposons. </h2>

                    <a href="">Inscrire <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
                <div class="col-lg-8">
                    <svg id="bg-services" width="100%" viewBox="0 0 1000 800">
                        <defs>
                            <linearGradient id="PSgrad_02" x1="64.279%" x2="0%" y1="76.604%" y2="0%">
                                <stop offset="0%" stop-color="rgb(1,230,248)" stop-opacity="1" />
                                <stop offset="100%" stop-color="rgb(29,62,222)" stop-opacity="1" />
                            </linearGradient>
                        </defs>
                        <path fill-rule="evenodd" opacity="0.102" fill="url(#PSgrad_02)" d="M801.878,3.146 L116.381,128.537 C26.052,145.060 -21.235,229.535 9.856,312.073 L159.806,710.157 C184.515,775.753 264.901,810.334 338.020,792.380 L907.021,652.668 C972.912,636.489 1019.383,573.766 1011.301,510.470 L962.013,124.412 C951.950,45.594 881.254,-11.373 801.878,3.146 Z" />
                    </svg>
                    <div class="row">
                        <div class="col">
                            <div class="card text-center">
                                <div class="oval"><img class="card-img-top" src="images/web-design.png" alt=""></div>
                                <div class="card-body">
                                    <h3 class="card-title">Publication D'offres D'emploi </h3>

                                </div>
                            </div>
                            <div class="card text-center">
                                <div class="oval"><img class="card-img-top" src="images/marketing.png" alt=""></div>
                                <div class="card-body">
                                    <h3 class="card-title">Facilitation des Admissions</h3>

                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card text-center">
                                <div class="oval"><img class="card-img-top" src="images/seo.png" alt=""></div>
                                <div class="card-body">
                                    <h3 class="card-title">Présentation Programmes Académiques</h3>

                                </div>
                            </div>
                            <div class="card text-center">
                                <div class="oval"><img class="card-img-top" src="images/graphics-design.png" alt=""></div>
                                <div class="card-body">
                                    <h3 class="card-title">Orientation Complète</h3>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid gtco-numbers-block">
        <div class="container">
            <svg width="100%" viewBox="0 0 1600 400">
                <defs>
                    <linearGradient id="PSgrad_03" x1="80.279%" x2="0%" y2="0%">
                        <stop offset="0%" stop-color="rgb(1,230,248)" stop-opacity="1" />
                        <stop offset="100%" stop-color="rgb(29,62,222)" stop-opacity="1" />

                    </linearGradient>

                </defs>
                <!-- <clipPath id="clip-path3">

                                      </clipPath> -->

                <path fill-rule="evenodd" fill="url(#PSgrad_03)" d="M98.891,386.002 L1527.942,380.805 C1581.806,380.610 1599.093,335.367 1570.005,284.353 L1480.254,126.948 C1458.704,89.153 1408.314,59.820 1366.025,57.550 L298.504,0.261 C238.784,-2.944 166.619,25.419 138.312,70.265 L16.944,262.546 C-24.214,327.750 12.103,386.317 98.891,386.002 Z"></path>

                <clipPath id="ctm" fill="none">
                    <path d="M98.891,386.002 L1527.942,380.805 C1581.806,380.610 1599.093,335.367 1570.005,284.353 L1480.254,126.948 C1458.704,89.153 1408.314,59.820 1366.025,57.550 L298.504,0.261 C238.784,-2.944 166.619,25.419 138.312,70.265 L16.944,262.546 C-24.214,327.750 12.103,386.317 98.891,386.002 Z"></path>
                </clipPath>

                <!-- xlink:href for modern browsers, src for IE8- -->
                <image clip-path="url(#ctm)" xlink:href="images/word-map.png" height="800px" width="100%" class="svg__image">

                </image>

            </svg>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo nombreTotalEtud();  ?></h5>
                            <p class="card-text">Nombre d'étudiants utilisant notre plateforme</p>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo nombreTotalCon();  ?></h5>
                            <p class="card-text">Nombre de concours que nous gérons</p>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo nombreTotalEcole();  ?></h5>
                            <p class="card-text">Nombre d'écoles partenaires sur notre plateforme.</p>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo nombreTotalEse();  ?></h5>
                            <p class="card-text">Nombre d'entreprises partenaires sur notre plateforme</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid gtco-testimonials">
        <div class="container">
            <h2>Rencontrez Les Esprits Créatifs Qui Donnent Vie à Notre Site !</h2>
            <div class="owl-carousel owl-carousel1 owl-theme">
                <div>
                    <div class="card text-center "><img class="card-img-top" src="images/customer2.jpg" alt="">
                        <div class="card-body">
                            <h5>Hicham EL MOUBTAHIJ<br />
                                <span> Encadrant d'equipe </span>
                            </h5>
                            <p class="card-text"> </p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card text-center"><img class="card-img-top" src="nadia.jpeg" alt="">
                        <div class="card-body">
                            <h5>Nadia Boukhali <br />
                                <span> Membre d'équipe </span>
                            </h5>
                            <p class="card-text"></p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card text-center">
                        <img class="card-img-top" src="mari.png" alt="" sizes="30%">
                        <div class="card-body">
                            <h5>Mariam Mouh<br />
                                <span> Membre d'équipe </span>
                            </h5>
                            <p class="card-text"> </p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card text-center"><img class="card-img-top" src="salam.png" alt="">
                        <div class="card-body">
                            <h5>Salma Chlih<br />
                                <span> Membre d'équipe </span>
                            </h5>
                            <p class="card-text"> </p>
                        </div>
                    </div>
                </div>
                <div>

                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid gtco-news" id="news">
        <div class="container">
            <h2>Notre platforme offre </h2>
            <div class="owl-carousel owl-carousel2 owl-theme">
                <div>
                    <div class="card text-center"><img class="card-img-top" src="images/resume.webp" alt="">
                        <div class="card-body text-left pr-0 pl-0">
                            <h5>Création de CV Professionnel avec
                                de Gestion Optimisée des Inscriptions. </h5>
                            <p class="card-text">Optimisez votre CV avec nos créations personnalisées et simplifiez les inscriptions scolaires pour une transition académique fluide. </p>
                            <a href="#">EN SAVOIR PLUS <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card text-center"><img class="card-img-top" src="images/quiz11.jpg" alt="">
                        <div class="card-body text-left pr-0 pl-0">
                            <h5> Préparation Gagnante :<br>
                                Quiz de Concours
                                pour Exceller.
                            </h5>
                            <br>
                            <p class="card-text">Maximisez vos chances de réussite avec nos quiz de concours, l'approche simplifiée et efficace qui vous prépare à exceller sans complication. </p>
                            <a href="#">EN SAVOIR PLUS <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card text-center"><img class="card-img-top" src="images/entretien2.jpeg" alt="">
                        <div class="card-body text-left pr-0 pl-0">
                            <h5>Maîtriser les Entretiens : Un Guide Pratique pour les Étudiants Ambitieux. </h5>
                            <p class="card-text">Dominez les entretiens avec confiance grâce à notre guide pratique, parfaitement adapté aux étudiants ambitieux aspirant à une réussite professionnelle.</p>
                            <a href="#">EN SAVOIR PLUS <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
    <footer class="container-fluid" id="gtco-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6" id="contact">
                    <form action="home.php" method="post">
                        <h4> Contactez-nous </h4>
                        <input type="text" class="form-control" name="nom" placeholder="Nom et prénom">
                        <input type="email" class="form-control" name="email" placeholder="Adresse e-mail">
                        <textarea class="form-control" name="envoyerMessage" placeholder="Message"></textarea>
                        <button class="cssbuttons-io-button" type="submit" name="envoyerMessage">
                            Envoyer
                            <div class="icon">
                                <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                                </svg>
                            </div>
                        </button>
                    </form>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-6">
                            <h4>Navigation</h4>
                            <ul class="nav flex-column company-nav">

                                <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">À propos</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Nouvelles</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                                <li class="nav-item"><a class="nav-link" href="#" onclick="openForm('termsForm', event)">Conditions</a></li>
                            </ul>
                            <h4 class="mt-5">Suivez-nous</h4>
                            <ul class="nav follow-us-nav">
                                <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-facebook" aria-hidden="true"></i> CareerLinx.ma</a></li><br>
                                <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-twitter" aria-hidden="true"></i> Careerlinx.ma</a></li><br>
                                <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-google" aria-hidden="true"></i> CareerLinx.ma </a></li><br>
                                <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-linkedin" aria-hidden="true"></i> Careerlinx.ma</a></li><br>
                            </ul>
                        </div>
                        <div class="col-6">
                            <h4>Services</h4>
                            <ul class="nav flex-column services-nav">
                                <li class="nav-item"><a class="nav-link" href="#">Publication D'offres D'emploi</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Orientation Complète</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Présentation Programmes Académiques</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Facilitation des Admissions</a></li>

                            </ul>

                            <h4 class="mt-5">Bureau</h4>
                            <ul class="nav follow-us-nav">
                                <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-envelope"></i> contact@CreerLinx.ma</a></li>
                                <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-map"></i> City Dakhla , Agadir</a></li>
                                <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-phone"></i> +212 6 20 88 32 14</a></li>
                            </ul>



                        </div>

                        <div class="col-12">All Rights Reserved. Design by
                            <p>&copy; 2024. <a href="#" style=" text-decoration: none;" target="_blank">CareerLinx</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div id="overlay" class="overlay" onclick="closeForms()"></div>

    <div id="inscrir" class="form-popup">
        <span class="close" onclick="closeForm('inscrir')">&times;</span>
        <h1 style="  margin-left: 400px;">Inscrire comme :</h1>
        <div class="form-container">
            <div class="part">
                <a href="signupetu.php">
                    <button class="button button-primary">
                        <img src="diplome (3).png" alt="" class="button-icon">
                        <span style="  font-size: 30px;">Etudiant </span>

                    </button>

                </a>
            </div>

            <div class="part">
                <a href="signupecole.php">
                    <button class="button button-primary">
                        <img src="eco.png" alt="" class="button-icon" style="width: 350px;">
                        <span style=" font-size: 30px;">Ecole </span>
                    </button>
                </a>
            </div>

            <div class="part">
                <a href="signupese.php">
                    <button class="button button-primary">
                        <img src="icon.jpg" alt="" class="button-icon">
                        <span style="font-size: 30px;">Entreprise </span>

                    </button>
                </a>
            </div>
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
                            <h3>Conditions Générales d'Utilisation</h3>
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
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- owl carousel js-->
    <script src="owl-carousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>