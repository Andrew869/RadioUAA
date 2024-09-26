// Obtener elementos del DOM
const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('fileInput');
const uploadForm = document.getElementById('uploadForm');

// Cambiar apariencia del área de arrastre cuando el archivo está sobre ella
dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('dragover');
});

dropZone.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragover');
});

// Manejar el evento de soltar
dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragover');

    // Obtener archivo soltado
    const files = e.dataTransfer.files;
    if (files.length) {
        fileInput.files = files; // Asignar archivos al input file
        dropZone.textContent = fileInput.files[0].name;
    }
});

// Hacer clic en el área de arrastre para seleccionar archivos
dropZone.addEventListener('click', () => {
    fileInput.click();
});

// Cuando el usuario selecciona el archivo con el input file
fileInput.addEventListener('change', () => {
    if (fileInput.files.length) {
        dropZone.textContent = fileInput.files[0].name;
    }
});

// Obtener las listas
const presentadoresAvailable = document.getElementById('presentadoresAvailable');
const presentadoresSelected = document.getElementById('presentadoresSelected');
const presentadoresSelectedInput = document.getElementById('presentadoresSelectedInput');
const generosAvailable = document.getElementById('generosAvailable');
const generosSelected = document.getElementById('generosSelected');
const generosSelectedInput = document.getElementById('generosSelectedInput');

function MoveOption(e) {
    if (e.target.tagName !== 'LI') return;
    const optionList = e.target;
    if(e.currentTarget.className === 'presentadores'){
        if(e.currentTarget.id === 'presentadoresAvailable'){
            presentadoresSelected.appendChild(optionList);
            optionList.classList.add('selected');
        }
        else{
            presentadoresAvailable.appendChild(optionList);
            optionList.classList.remove('selected');
        }
    }
    else{
        if(e.currentTarget.id === 'generosAvailable'){
            generosSelected.appendChild(optionList);
            optionList.classList.add('selected');
        }
        else{
            generosAvailable.appendChild(optionList);
            optionList.classList.remove('selected');
        }
    }
}
presentadoresAvailable.addEventListener('click', MoveOption);
presentadoresSelected.addEventListener('click', MoveOption);
generosAvailable.addEventListener('click', MoveOption);
generosSelected.addEventListener('click', MoveOption);

function GetSelectedOptions() {
    let selected = [];
    presentadoresSelected.querySelectorAll('li').forEach((li) => {
        selected.push(li.getAttribute('id_presentador'));
    });
    presentadoresSelectedInput.value = selected.join(',');
    selected = [];
    generosSelected.querySelectorAll('li').forEach((li) => {
        selected.push(li.getAttribute('id_genero'));
    });
    generosSelectedInput.value = selected.join(',');
}