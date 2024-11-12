// Single Page Application (SPA)!!!!
import { ShowPrograms } from './contenido.js';
import { IsSticky } from './cal.js';
// Obtener todos los enlaces de navegación
// const navLinks = document.querySelectorAll('.nav-link');
const mainContent = document.getElementById('content');
const options = document.querySelector('.nav-links > ul');
const menuIcon = document.getElementById('menu-icon');
const navLinks = document.querySelector('.nav-links');

ExecuteBehavior(window.location.pathname.split('/').pop());

// Agregar evento click a cada enlace de navegación
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault(); // Evita la acción por defecto del enlace

        let url = this.getAttribute('href'); // Obtener la URL del enlace

        if(!url)
            return;

        const displayedUrl = url;
        url = GetURLFile(url);
        // console.log(url);
        let formData = new FormData();
        formData.append('onlyContent', '1');

        // Cargar contenido nuevo
        fetch(url, {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                // Suponiendo que tienes un div con el ID 'content' para cargar el nuevo contenido
                mainContent.innerHTML = data;
                
                // Actualizar la URL sin recargar
                window.history.pushState({path: displayedUrl}, '', displayedUrl);

                ExecuteBehavior(displayedUrl);
            })
            .catch(error => console.error('Error al cargar el contenido:', error));
    });
});

// Manejar el historial del navegador (para usar el botón "Atrás" o "Adelante")
// 'popstate' Se dispara cuando el usuario navega hacia atrás o hacia adelante en el historial usando los botones del navegador, pero no ocurre cuando se carga una nueva página.
window.addEventListener('popstate', function(event) {
    let url = window.location.pathname;
    if (url.startsWith('/')) {
        url = url.slice(1);
    }

    const displayedUrl = url;
    url = GetURLFile(url);

    let formData = new FormData();
    formData.append('onlyContent', '1');
    // console.log(url);
    // Volver a cargar el contenido cuando se use "atrás" o "adelante"
    fetch(url, {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            document.getElementById('content').innerHTML = data;
            ExecuteBehavior(displayedUrl.split('/').pop());
        })
        .catch(error => console.error('Error al manejar popstate:', error));
});

function ExecuteBehavior(request){
    switch (request) {
        case 'contenido':
            ShowPrograms();       
            break;
        case 'programacion':
            IsSticky();
            break;
        default:
            break;
    }
}

function GetURLFile(url){
    switch (url) {
        case 'inicio':
        case 'nosotros':
        case 'preguntas-frecuentes':
        case 'consejo-ciudadano':
        case 'defensoria-de-las-audiencias':
        case 'derechos-de-la-audiencia':
        case 'quejas-sugerencias':
        case 'transparencia':
        case 'politica-de-privacidad':
        case 'contenido':
        case 'contacto':
            url = `pages/${url}.html`;
            break;
        case 'programacion':
            url = 'php/programacion.php';
            break;
        case './':
        case '':
            url = 'pages/inicio.html';
            break;
        case '404':
        default:
            // Página no encontrada (404)
            url = 'pages/404.html';
            break;
    }
    return url;
}

menuIcon.addEventListener('click', function(e){
    menuIcon.classList.toggle("change");
    navLinks.classList.toggle("show");
    options.classList.toggle('show-options');
});

window.addEventListener('click', function(e){
    if(e.target === navLinks){
        menuIcon.classList.remove("change");
        navLinks.classList.remove("show");
        options.classList.remove('show-options');
    }
});

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