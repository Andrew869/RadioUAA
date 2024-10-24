const programas = [
    {
        id: 1,
        titulo: "#Cultura Freak",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2021/08/Anchor-16a-temporada-300x300.jpg",
        nombre: "#Cultura Freak",
        produccion: "Vladimir Guerrero , Julio Cortez , Isaac Benitez 'El Cheche' y Gerardo 'Roger' Loera",
        genero: "Hablado, Informativo, Opinión",
        horario: "",
        descripcion: "#CulturaFreak es un espacio de discusión, análisis y (des)información sobre todo lo relacionado del mundo de los Cómics, Manga, Anime, Películas de Culto, Series, Literatura Fantástica, Juegos de Rol, Juegos de Cartas Coleccionables, Wargames y demás cosas que antes eran de Frikis, pero ahora se han ganado un lugar dentro del gusto y la Cultura Popular en México y el Mundo. Todo esto y muchas incoherencias más, platicado y a veces analizado por tus 4 Frikis favoritos desde su muy particular y extraño punto de vista."
    },
    {
        id: 2,
        titulo: "#SoyComunicacoión Radio: Ce de Casa",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2024/04/Captura-de-Pantalla-2024-04-04-a-las-9.47.15-300x135.png",
        nombre: "#SoyComunicación Radio: Ce de Casa",
        produccion: "",
        genero: "",
        horario: "",
        descripcion: "Programa del departamento académico de comunicación."
    },
    {
        id: 3,
        titulo: "#SoyComunicación Radio: Es Arte",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2024/04/Captura-de-Pantalla-2024-06-18-a-las-16.19.42-300x124.png",
        nombre: "#SoyComunicación Radio: Es Arte",
        produccion: "",
        genero: "",
        horario:"",
        descripcion: "Acompaña a nuestros estudiantes del 4o. Semestre de la Licenciatura en Comunicación e Información a descubrir si sus películas, videojuegos, libros y canciones favoritas son arte… o no."
    },
    {
        id: 4,
        titulo: "#SoyComunicación Radio: Fanáticos del Fandom",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2024/04/277174872_1152867362205010_1555495053818311406_n-150x150.jpeg",
        nombre: "#SoyComunicación Radio: Fanáticos del Fandom",
        produccion: "",
        genero: "",
        horario: "",
        descripcion: "Todos somos fanáticos de algo, nosotros del fandom 😄Espacio radiofónico que da voz a los fanáticos sobre eso que les apasiona."
    },
    {
        id: 5,
        titulo: "#SoyComunicación Radio: HollyWow",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2024/04/278078471_119057040737799_4942402925644699556_n-300x300.jpeg",
        nombre: "#SoyComunicación Radio: HollyWow",
        produccion: "",
        genero: "",
        horario: "",
        descripcion: "Hollywow te trae todos los viernes, una nueva edición con noticias, entrevistas, cápsulas y recomendaciones sobre las series y películas que no te puedes perder. «Hollywow, donde damos opiniones impopulares sobre cinema popular»."
    },
    {
        id: 6,
        titulo: "Natty Reggae",
        imagen: "https://radio.uaa.mx/wp-content/uploads/2023/06/Logo-Natty-Reggae-300x300.png",
        nombre: "Natty Reggae",
        produccion: "Osvaldo Rodriguez",
        genero: "Musical",
        horario: "",
        descripcion: "Un programa musical que te transporta a los vibrantes ritmos del reggue y otros géneros. Disfruta de la mejor música con una fusión de estilos autóctonos y contemporáneos."
    }
];


const modal = document.getElementById('modal');
const closeBtn = document.getElementsByClassName('close')[0];

function crearTarjetaPrograma(programa) {
    const tarjeta = document.createElement('div');
    tarjeta.className = 'programa';
    tarjeta.innerHTML = `
        <img src="${programa.imagen}" alt="${programa.titulo}">
        <div class="descripcion-breve">${programa.nombre}</div>
    `;
    tarjeta.addEventListener('click', () => abrirModal(programa));
    return tarjeta;
}

function abrirModal(programa) {
    document.getElementById('modal-titulo').textContent = programa.titulo;
    document.getElementById('modal-imagen').src = programa.imagen;
    document.getElementById('modal-imagen').alt = programa.titulo;
    document.getElementById('modal-produccion').textContent = programa.produccion;
    document.getElementById('modal-genero').textContent = programa.genero;
    document.getElementById('modal-horario').textContent = programa.horario;
    document.getElementById('modal-descripcion').textContent = programa.descripcion;
    modal.style.display = 'block';
}

// closeBtn.onclick = function() {
//     modal.style.display = 'none';
// }

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

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