const routes = {
    "": "pages/inicio.php",
    "./": "pages/inicio.php",
    "inicio": "pages/inicio.php",
    "nosotros": "pages/nosotros.html",
    "preguntas-frecuentes": "pages/preguntas-frecuentes.html",
    "consejo-ciudadano": "pages/consejo-ciudadano.html",
    "defensoria-de-las-audiencias": "pages/defensoria-de-las-audiencias.html",
    "derechos-de-la-audiencia": "pages/derechos-de-la-audiencia.html",
    "quejas-sugerencias": "pages/quejas-sugerencias.html",
    "transparencia": "pages/transparencia.html",
    "politica-de-privacidad": "pages/politica-de-privacidad.html",
    "programacion": "php/programacion.php",
    "contenido": "pages/contenido.html",
    "contacto": "pages/contacto.html",
    "404": "pages/404.html"
};

// Single Page Application (SPA)!!!!
import { ToSeconds } from './utilities.js';
import { ShowPrograms } from './contenido.js';
// import { IsSticky } from './cal.js';
// Obtener todos los enlaces de navegación
// const navLinks = document.querySelectorAll('.nav-link');
const mainContent = document.getElementById('content');
const options = document.querySelector('.nav-links > ul');
const menuIcon = document.getElementById('menu-icon');
const navLinks = document.querySelector('.nav-links');
const boxSearch = document.getElementsByClassName("box-search")[0];
let programsContainer;
let timeoutId;
let timeToUpdate = 0;

ExecuteBehavior(window.location.pathname.split('/').pop());

SetupInternalLinks();

// Manejar el historial del navegador (para usar el botón "Atrás" o "Adelante")
// 'popstate' Se dispara cuando el usuario navega hacia atrás o hacia adelante en el historial usando los botones del navegador, pero no ocurre cuando se carga una nueva página.
window.addEventListener('popstate', function(event) {
    let url = window.location.pathname;
    if (url.startsWith('/')) {
        url = url.slice(1);
    }

    const displayedUrl = url;
    // url = GetURLFile(url);
    url = routes[url];

    let formData = new FormData();
    formData.append('initPath', '../');
    // console.log(url);
    // Volver a cargar el contenido cuando se use "atrás" o "adelante"
    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        AfterClick(data, displayedUrl.split('/').pop());
    })
    .catch(error => console.error('Error al manejar popstate:', error));
});

function AfterClick(data, request){
    window.scrollTo(0, 0);
    boxSearch.classList.remove('show-boxSearch')
    document.getElementById("inputSearch").value = '';
    mainContent.innerHTML = data;
    SetupInternalLinks();
    ExecuteBehavior(request);
}

function ExecuteBehavior(request){
    clearInterval(timeoutId);
    switch (request) {
        case 'contenido':
            ShowPrograms();       
            break;
        // case 'programacion':
        //     IsSticky();
        //     break;
        case '':
        case './':
        case 'inicio':
            {
                programsContainer = document.querySelector('.next-programs-container');
                SetupTimetoUpdate();
                // timeoutId = setInterval(() => {UpdateProgramsInfo(programsContainer)} , 5000);
                // console.log("inicioooooo");
                break;
            }
        default:
            break;
    }
}

function GetURLFile(url){
    fetch('internal_links.json')
    .then(response => response.json())
    .then(data => {
        resolve(data[url]);
    })
    .catch(error => {
        console.error('Error al cargar routes.json', error);
        reject(error);
    });
}

menuIcon.addEventListener('click', function(e){
    menuIcon.classList.toggle("change");
    navLinks.classList.toggle("show-navlinks");
    options.classList.toggle('show-options');
});

window.addEventListener('click', function(e){
    const element = e.target;
    if(element === navLinks || (element.classList.contains('nav-link') && !element.classList.contains('arrow-down'))){
        menuIcon.classList.remove("change");
        navLinks.classList.remove("show-navlinks");
        options.classList.remove('show-options');
    }
});

function SetupInternalLinks(){
    const navLink = document.querySelectorAll('.internal-link');
    navLink.forEach(link => {
        link.onclick = (e) => {LinkBehavior(e)};
    });
}

function LinkBehavior(event){
    event.preventDefault(); // Evita la acción por defecto del enlace

    let url = event.currentTarget.getAttribute('href'); // Obtener la URL del enlace
    console.log(url);
    if(!url)
        return;

    const displayedUrl = url;

    url = routes[url];

    // url = GetURLFile(url);
    // console.log(url);
    let formData = new FormData();
    formData.append('initPath', '../');

    // Cargar contenido nuevo
    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Suponiendo que tienes un div con el ID 'content' para cargar el nuevo contenido
        AfterClick(data, displayedUrl);
        // window.scrollTo(0, 0);
        // boxSearch.classList.remove('show-boxSearch')
        // document.getElementById("inputSearch").value = '';
        // mainContent.innerHTML = data;
        // SetupInternalLinks();
        // ExecuteBehavior(displayedUrl);

        // Actualizar la URL sin recargar
        window.history.pushState({path: displayedUrl}, '', displayedUrl);

    })
    .catch(error => console.error('Error al cargar el contenido:', error));
}

// function myFunction(x) {
//     x.classList.toggle("change");
// } 

// window.addEventListener('beforeunload', function (event) {
//     // Puedes mostrar un mensaje personalizado, pero la mayoría de los navegadores no lo mostrarán.
//     const confirmationMessage = '¿Estás seguro de que deseas salir?';
    
//     // Establecer el mensaje de confirmación
//     event.returnValue = confirmationMessage; // Esto es necesario para algunos navegadores
//     return confirmationMessage; // Algunos navegadores mostrarán este mensaje
// });

// SetupTimetoUpdate();

function SetupTimetoUpdate(){
    let formData = new FormData();
    formData.append('GetCurrProgram', '');
    fetch('php/jsRequest.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        timeToUpdate = (ToSeconds(data[1]['hora_fin']) - ToSeconds(data[0])) * 1000;
        timeoutId = setTimeout(UpdateProgramsInfo , timeToUpdate);
        console.log("miliseconds to update programs: " + timeToUpdate);
    })
    .catch(error => console.error('Error al cargar el contenido:', error));
}

// function UpdateProgramsInfo(programsContainer){
//     // console.log(intervalId);
//     // let formData = new FormData();
//     // formData.append('initPath', '../');
//     fetch('php/programs_info.php')
//     .then(response => response.text())
//     .then(data => {
//         programsContainer.innerHTML = data;
//     })
//     .catch(error => console.error('Error al cargar el contenido:', error));
// }

function UpdateProgramsInfo(){
    // console.log("asdasd " + timeToUpdate);
    let formData = new FormData();
    formData.append('GetNextPrograms', '4');
    fetch('php/jsRequest.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        data[1].forEach(program => {
            let nextProgram = document.createElement('div');
            nextProgram.classList.add('next-program');
        
            let img = document.createElement('img');
            img.src = program.url_img + '.300';
            img.alt = 'logo_programa';
        
            let info = document.createElement('div');
            info.classList.add('info');
        
            let name = document.createElement('div');
            name.classList.add('name');
            name.innerHTML = `<span>${program.nombre_programa}</span>`;
        
            let schedule = document.createElement('div');
            schedule.classList.add('schedule');
            schedule.innerHTML = `<span>${program.hora_inicio} - ${program.hora_fin}</span>`;
        
            info.appendChild(name);
            info.appendChild(schedule);
        
            nextProgram.appendChild(img);
            nextProgram.appendChild(info);
        
            programsContainer.appendChild(nextProgram);
        });

        timeToUpdate = (ToSeconds(data[1][0]['hora_inicio']) - ToSeconds(data[0])) * 1000;
        timeoutId = setTimeout(UpdateProgramsInfo , timeToUpdate);
        console.log("miliseconds to update programs: " + timeToUpdate);
    })
    .catch(error => console.error('Error al cargar el contenido:', error));
}