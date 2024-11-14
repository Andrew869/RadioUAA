const programas = [
    {
        id: 1,
        nombre: "#Cultura Freak",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2021/08/Anchor-16a-temporada-300x300.jpg",
        descripcion: "",
        presentadores: "Vladimir Guerrero , Julio Cortez , Isaac Benitez 'El Cheche' y Gerardo 'Roger' Loera",
        genero: "Hablado, Informativo, Opinión"
    },
    {
        id: 2,
        nombre: "#SoyComunicacoión Radio: Ce de Casa",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2024/04/Captura-de-Pantalla-2024-04-04-a-las-9.47.15-300x135.png",
        descripcion: "Programa del departamento académico de comunicación.",
        horario: "Lunes a Viernes, 12:00 PM - 1:00 PM",
        presentadores: "",
        genero: ""
    },
    {
        id: 3,
        nombre: "#SoyComunicación Radio: Es Arte",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2024/04/Captura-de-Pantalla-2024-06-18-a-las-16.19.42-300x124.png",
        descripcion: "Acompaña a nuestros estudiantes del 4o. Semestre de la Licenciatura en Comunicación e Información a descubrir si sus películas, videojuegos, libros y canciones favoritas son arte… o no.",
        horario: "Sábados, 8:00 PM - 11:00 PM",
        presentadores: "Alex Turner, Chris Martin",
        genero: "Rock"
    },
    {
        id: 4,
        nombre: "#SoyComunicación Radio: Fanáticos del Fandom",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2024/04/277174872_1152867362205010_1555495053818311406_n-150x150.jpeg",
        descripcion: "odos somos fanáticos de algo, nosotros del fandom 😄Espacio radiofónico que da voz a los fanáticos sobre eso que les apasiona.",
        horario: "Viernes, 10:00 PM - 12:00 AM",
        presentadores: "Ella Fitzgerald",
        genero: "Jazz"
    },{
        id: 1,
        nombre: "#Cultura Freak",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2024/08/Captura-de-Pantalla-2024-08-08-a-las-15.20.45.png",
        descripcion: "#CulturaFreak es un espacio de discusión, análisis y (des)información sobre todo lo relacionado del mundo de los Cómics, Manga, Anime, Películas de Culto, Series, Literatura Fantástica, Juegos de Rol, Juegos de Cartas Coleccionables, Wargames y demás cosas que antes eran de Frikis, pero ahora se han ganado un lugar dentro del gusto y la Cultura Popular en México y el Mundo. Todo esto y muchas incoherencias más, platicado y a veces analizado por tus 4 Frikis favoritos desde su muy particular y extraño punto de vista.",
        horario: "Lunes a Viernes, 6:00 AM - 9:00 AM",
        presentadores: "Vladimir Guerrero , Julio Cortez , Isaac Benitez 'El Cheche' y Gerardo 'Roger' Loera",
        genero: "Hablado, Informativo, Opinión"
    },
    {
        id: 2,
        nombre: "#SoyComunicacoión Radio: Ce de Casa",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2021/11/lahoranacional-150x150.png",
        descripcion: "Programa del departamento académico de comunicación.",
        horario: "Lunes a Viernes, 12:00 PM - 1:00 PM",
        presentadores: "",
        genero: ""
    },
    {
        id: 3,
        nombre: "#SoyComunicación Radio: Es Arte",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2024/04/Captura-de-Pantalla-2024-04-10-a-las-13.22.17-150x150.png",
        descripcion: "Acompaña a nuestros estudiantes del 4o. Semestre de la Licenciatura en Comunicación e Información a descubrir si sus películas, videojuegos, libros y canciones favoritas son arte… o no.",
        horario: "Sábados, 8:00 PM - 11:00 PM",
        presentadores: "Alex Turner, Chris Martin",
        genero: "Rock"
    },
    {
        id: 4,
        nombre: "#SoyComunicación Radio: Fanáticos del Fandom",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2021/08/3a-After-01-150x150.png",
        descripcion: "odos somos fanáticos de algo, nosotros del fandom 😄Espacio radiofónico que da voz a los fanáticos sobre eso que les apasiona.",
        horario: "Viernes, 10:00 PM - 12:00 AM",
        presentadores: "Ella Fitzgerald",
        genero: "Jazz"
    },{
        id: 1,
        nombre: "#Cultura Freak",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2024/04/contra-rutina-150x150.png",
        descripcion: "#CulturaFreak es un espacio de discusión, análisis y (des)información sobre todo lo relacionado del mundo de los Cómics, Manga, Anime, Películas de Culto, Series, Literatura Fantástica, Juegos de Rol, Juegos de Cartas Coleccionables, Wargames y demás cosas que antes eran de Frikis, pero ahora se han ganado un lugar dentro del gusto y la Cultura Popular en México y el Mundo. Todo esto y muchas incoherencias más, platicado y a veces analizado por tus 4 Frikis favoritos desde su muy particular y extraño punto de vista.",
        horario: "Lunes a Viernes, 6:00 AM - 9:00 AM",
        presentadores: "Vladimir Guerrero , Julio Cortez , Isaac Benitez 'El Cheche' y Gerardo 'Roger' Loera",
        genero: "Hablado, Informativo, Opinión"
    },
    {
        id: 2,
        nombre: "#SoyComunicacoión Radio: Ce de Casa",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2021/08/cinergis-150x150.png",
        descripcion: "Programa del departamento académico de comunicación.",
        horario: "Lunes a Viernes, 12:00 PM - 1:00 PM",
        presentadores: "",
        genero: ""
    },
    {
        id: 3,
        nombre: "#SoyComunicación Radio: Es Arte",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2024/04/Captura-de-Pantalla-2024-06-18-a-las-16.19.42-300x124.png",
        descripcion: "Acompaña a nuestros estudiantes del 4o. Semestre de la Licenciatura en Comunicación e Información a descubrir si sus películas, videojuegos, libros y canciones favoritas son arte… o no.",
        horario: "Sábados, 8:00 PM - 11:00 PM",
        presentadores: "Alex Turner, Chris Martin",
        genero: "Rock"
    },
    {
        id: 4,
        nombre: "#SoyComunicación Radio: Fanáticos del Fandom",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2024/04/d82bf76c-52ea-4b5b-9c49-89cfd1d91b22-150x150.png",
        descripcion: "odos somos fanáticos de algo, nosotros del fandom 😄Espacio radiofónico que da voz a los fanáticos sobre eso que les apasiona.",
        horario: "Viernes, 10:00 PM - 12:00 AM",
        presentadores: "Ella Fitzgerald",
        genero: "Jazz"
    }
];

const contenedorProgramas = document.getElementById('contenedorProgramas');
const filtroGenero = document.getElementById('filtroGenero');
const ordenNombre = document.getElementById('ordenNombre');
const buscadorNombre = document.getElementById('buscadorNombre');
const alternarVista = document.getElementById('alternarVista');
const modal = document.getElementById('modal');
const btnCerrar = document.getElementsByClassName('cerrar')[0];

let vistaActual = 'cuadricula';


function llenarFiltros() {
    // Llenar filtro de género
    const generos = [...new Set(programas.map(programa => programa.genero))];
    generos.forEach(genero => {
        const opcion = document.createElement('option');
        opcion.value = genero;
        opcion.textContent = genero;
        filtroGenero.appendChild(opcion);
    });

    // Llenar filtro de presentadores
    const presentadores = [...new Set(programas.flatMap(programa => programa.presentadores.split(',')))];
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

    // Set innerHTML based on the current view mode
    if (vistaActual === 'lista') {
        // List view: display name, description, and genre
        elemento.innerHTML = `
            <img src="${programa.imagen}" alt="${programa.nombre}">
            <div class="programa-info">
                <div class="programa-nombre">${programa.nombre}</div>
                <div>${programa.descripcion}</div>
                <div>${programa.genero}</div>
            </div>
        `;
    } else {
        // Grid view: display name and genre only
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
            (filtroGenero.value === '' || programa.genero === filtroGenero.value) &&
            (filtroPresentador.value === '' || programa.presentadores.toLowerCase().includes(filtroPresentador.value.toLowerCase())) &&
            programa.nombre.toLowerCase().includes(buscadorNombre.value.toLowerCase())
        )
    contenedorProgramas.innerHTML = '';
    programasFiltrados.forEach(programa => {
        contenedorProgramas.appendChild(crearElementoPrograma(programa));
    });
}


function alternarVistaModo() {
    vistaActual = vistaActual === 'cuadricula' ? 'lista' : 'cuadricula';
    contenedorProgramas.className = vistaActual;

    // Alterna los íconos de cuadrícula y lista en el botón
    const gridIcon = document.getElementById("gridIcon");
    const listIcon = document.getElementById("listIcon");

    if (vistaActual === 'cuadricula') {
        gridIcon.style.display = "inline";
        listIcon.style.display = "none";
    } else {
        gridIcon.style.display = "none";
        listIcon.style.display = "inline";
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