import { LinkBehavior } from './app.js?v=70871d';
import { GetRelativePath } from './utilities.js?v=70871d';
let programas;
let filtroGenero;
let filtroPresentador 
let buscadorNombre

export function SetupPrograms(){
    const contenedorProgramas = document.getElementById('contenedorProgramas');
    filtroGenero = document.getElementById('filtroGenero');
    filtroPresentador = document.getElementById('filtroPresentador');
    buscadorNombre = document.getElementById('buscadorNombre');
    const alternarVista = document.getElementById('alternarVista');

    GetProgramsInfo();

    filtroGenero.addEventListener('change', renderizarProgramas);
    filtroPresentador.addEventListener('change', renderizarProgramas);
    buscadorNombre.addEventListener('input', renderizarProgramas);
    alternarVista.addEventListener('click', alternarVistaModo);
}

function GetProgramsInfo(){
    let formData = new FormData();
    formData.append('GetProgramsInfo', '');
    fetch(GetRelativePath() + 'php/jsRequest.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        programas = data[1];
        programas.forEach(programa => {
            if(!programa.presentadores) programa.presentadores = '';
            if(!programa.generos) programa.generos = '';
        });
        llenarFiltros(data[0]);
        renderizarProgramas();
    })
    .catch(error => console.error('Error al cargar el contenido:', error));
}


const comentariosPorPrograma = {};

function llenarFiltros(info) {
    const generos = info[1];
    
    // const generos = [...new Set(programas.flatMap(programa => programa.genero.split(', ')))];

    generos.forEach(genero => {
        const opcion = document.createElement('option');
        opcion.value = genero;
        opcion.textContent = genero;
        filtroGenero.appendChild(opcion);
    });

    // const presentadores = [...new Set(programas.flatMap(programa => programa.presentadores.split(', ')))];
    const presentadores = info[0];
    presentadores.forEach(presentador => {
        const opcion = document.createElement('option');
        opcion.value = presentador.trim();
        opcion.textContent = presentador.trim();
        filtroPresentador.appendChild(opcion);
    });
}

function crearElementoPrograma(programa) {
    const elemento = document.createElement('a');
    elemento.classList.add('programa');
    elemento.classList.add('internal-link');
    elemento.classList.add('c1');
    elemento.href = "/programa/" + programa.id;
    elemento.onclick = (e) => {LinkBehavior(e)};

    const esListaView = contenedorProgramas.classList.contains('lista');

    let generos = programa.generos? programa.generos : '';

    if (esListaView) {
        elemento.innerHTML = `
            <img src="${programa.imagen}.300" alt="${programa.nombre}">
            <div class="programa-info">
                <div class="programa-nombre">${programa.nombre}</div>
                <div>${programa.descripcion}</div>
            </div>
        `;
    } else {
        elemento.innerHTML = `
            <img src="${programa.imagen}.300" alt="${programa.nombre}">
            <div class="programa-info">
                <div class="programa-nombre">${programa.nombre}</div>
                <div>${generos}</div>
            </div>
        `;
    }
    
    // elemento.addEventListener('click', () => abrirModal(programa));
    return elemento;
}

function renderizarProgramas() {
    const programasFiltrados = programas
        .filter(programa => 
            (filtroGenero.value === '' || programa.generos.includes(filtroGenero.value)) &&
            (filtroPresentador.value === '' || programa.presentadores.toLowerCase().includes(filtroPresentador.value.toLowerCase())) &&
            programa.nombre.toLowerCase().includes(buscadorNombre.value.toLowerCase())
        );
    contenedorProgramas.innerHTML = '';
    programasFiltrados.forEach(programa => {
        contenedorProgramas.appendChild(crearElementoPrograma(programa));
    });
}

function alternarVistaModo() {
    const gridIcon = document.getElementById('gridIcon');
    const listIcon = document.getElementById('listIcon');

    if (contenedorProgramas.classList.contains('cuadricula')) {
        contenedorProgramas.classList.remove('cuadricula');
        contenedorProgramas.classList.add('lista');
        gridIcon.style.display = 'block';
        listIcon.style.display = 'none';
    } else {
        contenedorProgramas.classList.remove('lista');
        contenedorProgramas.classList.add('cuadricula');
        gridIcon.style.display = 'none';
        listIcon.style.display = 'block';
    }

    renderizarProgramas();
}

function abrirModal(programa) {
    document.getElementById('nombreModal').textContent = programa.nombre;
    document.getElementById('nombreModal').dataset.programaId = programa.id;
    document.getElementById('imagenModal').src = programa.imagen;
    document.getElementById('imagenModal').alt = programa.nombre;
    document.getElementById('descripcionModal').textContent = programa.descripcion;
    document.getElementById('horarioModal').textContent = programa.horario;
    document.getElementById('presentadoresModal').textContent = programa.presentadores;
    document.getElementById('generoModal').textContent = programa.genero;
    
    const comentariosContainer = document.getElementById('comentarios');
    comentariosContainer.innerHTML = '<h3>Comentarios</h3>';

    if (comentariosPorPrograma[programa.id]) {
        comentariosPorPrograma[programa.id].forEach(comentario => {
            const comentarioElement = crearElementoComentario(comentario.nombre, comentario.fecha, comentario.mensaje);
            comentariosContainer.appendChild(comentarioElement);
        });
    }

    modal.style.display = 'block';
}

// function agregarComentario(parentId = null) {
//     const nombre = document.getElementById('nombre').value;
//     const email = document.getElementById('email').value;
//     const mensaje = document.getElementById('mensaje').value;
//     const errorMensaje = document.getElementById('error-mensaje');
//     const programaId = document.getElementById('nombreModal').dataset.programaId;

//     if (!validarCampos(nombre, email, mensaje, errorMensaje)) {
//         return;
//     }

//     const fecha = new Date();
//     const fechaFormateada = formatearFecha(fecha);

//     const nuevoComentario = {
//         nombre: nombre,
//         fecha: fechaFormateada,
//         mensaje: mensaje
//     };

//     if (!comentariosPorPrograma[programaId]) {
//         comentariosPorPrograma[programaId] = [];
//     }
//     comentariosPorPrograma[programaId].unshift(nuevoComentario);

//     const comentarioElement = crearElementoComentario(nombre, fechaFormateada, mensaje);
//     document.getElementById('comentarios').insertBefore(comentarioElement, document.getElementById('comentarios').firstChild.nextSibling);

//     document.getElementById('nombre').value = '';
//     document.getElementById('email').value = '';
//     document.getElementById('mensaje').value = '';
//     errorMensaje.textContent = '';
// }

// function validarCampos(nombre, email, mensaje, errorMensaje) {
//     if (!nombre || !email || !mensaje) {
//         errorMensaje.textContent = 'Por favor, completa todos los campos.';
//         return false;
//     }

//     if (!validarEmail(email)) {
//         errorMensaje.textContent = 'Por favor, ingresa un correo electrónico válido.';
//         return false;
//     }

//     return true;
// }

// function validarEmail(email) {
//     const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//     return re.test(email);
// }

// function formatearFecha(fecha) {
//     const opciones = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
//     return fecha.toLocaleDateString('es-ES', opciones);
// }

// function crearElementoComentario(nombre, fecha, mensaje, respondiendo = null) {
//     const comentario = document.createElement('div');
//     comentario.className = 'comentario';
//     comentario.id = 'comentario-' + Date.now();

//     let headerText = nombre;
//     if (respondiendo) {
//         headerText = `${nombre} respondió a ${respondiendo}`;
//     }

//     comentario.innerHTML = `
//         <div class="comentario-header">
//             <div class="comentario-info">
//                 <p class="comentario-autor">${headerText}</p>
//                 <p class="comentario-fecha">${fecha}</p>
//             </div>
//         </div>
//         <div class="comentario-contenido">${mensaje}</div>
//         <button class="btn-responder" onclick="mostrarFormularioRespuesta('${comentario.id}', '${nombre}')">Responder</button>
//     `;

//     return comentario;
// }

// function mostrarFormularioRespuesta(comentarioId, nombreOriginal) {
//     const comentario = document.getElementById(comentarioId);
//     const formularioExistente = comentario.querySelector('.formulario-comentario');
    
//     if (formularioExistente) {
//         formularioExistente.remove();
//         return;
//     }

//     const formulario = document.createElement('div');
//     formulario.className = 'formulario-comentario';
//     formulario.innerHTML = `
//         <h4>Responder a ${nombreOriginal}</h4>
//         <input type="text" placeholder="Tu nombre" maxlength="20" required>
//         <input type="email" placeholder="Tu correo electrónico" maxlength="20" required>
//         <textarea placeholder="Tu respuesta" maxlength="100" required></textarea>
//         <div class="error"></div>
//         <button onclick="responderComentario('${comentarioId}')">Enviar respuesta</button>
//     `;

//     comentario.appendChild(formulario);
// }

// function responderComentario(comentarioId) {
//     const comentario = document.getElementById(comentarioId);
//     const formulario = comentario.querySelector('.formulario-comentario');
//     const nombre = formulario.querySelector('input[type="text"]').value;
//     const email = formulario.querySelector('input[type="email"]').value;
//     const mensaje = formulario.querySelector('textarea').value;
//     const errorMensaje = formulario.querySelector('.error');

//     if (!validarCampos(nombre, email, mensaje, errorMensaje)) {
//         return;
//     }

//     const fecha = new Date();
//     const fechaFormateada = formatearFecha(fecha);

//     const comentarioOriginal = comentario.querySelector('.comentario-autor').textContent;
//     const nombreOriginal = comentarioOriginal.split(' respondió')[0];

//     const respuestaElement = crearElementoComentario(nombre, fechaFormateada, mensaje, nombreOriginal);
//     respuestaElement.classList.add('respuesta');
//     comentario.insertAdjacentElement('afterend', respuestaElement);

//     formulario.remove();
// }



// llenarFiltros();
// renderizarProgramas();