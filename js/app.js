const routes = {
    "": "pages/inicio.php",
    "../": "pages/inicio.php",
    "inicio": "pages/inicio.php",
    "nosotros": "pages/nosotros.php",
    "preguntas-frecuentes": "pages/preguntas-frecuentes.php",
    "consejo-ciudadano": "pages/consejo-ciudadano.php",
    "defensoria-de-las-audiencias": "pages/defensoria-de-las-audiencias.php",
    "derechos-de-la-audiencia": "pages/derechos-de-la-audiencia.php",
    "quejas-sugerencias": "pages/quejas-sugerencias.php",
    "transparencia": "pages/transparencia.php",
    "politica-de-privacidad": "pages/politica-de-privacidad.php",
    "programacion": "pages/programacion.php",
    "contenido": "pages/contenido.php",
    "programa": "pages/programa.php",
    "contacto": "pages/contacto.php",
    "documentos-consejo-ciudadano" : "pages/documentos-consejo-ciudadano.php", 
    "404": "pages/404.php"
};
// Single Page Application (SPA)!!!!
import { GetRelativePath, ToSeconds, FormatTime } from './utilities.js?v=33b427';
import { SetupPrograms } from './contenido.js?v=33b427';
import { slideTimeout, SetupSlideshow } from './slideshowManager.js?v=33b427';
// import { IsSticky } from './cal.js';
// Obtener todos los enlaces de navegación
// const navLinks = document.querySelectorAll('.nav-link');
const mainContent = document.getElementById('content');
const options = document.querySelector('.nav-links > ul');
const menuIcon = document.getElementById('menu-icon');
const navLinks = document.querySelector('.nav-links');
const searchBarContent = document.getElementsByClassName("search-bar-content")[0];
const boxSearch = document.getElementsByClassName("box-search")[0];

let request
let filePath
let displayedUrl = '';

let programsContainer;
let timeoutId;
let timeToUpdate = 0;

ExecuteBehavior(window.location.pathname.split('/').pop());

SetupInternalLinks();

function URLManager(){
    console.log("request: " + request);
    if(!request)
        return;

    let segments = request.split('/');

    if (request.startsWith("/"))
        displayedUrl = request.substring(1);
    else
        displayedUrl = request;

    console.log("displayedUrl: " + displayedUrl);

    filePath = routes[segments[1]];

    let formData = new FormData();
    formData.append('initPath', '../');
    formData.append('REQUEST_URI', request);
    return formData;
}

export function LinkBehavior(event){
    let isModifierKey = event.ctrlKey || event.altKey || event.shiftKey || event.metaKey;
    let isOpenInNewTab = event.currentTarget.getAttribute('target') === '_blank';

    // Evitar el comportamiento por defecto solo si no se presionan teclas modificadoras y no es un enlace que debe abrirse en nueva pestaña
    if (!isModifierKey && !isOpenInNewTab) {
        event.preventDefault(); // Evita la acción por defecto del enlace

        request = event.currentTarget.getAttribute('href'); // Obtener la URL del enlace
        

        let formData = URLManager();

        // Cargar contenido nuevo
        fetch(GetRelativePath() + filePath, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            AfterClick(data, displayedUrl);
            window.history.pushState({path: displayedUrl}, '', GetRelativePath() + displayedUrl);

        })
        .catch(error => console.error('Error al cargar el contenido:', error));
    }
}

// Manejar el historial del navegador (para usar el botón "Atrás" o "Adelante")
// 'popstate' Se dispara cuando el usuario navega hacia atrás o hacia adelante en el historial usando los botones del navegador, pero no ocurre cuando se carga una nueva página.
window.addEventListener('popstate', function(event) {
    request = window.location.pathname;
    // if (url.startsWith('/')) {
    //     url = url.slice(1);
    // }

    // displayedUrl = url;
    // // url = GetURLFile(url);
    // url = routes[url];

    let formData = URLManager();
    // formData.append('initPath', '../');
    // console.log(url);
    // Volver a cargar el contenido cuando se use "atrás" o "adelante"
    fetch(GetRelativePath() + filePath, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        AfterClick(data, displayedUrl);
    })
    .catch(error => console.error('Error al manejar popstate:', error));
});

function AfterClick(data, request){
    window.scrollTo(0, 0);

    searchBarContent.classList.remove('show-searchBar');
    boxSearch.classList.remove('show-boxSearch');
    menuIcon.classList.remove("change");
    navLinks.classList.remove("show-navlinks");
    options.classList.remove('show-options');

    document.getElementById("inputSearch").value = '';
    mainContent.innerHTML = data;
    SetupInternalLinks();
    ExecuteBehavior(request);
}

function ExecuteBehavior(request){
    clearTimeout(timeoutId);
    clearTimeout(slideTimeout);
    switch (request) {
        case 'contenido':
            SetupPrograms();     
            break;
        // case 'programacion':
        //     IsSticky();
        //     break;
        case '':
        case '../':
        case 'inicio':
            {
                programsContainer = document.querySelector('.next-programs-container');
                SetupTimetoUpdate();
                SetupSlideshow();
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

function SetupTimetoUpdate(){
    let formData = new FormData();
    formData.append('GetCurrProgram', '');
    fetch(GetRelativePath() + 'php/jsRequest.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        let horaFin = ToSeconds(data[1]['hora_fin']);
        if(horaFin === 0) horaFin = 86400;
        timeToUpdate = (horaFin - ToSeconds(data[0])) * 1000;
        timeoutId = setTimeout(UpdateProgramsInfo , timeToUpdate);
        console.log("miliseconds to update programs: " + timeToUpdate);
    })
    .catch(error => console.error('Error al cargar el contenido:', error));
}

function UpdateProgramsInfo(){
    // console.log("asdasd " + timeToUpdate);
    let formData = new FormData();
    formData.append('GetNextPrograms', '4');
    fetch(GetRelativePath() + 'php/jsRequest.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        while (programsContainer.firstChild) {
            programsContainer.removeChild(programsContainer.firstChild);
        }
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
            schedule.innerHTML = `<span>${FormatTime(program.hora_inicio)} - ${FormatTime(program.hora_fin)}</span>`;
        
            info.appendChild(name);
            info.appendChild(schedule);
        
            nextProgram.appendChild(img);
            nextProgram.appendChild(info);
                    
            programsContainer.appendChild(nextProgram);
        });

        let horaInicio = ToSeconds(data[1][0]['hora_inicio']);
        if(horaInicio === 0) horaInicio = 86400;
        timeToUpdate = (horaInicio - ToSeconds(data[0])) * 1000;
        timeoutId = setTimeout(UpdateProgramsInfo , timeToUpdate);
        console.log("miliseconds to update programs: " + timeToUpdate);
    })
    .catch(error => console.error('Error al cargar el contenido:', error));
}

window.addEventListener('focus', function() {
    clearTimeout(timeoutId);
    console.log('current url: ' + this.location.pathname);
    if(this.location.pathname === '/' || displayedUrl === "/inicio")
        UpdateProgramsInfo();
});