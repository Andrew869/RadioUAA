const programas = [
    {
        id: 1,
        nombre: "#Cultura Freak",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2021/08/Anchor-16a-temporada-300x300.jpg",
        descripcion: "Programa cultural sobre temas diversos.",
        presentadores: "Vladimir Guerrero, Julio Cortez, Isaac Benitez 'El Cheche', Gerardo 'Roger' Loera",
        genero: "Hablado, Informativo, Opinión",
        horario: "Lunes a Viernes, 10:00 AM - 11:00 AM"
    },
    {
        id: 2,
        nombre: "#SoyComunicacoión Radio: Ce de Casa",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2024/04/Captura-de-Pantalla-2024-04-04-a-las-9.47.15-300x135.png",
        descripcion: "Programa del departamento académico de comunicación.",
        horario: "Lunes a Viernes, 12:00 PM - 1:00 PM",
        presentadores: "Equipo de Comunicación",
        genero: "Educativo"
    },
    {
        id: 3,
        nombre: "#SoyComunicación Radio: Es Arte",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2024/04/Captura-de-Pantalla-2024-06-18-a-las-16.19.42-300x124.png",
        descripcion: "Acompaña a nuestros estudiantes del 4o. Semestre de la Licenciatura en Comunicación e Información a descubrir si sus películas, videojuegos, libros y canciones favoritas son arte… o no.",
        horario: "Sábados, 8:00 PM - 11:00 PM",
        presentadores: "Estudiantes de Comunicación",
        genero: "Arte, Cultura"
    },
    {
        id: 4,
        nombre: "#SoyComunicación Radio: Fanáticos del Fandom",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2024/04/277174872_1152867362205010_1555495053818311406_n-150x150.jpeg",
        descripcion: "Todos somos fanáticos de algo, nosotros del fandom 😄 Espacio radiofónico que da voz a los fanáticos sobre eso que les apasiona.",
        horario: "Viernes, 10:00 PM - 12:00 AM",
        presentadores: "Fanáticos Diversos",
        genero: "Entretenimiento, Cultura Pop"
    }
];

<<<<<<< HEAD
const contenedorProgramas = document.getElementById('contenedorProgramas');
const filtroGenero = document.getElementById('filtroGenero');
const filtroPresentador = document.getElementById('filtroPresentador');
const buscadorNombre = document.getElementById('buscadorNombre');
const alternarVista = document.getElementById('alternarVista');
=======

>>>>>>> origin/EduardoPruebasWeb
const modal = document.getElementById('modal');
const btnCerrar = document.getElementsByClassName('cerrar')[0];

const comentariosPorPrograma = {};

function llenarFiltros() {
    const generos = [...new Set(programas.flatMap(programa => programa.genero.split(', ')))];
    generos.forEach(genero => {
        const opcion = document.createElement('option');
        opcion.value = genero;
        opcion.textContent = genero;
        filtroGenero.appendChild(opcion);
    });

    const presentadores = [...new Set(programas.flatMap(programa => programa.presentadores.split(', ')))];
    presentadores.forEach(presentador => {
        const opcion = document.createElement('option');
        opcion.value = presentador.trim();
        opcion.textContent = presentador.trim();
        filtroPresentador.appendChild(opcion);
    });
}

function crearElementoPrograma(programa) {
    const elemento = document.createElement('div');
    elemento.className = 'programa';

    const esListaView = contenedorProgramas.classList.contains('lista');

    if (esListaView) {
        elemento.innerHTML = `
            <img src="${programa.imagen}" alt="${programa.nombre}">
            <div class="programa-info">
                <div class="programa-nombre">${programa.nombre}</div>
                <div>${programa.descripcion}</div>
                <div>${programa.genero}</div>
            </div>
        `;
    } else {
        elemento.innerHTML = `
            <img src="${programa.imagen}" alt="${programa.nombre}">
            <div class="programa-info">
                <div class="programa-nombre">${programa.nombre}</div>
                <div>${programa.genero}</div>
            </div>
        `;
    }
    
    elemento.addEventListener('click', () => abrirModal(programa));
    return elemento;
}

function renderizarProgramas() {
    const programasFiltrados = programas
        .filter(programa => 
            (filtroGenero.value === '' || programa.genero.includes(filtroGenero.value)) &&
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
        gridIcon.style.display = 'none';
        listIcon.style.display = 'block';
    } else {
        contenedorProgramas.classList.remove('lista');
        contenedorProgramas.classList.add('cuadricula');
        gridIcon.style.display = 'block';
        listIcon.style.display = 'none';
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

<<<<<<< HEAD
function agregarComentario(parentId = null) {
    const nombre = document.getElementById('nombre').value;
    const email = document.getElementById('email').value;
    const mensaje = document.getElementById('mensaje').value;
    const errorMensaje = document.getElementById('error-mensaje');
    const programaId = document.getElementById('nombreModal').dataset.programaId;

    if (!validarCampos(nombre, email, mensaje, errorMensaje)) {
        return;
    }

    const fecha = new Date();
    const fechaFormateada = formatearFecha(fecha);

    const nuevoComentario = {
        nombre: nombre,
        fecha: fechaFormateada,
        mensaje: mensaje
    };

    if (!comentariosPorPrograma[programaId]) {
        comentariosPorPrograma[programaId] = [];
    }
    comentariosPorPrograma[programaId].unshift(nuevoComentario);

    const comentarioElement = crearElementoComentario(nombre, fechaFormateada, mensaje);
    document.getElementById('comentarios').insertBefore(comentarioElement, document.getElementById('comentarios').firstChild.nextSibling);

    document.getElementById('nombre').value = '';
    document.getElementById('email').value = '';
    document.getElementById('mensaje').value = '';
    errorMensaje.textContent = '';
}

function validarCampos(nombre, email, mensaje, errorMensaje) {
    if (!nombre || !email || !mensaje) {
        errorMensaje.textContent = 'Por favor, completa todos los campos.';
        return false;
    }

    if (!validarEmail(email)) {
        errorMensaje.textContent = 'Por favor, ingresa un correo electrónico válido.';
        return false;
    }

    return true;
}

function validarEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function formatearFecha(fecha) {
    const opciones = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return fecha.toLocaleDateString('es-ES', opciones);
}

function crearElementoComentario(nombre, fecha, mensaje, respondiendo = null) {
    const comentario = document.createElement('div');
    comentario.className = 'comentario';
    comentario.id = 'comentario-' + Date.now();

    let headerText = nombre;
    if (respondiendo) {
        headerText = `${nombre} respondió a ${respondiendo}`;
    }

    comentario.innerHTML = `
        <div class="comentario-header">
            <div class="comentario-info">
                <p class="comentario-autor">${headerText}</p>
                <p class="comentario-fecha">${fecha}</p>
            </div>
        </div>
        <div class="comentario-contenido">${mensaje}</div>
        <button class="btn-responder" onclick="mostrarFormularioRespuesta('${comentario.id}', '${nombre}')">Responder</button>
    `;

    return comentario;
}

function mostrarFormularioRespuesta(comentarioId, nombreOriginal) {
    const comentario = document.getElementById(comentarioId);
    const formularioExistente = comentario.querySelector('.formulario-comentario');
    
    if (formularioExistente) {
        formularioExistente.remove();
        return;
    }

    const formulario = document.createElement('div');
    formulario.className = 'formulario-comentario';
    formulario.innerHTML = `
        <h4>Responder a ${nombreOriginal}</h4>
        <input type="text" placeholder="Tu nombre" maxlength="20" required>
        <input type="email" placeholder="Tu correo electrónico" maxlength="20" required>
        <textarea placeholder="Tu respuesta" maxlength="100" required></textarea>
        <div class="error"></div>
        <button onclick="responderComentario('${comentarioId}')">Enviar respuesta</button>
    `;

    comentario.appendChild(formulario);
}

function responderComentario(comentarioId) {
    const comentario = document.getElementById(comentarioId);
    const formulario = comentario.querySelector('.formulario-comentario');
    const nombre = formulario.querySelector('input[type="text"]').value;
    const email = formulario.querySelector('input[type="email"]').value;
    const mensaje = formulario.querySelector('textarea').value;
    const errorMensaje = formulario.querySelector('.error');

    if (!validarCampos(nombre, email, mensaje, errorMensaje)) {
        return;
    }

    const fecha = new Date();
    const fechaFormateada = formatearFecha(fecha);

    const comentarioOriginal = comentario.querySelector('.comentario-autor').textContent;
    const nombreOriginal = comentarioOriginal.split(' respondió')[0];

    const respuestaElement = crearElementoComentario(nombre, fechaFormateada, mensaje, nombreOriginal);
    respuestaElement.classList.add('respuesta');
    comentario.insertAdjacentElement('afterend', respuestaElement);

    formulario.remove();
}

btnCerrar.onclick = function() {
    modal.style.display = 'none';
}
=======
// closeBtn.onclick = function() {
//     modal.style.display = 'none';
// }
>>>>>>> origin/EduardoPruebasWeb

window.onclick = function(evento) {
    if (evento.target == modal) {
        modal.style.display = 'none';
    }
}

<<<<<<< HEAD
filtroGenero.addEventListener('change', renderizarProgramas);
filtroPresentador.addEventListener('change', renderizarProgramas);
buscadorNombre.addEventListener('input', renderizarProgramas);
alternarVista.addEventListener('click', alternarVistaModo);

llenarFiltros();
renderizarProgramas();
=======
export function ShowPrograms(){
    const grid = document.getElementById('programas-grid');
    programas.forEach(programa => {
        grid.appendChild(crearTarjetaPrograma(programa));
    });
}

// document.getElementById('form-comentario').addEventListener('submit', function(event) {
//     event.preventDefault(); // Evita que se recargue la página

//     const nombre = document.getElementById('nombre').value;
//     const comentario = document.getElementById('comentario').value;

//     // Limpiar el formulario
//     document.getElementById('form-comentario').reset();
// });
>>>>>>> origin/EduardoPruebasWeb
