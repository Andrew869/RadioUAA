const grid = document.getElementById('programas-grid');
const modal = document.getElementById('modal');
const closeBtn = document.getElementsByClassName('close')[0];

// Función para crear las tarjetas
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
    document.getElementById('modal-produccion').textContent = programa.produccion;
    document.getElementById('modal-genero').textContent = programa.genero;
    document.getElementById('modal-horario').textContent = programa.horario;
    document.getElementById('modal-descripcion').textContent = programa.descripcion;
    modal.style.display = 'block';
}

closeBtn.onclick = function() {
    modal.style.display = 'none';
};

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
};

// Usar fetch para cargar los programas
fetch('fetch_programas.php')
    .then(response => response.json())
    .then(programas => {
        programas.forEach(programa => {
            grid.appendChild(crearTarjetaPrograma(programa));
        });
    })
    .catch(error => console.error('Error al cargar los programas:', error));
