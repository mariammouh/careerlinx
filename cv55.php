<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cv55.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <title>Resume</title>
</head>
<style>
    /* Google Fonts  */
@import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');
/* font-family: 'Open Sans', sans-serif; */

@import url('https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
/* font-family: 'Public Sans', sans-serif; */

@import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');
/* font-family: 'Lato', sans-serif; */



*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

body{
    background-color: #EBECF0;
}
.photo-input{
border-radius: 30px;
}

.main-section{
    width: 210mm;
    height: 297mm;
    background-color: white;
    margin: 0 auto;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    display: flex;
}

.main-section .left-part{
    width: 40%;
    height: 100%;
    background-color: #F4F4F4;
    padding: 2.8rem;
}

.left-part .photo-container{
    margin-bottom: 2.2rem;
}

.left-part .photo-container img{
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 1rem solid white;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
}

.title{
    font-family: 'Public Sans', sans-serif;
    font-size: 1.4rem;
    text-transform: uppercase;
    padding: 0.6rem;
    background-color: #0C359E;
    color: white;
    text-align: center;
    margin: 1.4rem 0;
    border-radius: 10px;
}

.contact-container{
    margin-bottom: 2.2rem;
}

.contact-container .contact-list{
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    font-family: 'Lato', sans-serif;
    color: #444440;
    font-size: 1rem;
}

.education-container{
    margin-bottom: 2.2rem;
    font-family: 'Lato', sans-serif;
}

.education-container .course{
    margin-bottom: 1rem;
    color: #414042;
}
 
.education-container .education-title{
    font-size: 1rem;
    font-weight: 800;
    margin-bottom: .3rem;
}

.education-container .college-name{
    margin-bottom: 0.3rem;
    font-weight: 600;
    
}

.education-container .education-date{
    font-size: 0.9rem;
}

.skills-container .skill{
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.6rem;
    font-family: 'Lato', sans-serif;
}

.skills-container .skill .right-skill .outer-layer{
    background-color: #BBBBBB;
    height:0.4rem;
    width: 5rem;
    border-radius: 0.4rem;
}

.skills-container .skill .right-skill .inner-layer{
    background-color: #3D3D3D;
    height: 100%;
    border-radius: inherit;
}

.right-part{
    padding: 2.8rem;
}

.right-part .banner{
    font-family: 'Open Sans', sans-serif; 
    color: #4D4D4F;
    margin-bottom: 2.2rem;
}

.right-part .banner .firstname{
    font-size: 4rem;
}

.right-part .banner .lastname{
    font-size: 4rem;
    font-weight: 400;
    letter-spacing: 0.5rem;
    margin-top: -1rem;
}

.right-part .banner .position{
    letter-spacing: 0.3rem;
    margin-top: -0.5rem;
    font-size: 1.1rem;
}

.work-container{
    margin-top: 5rem;
    font-family: 'Lato', sans-serif;
}

.work-container .work:not(:last-child){
    margin-bottom: 1.8rem;
}

.work-container .work .job-date{
    display: flex;
    justify-content: space-between;
    color: #4D4D4F;
    margin-bottom: 0.5rem;
    font-size: 0.7rem;
    font-weight: 500;
}

.work-container .work .company-name{
    font-size: 0.9rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #4D4D4F;

}

.work-container .work .work-text{
    color: #737373;
    font-size: 0.8rem;
    text-align: justify;
    line-height: 1rem;
}

.references-container .references{
    display: flex;
    justify-content: space-between;
    margin-top: 1rem;
    font-family: 'Lato', sans-serif;
    color: #4D4D4F;
}

.references-container .references .name{
    font-weight: 800;
    font-size: 1.1rem;
}

.references-container .references .company-name{
    margin: 0.5rem 0;
    font-size: 0.9rem;
}

.references-container .references .phone{
    display: flex;
    justify-content: space-between;
    font-size: 0.7rem;
    color: #414042;
}
.references-container .references .phone p{
    margin: 0.4rem 0;
}

.references-container .references .phone .phone-text{
    font-weight: 600;
}

.text-left{
    text-align: left;
}

   .photo-container {
  position: relative;
  width: 200px; /* Ajustez la largeur du conteneur selon vos préférences */
  height: 200px; /* Ajustez la hauteur du conteneur selon vos préférences */
  border-radius: 50%; /* Rend le conteneur en forme de cercle */
  overflow: hidden; /* Assurez-vous que le contenu reste dans la forme du cercle */
}

#photo-input {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0; /* Rend le bouton de chargement de fichier invisible */
  z-index: 2; /* Place le bouton au-dessus de l'image et du label */
}

#photo-label {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 1; /* Place le label en dessous du bouton */
  cursor: pointer; /* Change le curseur lorsque survolé pour indiquer qu'il est cliquable */
}

#profile-photo {
  width: 100%; /* Ajuste la largeur de l'image pour remplir complètement le cercle */
  height: 100%; /* Ajuste la hauteur de l'image pour remplir complètement le cercle */
  object-fit: cover; /* Assurez-vous que l'image couvre complètement le conteneur du cercle */
  border-radius: 50%; /* Rend l'image en forme de cercle */
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

.delete-button {
    background-color: #ff6347; /* Couleur de fond rouge */
    color: #fff; /* Couleur du texte blanc */
    border: none;
    border-radius: 5px; /* Arrondir les coins */
    padding: 7px 15px; /* Ajouter un espacement intérieur */
    cursor: pointer;
    font-size: 12px; /* Taille de la police */
    transition: background-color 0.3s ease; /* Transition fluide lors du survol */
}

.delete-button:hover {
    background-color: #ff473d; /* Couleur de fond rouge plus foncée au survol */
}
.download-button-container {
    text-align: center; /* Alignement horizontal au centre */
}

@media print {
  .pdfButton {
    display: none;
  }
}
</style>

<body>
    <section class="main-section">
        <div class="left-part">
            <div class="photo-container">
                <input img="" type="file" id="photo-input" accept="image/*" onchange="loadPhoto(event)" >
                <img src="customer1.jpg" alt="" id="profile-photo">
            </div>
            <div class="contact-container">
                <h2 class="title" contenteditable="true">Contact Me</h2>
                <div class="contact-list">
                    <div class="icon-container">
                        <i class="bi bi-geo-alt-fill" ></i>
                       
                    </div>
                    <div class="contact-text">
                        <p contenteditable="true">123 Anywhere St., Any City, ST 12345</p>
                    </div>
                </div>
                <div class="contact-list">
                    <div class="icon-container">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <div class="contact-text">
                        <p contenteditable="true" >hello@reallygreatsite.com</p>
                    </div>
                </div>
                <div class="contact-list">
                    <div class="icon-container">
                        <i class="bi bi-laptop"></i>
                    </div>
                    <div class="contact-text">
                        <p contenteditable="true">www.reallygreatsite.com</p>
                    </div>
                </div>
                <div class="contact-list">
                    <div class="icon-container">
                        <i class="bi bi-linkedin"></i>
                    </div>
                    <div class="contact-text">
                        <p contenteditable="true">@reallygreatsite</p>
                    </div>
                </div>
            </div>

            <div class="education-container">
                <h2 class="title" contenteditable="true">Education</h2>
                <div class="course" id="education-1">
                    <button class="add-button exclude-from-pdf pdfButton" onclick="addContent('education-container')">Ajouter</button>
                      

                    <h2 class="education-title" contenteditable="true">Course Studied</h2>
                    <h5 class="college-name" contenteditable="true">University/College Details</h5>
                    <p class="education-date" contenteditable="true">2006 - 2008</p>
                </div>
            </div>

            <div class="skills-container">
                <h2 class="title" contenteditable="true">Skills</h2>
                <div class="skill">
                    <div class="left-skill">
                        <button class="add-button exclude-from-pdf pdfButton" onclick="addSkills('skills-container')">Ajouter</button>

                        <p contenteditable="true">Skill Name 01</p>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="right-part">
            <div class="banner">
                <h1 class="firstname" contenteditable="true">Mariana</h1>
                <h1 class="lastname" contenteditable="true">Anderson</h1>
                <p class="position" contenteditable="true">Marketing Manager</p>
            </div>

           

            <div class="profil-container ">
                <h2 class="title text-left" contenteditable="true">Profil</h2>

                <div class="profil" id="profil-1">
                   
                    <p class="profil-text" contenteditable="true">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Null


                        ipsum dolor sit amet, consectetur adipiscing elit. Nullam pharetra in
                        lorem
                        at laoreet. Donec hendrerit libero eget est tempor, quis tempus arcu elementum. In elementum
                        elit at
                        dui tristique feugiat. Mauris convallis, mi at mattis malesuada, neque nulla volutpat dolor,
                        hendrerit faucibus eros nibh ut nunc. Proin luctus urna i
                    </p>
                    </div>
    
                   
                    
                </div>


            <div class="work-container ">
                <h2 class="title text-left" contenteditable="true">work experience</h2>

                <div class="work" id="work-1">
                    <button class="add-button exclude-from-pdf pdfButton" onclick="addExperiance('work-container')">Ajouter</button>
                   
                    <div class="job-date">
                        <p class="job" contenteditable="true">Job position here</p>
                        <p class="date" contenteditable="true">2019 - 2022</p>
                    </div>
                    <h2 class="company-name" contenteditable="true">Company Name l Location</h2>
                    <p class="work-text" contenteditable="true">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Null


                        ipsum dolor sit amet, consectetur adipiscing elit. Nullam pharetra in
                        lorem
                        at laoreet. Donec hendrerit libero eget est tempor, quis tempus arcu elementum. In elementum
                        elit at
                        dui tristique feugiat. Mauris convallis, mi at mattis malesuada, neque nulla volutpat dolor,
                        hendrerit faucibus eros nibh ut nunc. Proin luctus urna i
                    </p>
                    </div>
    
                   
                    
                </div>
    
                
            </div>
        </section>
    

        <div class="download-button-container">
            <button id="pdfButton"  class="download-button pdfButton" onclick="window.print()">
               Telecherger PDF
            </button>
        </div>
        
        
<!-- Ajoutez cette ligne pour inclure la bibliothèque Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<!-- Ajoutez vos scripts jsPDF et html2pdf après la bibliothèque Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>


<script>
            function loadPhoto(event) {
                var reader = new FileReader();
                reader.onload = function () {
                    var output = document.getElementById('profile-photo');
                    output.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        
            function deleteSection(sectionId) {
                var element = document.querySelector("." + sectionId);
                if (element) {
                    element.parentNode.removeChild(element);
                }
            }
        
            function addContent(containerId) {
                // Obtenez la référence vers le conteneur
                var container = document.querySelector("." + containerId);
        
                // Créez un nouvel élément de cours (education-title, college-name, education-date, etc.)
                var newCourse = document.createElement("div");
                var uniqueClass = "education-" + Date.now(); // Créez une classe unique
                newCourse.className = "course " + uniqueClass;
                newCourse.innerHTML = `
                    <button class="add-button exclude-from-pdf pdfButton" onclick="addContent('${containerId}')">Ajouter</button>
                    <button class="delete-button exclude-from-pdf pdfButton" onclick="deleteSection('${uniqueClass}')">Supprimer</button>
                    <h2 class="education-title" contenteditable="true">Nouvelle Course</h2>
                    <h5 class="college-name" contenteditable="true">Détails de l'université/du collège</h5>
                    <p class="education-date" contenteditable="true">Date</p>
                `;
        
                // Ajoutez le nouvel élément à la fin du conteneur
                container.appendChild(newCourse);
            }

            function addExperiance(containerId) {
            var container = document.querySelector("." + containerId);

            var newContent = document.createElement("div");
            var uniqueClass = containerId + "-" + Date.now();
            newContent.className = "work " + uniqueClass;
            newContent.innerHTML = `
                <button class="add-button exclude-from-pdf pdfButton" onclick="addContent('${containerId}')">Ajouter</button>
                <button class="delete-button exclude-from-pdf pdfButton" onclick="deleteSection('${uniqueClass}')">Supprimer</button>
                <div class="job-date">
                    <p class="job" contenteditable="true">Job position here</p>
                    <p class="date" contenteditable="true">Date</p>
                </div>
                <h2 class="company-name" contenteditable="true">Company Name | Location</h2>
                <p class="work-text" contenteditable="true">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam pharetra in
                    lorem at laoreet. Donec hendrerit libero eget est tempor, quis tempus arcu elementum. In elementum
                    elit at dui tristique feugiat. Mauris convallis, mi at mattis malesuada, neque nulla volutpat dolor,
                    hendrerit faucibus eros nibh ut nunc. Proin luctus urna i
                </p>
            `;
            container.appendChild(newContent);
        }

        function addSkills(containerId) {
        var container = document.querySelector("." + containerId);

        var newSkill = document.createElement("div");
        var uniqueClass = containerId + "-" + Date.now();
        newSkill.className = "skill " + uniqueClass;
        newSkill.innerHTML = `
            <div class="left-skill">
                <p contenteditable="true">Nouvelle Compétence</p>
            </div>
            <div class="right-skill">
                
            </div>
            <button class="delete-button exclude-from-pdf pdfButton" onclick="deleteSection('${uniqueClass}')">Supprimer</button>
        `;

        container.appendChild(newSkill);
    }


    function downloadPDF() {
        var buttons = document.querySelectorAll('.add-button, .delete-button');
        buttons.forEach(function(button) {
            button.style.display = "none";
        });

        var pdfElement = document.querySelector(".main-section");

        var totalHeight = 0;
        pdfElement.querySelectorAll('.left-part > div, .right-part > div').forEach(function(section) {
            totalHeight += section.offsetHeight;
        });

        pdfElement.style.height = totalHeight + "px";

        var options = {
            margin: 10,
            filename: 'resume.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
            excludeElements: (element) => element.classList.contains('exclude-from-pdf') || element.classList.contains('add-button') || element.classList.contains('delete-button'),
        };

        html2pdf(pdfElement, options).from(pdfElement).save().then(() => {
            pdfElement.style.height = "";
            buttons.forEach(function(button) {
                button.style.display = "";
            });
        });
    }
</script>
</body>
</html>