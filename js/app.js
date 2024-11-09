// Single Page Application (SPA)!!!!
import { ShowPrograms } from './contenido.js';
// Obtener todos los enlaces de navegación
const navLinks = document.querySelectorAll('.nav-link');
const mainContent = document.getElementById('content');

ExecuteBehavior(window.location.pathname.split('/').pop());

// Agregar evento click a cada enlace de navegación
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault(); // Evita la acción por defecto del enlace

        const url = this.getAttribute('href'); // Obtener la URL del enlace
        console.log(url);
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
                window.history.pushState({path: url}, '', url);

                ExecuteBehavior(url);
            })
            .catch(error => console.error('Error al cargar el contenido:', error));
    });
});

// Manejar el historial del navegador (para usar el botón "Atrás" o "Adelante")
// 'popstate' Se dispara cuando el usuario navega hacia atrás o hacia adelante en el historial usando los botones del navegador, pero no ocurre cuando se carga una nueva página.
window.addEventListener('popstate', function(event) {
    const url = window.location.pathname;

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
            ExecuteBehavior(url.split('/').pop());
        })
        .catch(error => console.error('Error al manejar popstate:', error));
});

function ExecuteBehavior(request){
    switch (request) {
        case 'contenido':
            ShowPrograms();       
            break;
    
        default:
            break;
    }
}

// window.addEventListener('beforeunload', function (event) {
//     // Puedes mostrar un mensaje personalizado, pero la mayoría de los navegadores no lo mostrarán.
//     const confirmationMessage = '¿Estás seguro de que deseas salir?';
    
//     // Establecer el mensaje de confirmación
//     event.returnValue = confirmationMessage; // Esto es necesario para algunos navegadores
//     return confirmationMessage; // Algunos navegadores mostrarán este mensaje
// });