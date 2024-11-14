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

const contenedorProgramas = document.getElementById('contenedorProgramas');
const filtroGenero = document.getElementById('filtroGenero');
const filtroPresentador = document.getElementById('filtroPresentador');
const buscadorNombre = document.getElementById('buscadorNombre');
const alternarVista = document.getElementById('alternarVista');
const modal = document.getElementById('modal');
const btnCerrar = document.getElementsByClassName('cerrar')[0];

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
    document.getElementById('imagenModal').src = programa.imagen;
    document.getElementById('imagenModal').alt = programa.nombre;
    document.getElementById('descripcionModal').textContent = programa.descripcion;
    document.getElementById('horarioModal').textContent = programa.horario;
    document.getElementById('presentadoresModal').textContent = programa.presentadores;
    document.getElementById('generoModal').textContent = programa.genero;
    modal.style.display = 'block';
}

btnCerrar.onclick = function() {
    modal.style.display = 'none';
}

window.onclick = function(evento) {
    if (evento.target == modal) {
        modal.style.display = 'none';
    }
}

filtroGenero.addEventListener('change', renderizarProgramas);
filtroPresentador.addEventListener('change', renderizarProgramas);
buscadorNombre.addEventListener('input', renderizarProgramas);
alternarVista.addEventListener('click', alternarVistaModo);

llenarFiltros();
renderizarProgramas();