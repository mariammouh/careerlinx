<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>

*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    list-style: none;
    font-family: 'Nunito', sans-serif;
}

body{
    background-color: whitesmoke;
}

.main-content{
    min-height: 100vh;
    width: 70%;
    margin: 2rem auto;
    display: grid;
    grid-template-columns: repeat(7, 1fr);
}

.left-section{
    grid-column: span 2;
    height: 100%;
    background-color: #00324A;
}
.right-section{
    grid-column: span 5;
    background-color: #f7f7f7;
    height: 100%;
}


.left-content{
    padding: 2rem 3rem;
}
.profile{
    width: 100%;
    border-bottom: 1px solid #002333;
}

.image{
    width: 100%;
    text-align: center;
}
.profile img{
    width: 100%;
    border-radius: 50%;
    border: 8px solid #002333;
    
}

.name{
    font-size: 1.8rem;
    color: white;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 1.2rem 0;
}

.career{
    font-size: 1.2rem;
    color: #94D9EA;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding-bottom: 1rem;
}

.main-title{
    font-size: 1.8rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #f7f7f7ec;
    padding-top: 3rem;
}

.contact-info ul{
    padding-top: 2rem;
}

.contact-info ul li{
    padding: .4rem 0;
    display: flex;
    align-items: center;
    color: #718096;
}
.contact-info ul li i{
    padding-right: 1rem;
    font-size: 1.2rem;
    color: #2D9CDB;
}

.skills-section ul{
    padding-top: 2rem;
}
.skills-section ul li{
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    padding: .4rem 0;
}

.progress-bar{
    width: 100%;
    height: .4rem;
    background-color: #2f81ed5b;
    position: relative;
    border-radius: 12px;
}
.progress{
    height: 50%;
    position: absolute;
    left: 0;
    background-color: #2D9CDB;
    border-radius: 12px;
}


.skill-title{
    text-transform: uppercase;
    color: #f7f7f7;
    font-size: 1rem;
}

.sub-title{
    padding-top: 2rem;
    font-size: 1.2rem;
    text-transform: uppercase;
    color: #f7f7f7;
}

.sub-para{
    color: #ccc;
    padding: .4rem 0;
}

.references-section li{
    color: #ccc;
    padding: .2rem 0;
}
.references-section li i{
    padding-right: .5rem;
    font-size: 1.2rem;
    color: #2D9CDB;
}

.right-main-content{
    padding: 2rem 3rem;
}


.right-title{
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #2F80ED;
    margin-bottom: 1.2rem;
    position: relative;
}

.right-title::after{
    content: "";
    position: absolute;
    width: 60%;
    height: .2rem;
    background-color: #ccc;
    border-radius: 12px;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
}

.para{
    line-height: 1.6rem;
    color: #718096;
    font-size: 1.1rem;
}

.sect{
    padding-bottom: 2rem;
}

.timeline{
    display: grid;
    grid-template-columns: repeat(2, 1fr);
}

.tl-title{
    letter-spacing: 1px;
    font-size: 1.3rem;
    color: #002333;
    text-transform: uppercase;
}
.tl-title-2{
    letter-spacing: 1px;
    font-size: 1.3rem;
    color: #2D9CDB;
    text-transform: uppercase;
}

.tl-content{
    border-left: 1px solid #ccc;
    padding-left: 2rem;
    position: relative;
    padding-bottom: 2rem;
}

.tl-title-2::before{
    content: "";
    position: absolute;
    width: .7rem;
    height: .7rem;
    background-color: #2D9CDB;
    border-radius: 50%;
    transform: translateX(-50%);
    left: 0;
}

/*Media Querries*/
@media screen and (max-width:823px){
    .right-title::after{
        width: 40%;
    }
}
@media screen and (max-width:681px){
    .right-title::after{
        width: 30%;
    }
}
@media screen and (max-width:780px){
    .timeline{
        grid-template-columns: repeat(1, 1fr);
    }
}
@media screen and (max-width:780px){
    .left-section{
        grid-column: span 3;
    }
    .right-section{
        grid-column: span 4;
    }
}
@media screen and (max-width:1200px){
    .main-content{
        grid-template-columns: repeat(1, 1fr);
    }
    .profile img{
        width: 40%;
    }
}
@media screen and (max-width:700px){
    .profile img{
        width: 60%;
    }
}
@media screen and (max-width:390px){
    .name{
        font-size: 1.5rem;
    }
}

    .add-experience-btn {
    background-color: #007bff; /* Couleur de fond */
    color: #fff; /* Couleur du texte */
    padding: 10px 20px; /* Remplissage */
    border: none; /* Pas de bordure */
    border-radius: 5px; /* Coins arrondis */
    cursor: pointer; /* Curseur pointer au survol */
    transition: background-color 0.3s; /* Transition pour l'animation */
}

.add-experience-btn:hover {
    background-color: #0056b3; /* Changement de couleur au survol */
}

/* Styles pour le bouton Supprimer */
.remove-experience-btn {
            background-color: #dc3545; /* Couleur de fond */
            color: #fff; /* Couleur du texte */
            padding: 5px 10px; /* Remplissage */
            border: none; /* Pas de bordure */
            border-radius: 5px; /* Coins arrondis */
            cursor: pointer; /* Curseur pointer au survol */
            transition: background-color 0.3s; /* Transition pour l'animation */
            font-size: 14px; /* Taille de la police */
            margin-left: 10px; /* Marge à gauche */
        }

        .remove-experience-btn:hover {
            background-color: #c82333; /* Changement de couleur au survol */
        }


        .add-education-btn {
    background-color: #28a745; /* Couleur de fond */
    color: #fff; /* Couleur du texte */
    padding: 10px 20px; /* Remplissage */
    border: none; /* Pas de bordure */
    border-radius: 5px; /* Coins arrondis */
    cursor: pointer; /* Curseur pointer au survol */
    transition: background-color 0.3s; /* Transition pour l'animation */
}

.add-education-btn:hover {
    background-color: #218838; /* Changement de couleur au survol */
}

.remove-education-btn {
    background-color: #dc3545; /* Couleur de fond */
    color: #fff; /* Couleur du texte */
    padding: 5px 10px; /* Remplissage */
    border: none; /* Pas de bordure */
    border-radius: 5px; /* Coins arrondis */
    cursor: pointer; /* Curseur pointer au survol */
    transition: background-color 0.3s; /* Transition pour l'animation */
    font-size: 14px; /* Taille de la police */
    margin-left: 10px; /* Marge à gauche */
}

.remove-education-btn:hover {
    background-color: #c82333; /* Changement de couleur au survol */
}
.add-skill-btn {
            background-color: #ffc107; /* Couleur de fond */
            color: #000; /* Couleur du texte */
            padding: 10px 20px; /* Remplissage */
            border: none; /* Pas de bordure */
            border-radius: 5px; /* Coins arrondis */
            cursor: pointer; /* Curseur pointer au survol */
            transition: background-color 0.3s; /* Transition pour l'animation */
            margin-top: 10px; /* Marge en haut */
        }

        .add-skill-btn:hover {
            background-color: #ffca28; /* Changement de couleur au survol */
        }

        .remove-skill-btn {
    background-color: #dc3545; /* Couleur de fond */
    color: #fff; /* Couleur du texte */
    padding: 5px 10px; /* Remplissage */
    border: none; /* Pas de bordure */
    border-radius: 5px; /* Coins arrondis */
    cursor: pointer; /* Curseur pointer au survol */
    transition: background-color 0.3s; /* Transition pour l'animation */
    font-size: 14px; /* Taille de la police */
    margin-left: 10px; /* Marge à gauche */
}

.remove-skill-btn:hover {
    background-color: #c82333; /* Changement de couleur au survol */
}

.add-language-btn {
    background-color: #17a2b8; /* Couleur de fond */
    color: #fff; /* Couleur du texte */
    padding: 10px 20px; /* Remplissage */
    border: none; /* Pas de bordure */
    border-radius: 5px; /* Coins arrondis */
    cursor: pointer; /* Curseur pointer au survol */
    transition: background-color 0.3s; /* Transition pour l'animation */
    margin-top: 10px; /* Marge en haut */
}

.add-language-btn:hover {
    background-color: #138496; /* Changement de couleur au survol */
}

.remove-language-btn {
    background-color: #dc3545; /* Couleur de fond */
    color: #fff; /* Couleur du texte */
    padding: 5px 10px; /* Remplissage */
    border: none; /* Pas de bordure */
    border-radius: 5px; /* Coins arrondis */
    cursor: pointer; /* Curseur pointer au survol */
    transition: background-color 0.3s; /* Transition pour l'animation */
    font-size: 14px; /* Taille de la police */
    margin-left: 10px; /* Marge à gauche */
}

.remove-language-btn:hover {
    background-color: #c82333; /* Changement de couleur au survol */
}

#download-pdf-btn {
    background-color: #28a745; /* Couleur de fond */
    color: #fff; /* Couleur du texte */
    padding: 10px 20px; /* Remplissage */
    border: none; /* Pas de bordure */
    border-radius: 5px; /* Coins arrondis */
    cursor: pointer; /* Curseur pointer au survol */
    transition: background-color 0.3s; /* Transition pour l'animation */
    margin-top: 20px; /* Marge en haut */
}

#download-pdf-btn:hover {
    background-color: #218838; /* Changement de couleur au survol */
}

button {
    background-color: #9BB0C1; /* Nouvelle couleur de fond */
    color: #fff; /* Nouvelle couleur du texte */
    border: none;
    border-radius: 5px; /* Arrondir les coins */
    padding: 7px 15px; /* Ajouter un espacement intérieur */
    cursor: pointer;
    font-size: 12px; /* Taille de la police */
    transition: background-color 0.3s ease; /* Transition fluide lors du survol */
}

button:hover {
    background-color: #607274; /* Nouvelle couleur de fond au survol */
}

@media print {

.pdfButton {
  display: none;
}
}

</style>
<body>
    <main class="main-content">
        <section class="left-section">
            <div class="left-content">
                <div class="profile">
                    <div class="photo-container">
                        <!-- Ajout de l'élément input pour la sélection du fichier -->
                        <input type="file" id="photo-input" style="display: none;" onchange="displaySelectedPhoto(event)">
                        <!-- L'image est maintenant associée à l'ouverture de la boîte de dialogue -->
                        <label for="photo-input">
                            <img src="avatar.jpg" alt="" id="profile-photo">
                        </label>
                    </div>
                    <h2 contenteditable="true" class="name">Lorem Dola Ipsum</h2>
                    <p contenteditable="true" class="career">Software Engineer</p>
                </div>
             
                <div class="contact-info">
                    <h3 contenteditable="true" class="main-title">Contact Info</h3>
                    <ul>
                        <li contenteditable="true">
                            <i class="fa fa-phone"></i>
                            07661892982
                        </li>
                        <li contenteditable="true">
                            <i  class="fa fa-fax"></i>
                            loremipsum@gmail.com
                        </li>
                        <li contenteditable="true">
                            <i class="fa fa-map-marker"></i>
                            37 Pramount St, London
                        </li>
                    </ul>
                </div>
              
               
                  
                <div class="languages-section">
                    <h3 contenteditable="true" class="main-title">Languages</h3>
                    <br>
                    <br>
                    <ul>
                        <li>
                            <p contenteditable="true" class="skill-title">Language 1</p>
                            
                        </li>   
                    </ul>
                </div>
                <button class="add-language-btn pdfButton" onclick="addLanguage()">Ajouter une langue</button>
                
            </div>
        </section>
       
        <section class="right-section">
            <div class="right-main-content">
                <section class="about sect">
                    <br>
                    <br>
                    <br>
                    <h2 contenteditable="true" class="right-title">About Me</h2>
                    <p contenteditable="true" class="para">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam molestias facilis ullam dolorum, reprehenderit dolorem accusantium sit quo 
                        dolore nostrum assumenda obcaecati animi commodi nobis labore exercitationem corporis esse eveniet optio laudantium molestiae maiores pariatur nisi cumque. 
                        
                    </p>
                </section>

                <section class="experince sect">
                    <br>
                    <br>
                    <br>
                    <h2 contenteditable="true" class="right-title">Experience</h2>
                    <div class="timeline">
                        <div class="left-tl-content">
                            <h5 contenteditable="true" class="tl-title">Microsoft</h5>
                            <p contenteditable="true" class="para">2017 - 2019</p>
                        </div>
                        <div class="right-tl-content">
                            <div class="tl-content">
                                <h5 contenteditable="true" class="tl-title-2">Junior Developer</h5>
                                <p contenteditable="true" class="para">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                                </p>
                            </div>
                        </div>
                    </div>
                    <button class="add-experience-btn pdfButton" onclick="addExperience()">Ajouter une expérience</button>
                </section>


                <section class="education sect">
                    <br>
                    <br>
                    <h2 contenteditable="true" class="right-title">education</h2>
                    <div class="timeline">
                        <div class="left-tl-content">
                            <h5 contenteditable="true" class="tl-title">Cheney School</h5>
                            <p contenteditable="true" class="para">2015 - 2016</p>
                        </div>
                        <div class="right-tl-content">
                            <div class="tl-content">
                                <h5 contenteditable="true" class="tl-title-2">Gcse's</h5>
                                <p contenteditable="true" class="para">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                                </p>
                            </div>
                        </div>
                    </div>
                    <button class="add-education-btn pdfButton" onclick="addEducation()">Ajouter une éducation</button>
                </section>
              
                <section class="education sect">
                <div class="skills-section">
                    <h3 contenteditable="true"  class="right-title" style="font-size: 25px;">Skills</h3>
                    <ul>
                        <li>
                            <p contenteditable="true" class="para" >Javascript</p>
                            
                        </li>
                     
                    </ul>
                    <button class="add-skill-btn pdfButton" onclick="addSkill()">Ajouter une compétence</button>

                </div>
                </section>
            </div>
        </section>
    </main>

    <div class="download-button-container">
        <button id="pdfButton"  class="download-button pdfButton" onclick="window.print()">
           Telecherger PDF
        </button>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

    <script>

// Modifiez la fonction downloadPDF pour masquer les boutons avant de générer le PDF
function downloadPDF() {
    // Sélectionnez les boutons à masquer
    const buttonsToHide = document.querySelectorAll('.hide-in-pdf');

    // Masquez les boutons
    buttonsToHide.forEach(button => {
        button.style.display = 'none';
    });

    // Sélectionnez l'élément contenant le contenu principal du CV
    const element = document.querySelector('.main-content');

    // Générez le PDF
    html2pdf()
        .from(element)
        .save('mon_cv.pdf')
        .then(() => {
            // Réaffichez les boutons après la génération du PDF (facultatif)
            buttonsToHide.forEach(button => {
                button.style.display = 'block';
            });
        });
}





function displaySelectedPhoto(event) {
    // Récupérer l'élément img
    var imgElement = document.getElementById('profile-photo');
    // Récupérer le fichier sélectionné par l'utilisateur
    var selectedFile = event.target.files[0];
    // Créer un objet URL pour le fichier sélectionné
    var objectURL = URL.createObjectURL(selectedFile);
    // Afficher l'image sélectionnée dans l'élément img
    imgElement.src = objectURL;
}


        function addExperience() {
            var experienceSection = document.querySelector('.experince');

            var newTimeline = document.createElement('div');
            newTimeline.classList.add('timeline');

            newTimeline.innerHTML = `
                <div class="left-tl-content">
                    <h5 contenteditable="true" class="tl-title">Nouvelle entreprise</h5>
                    <p contenteditable="true" class="para">Date</p>
                </div>
                <div class="right-tl-content">
                    <div class="tl-content">
                        <h5 contenteditable="true" class="tl-title-2">Poste</h5>
                        <p contenteditable="true" class="para">
                            Description de l'expérience
                        </p>
                    </div>
                    <button class="remove-experience-btn pdfButton" onclick="removeExperience(this)">Supprimer</button>
                </div>
            `;

            experienceSection.insertBefore(newTimeline, experienceSection.lastElementChild);
        }

        function removeExperience(button) {
            var experience = button.parentElement.parentElement;
            experience.remove();
        }

        function addEducation() {
    var educationSection = document.querySelector('.education');

    var newTimeline = document.createElement('div');
    newTimeline.classList.add('timeline');

    newTimeline.innerHTML = `
        <div class="left-tl-content">
            <h5 contenteditable="true" class="tl-title">Nouvelle école/université</h5>
            <p contenteditable="true" class="para">Année de début - Année de fin</p>
        </div>
        <div class="right-tl-content">
            <div class="tl-content">
                <h5 contenteditable="true" class="tl-title-2">Spécialisation</h5>
                <p contenteditable="true" class="para">
                    Description de la spécialisation
                </p>
            </div>
            <button class="remove-education-btn pdfButton" onclick="removeEducation(this)">Supprimer</button>
        </div>
    `;

    educationSection.appendChild(newTimeline);
}

function removeEducation(button) {
    var education = button.parentElement.parentElement;
    education.remove();
}


function addSkill() {
    var skillsSection = document.querySelector('.skills-section');

    var newSkill = document.createElement('li');
    newSkill.innerHTML = `
        <p contenteditable="true" class="para">Nouvelle compétence</p>
        <button class="remove-skill-btn pdfButton" onclick="removeSkill(this)" style="width:100px;">Supprimer</button>
    `;

    skillsSection.querySelector('ul').appendChild(newSkill);
}
function removeSkill(button) {
    var skill = button.parentElement;
    skill.remove();
}

function addLanguage() {
    var languagesSection = document.querySelector('.languages-section');

    var newLanguage = document.createElement('li');
    newLanguage.innerHTML = `
        <div class="language-container">
            <p contenteditable="true" class="language-title" style="color : #fff; ">NOUVELLE LANGUE</p>
            <button class="remove-language-btn pdfButton" onclick="removeLanguage(this)">Supprimer</button>
        </div>
    `;

    languagesSection.querySelector('ul').appendChild(newLanguage);
}

    function removeLanguage(button) {
        var language = button.parentElement;
        language.remove();
    }

    </script>
</body>
</html>