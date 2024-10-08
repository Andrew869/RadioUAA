// Obtener elementos del DOM
const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('fileInput');
const uploadForm = document.getElementById('uploadForm');

// Obtener las listas
const presentadoresAvailable = document.getElementById('presentadoresAvailable');
const presentadoresSelected = document.getElementById('presentadoresSelected');
const presentadoresSelectedInput = document.getElementById('presentadoresSelectedInput');
const generosAvailable = document.getElementById('generosAvailable');
const generosSelected = document.getElementById('generosSelected');
const generosSelectedInput = document.getElementById('generosSelectedInput');

let times_container = document.getElementById('times_container');

const bloqueOriginal = times_container.querySelector('.times');
const days_list = document.getElementsByClassName('days_list');
const items = days_list[0].getElementsByTagName('li');

const chks = document.getElementsByClassName('chk');

let index_list = 0;
let name_submit = 'horarios[x]';

let txtHint = null;

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

    let replicans = times_container.querySelectorAll('.times');

    replicans.forEach(element => {
        selected = [];
        element.querySelectorAll('.selected').forEach(function(item) {
            selected.push(item.textContent);
        });
        element.querySelector('.diasSelectedInput').value = selected.join(',');
    });
}

document.getElementById('button_addNew').addEventListener('click', function() {
    // Clonar el bloque (con sus hijos)
    let bloqueClonado = bloqueOriginal.cloneNode(true);
    let inputs = bloqueClonado.querySelectorAll('input');
    let checkboxes = bloqueClonado.querySelectorAll('.chk');

    bloqueClonado.addEventListener('click', CheckTimes);
    bloqueClonado.addEventListener('keyup', CheckTimes);

    // Reiniciando valores en la replica
    inputs.forEach(element => {
        if(element.type !== 'checkbox')
        element.value = null;
    });
    checkboxes[0].checked = false;
    checkboxes[1].checked = true;

    checkboxes[0].addEventListener('click', function(){
        checkboxes[1].checked = !this.checked;
    });

    // Cambiando la clase de la lista
    let days_list_clone = bloqueClonado.querySelector('.days_list')
    days_list_clone.className = ++index_list;

    // Cambia los name de los input
    inputs.forEach(element => {
        let name_text = name_submit + "["+ element.getAttribute('field_name') + "]";
        element.name = name_text.replace('[x]', '[' + index_list + ']');
    });

    // Asignacion de event listeners a las opciones de la lista
    let items_clone = days_list_clone.querySelectorAll('li');

    items_clone.forEach(element => {
        element.classList.remove('selected');
        element.addEventListener('click', function() {
            // Alternar la clase 'selected' al hacer clic
            this.classList.toggle('selected');
        });
    });
    
    // agregar el bloque a contenedor padre
    times_container.appendChild(bloqueClonado);
});

function CheckTimes(e) {
    selected = [];
    txtHint = e.currentTarget.querySelector(".txtHint");
    e.currentTarget.querySelectorAll('.selected').forEach(function(item) {
        selected.push(item.textContent);
    });

    // let times = e.currentTarget.querySelectorAll('[type="time"]').forEach(element => {
    //     console.log(element.value);
    // });

    let times = e.currentTarget.querySelectorAll('[type="time"]')


    // console.log(e.currentTarget.tagName);

    if (!selected.length || times[0].value === "" || times[1].value === "") {
        txtHint.innerHTML = "Completa todos los campos del horario";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                txtHint.innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","horarios.php?dias=" + selected.join(',') + "&hora_inicio=" + times[0].value + "&hora_fin=" + times[1].value ,true);
        xmlhttp.send();
    }
  }


// Añadir un evento de clic a cada elemento de la lista
for (let i = 0; i < items.length; i++) {
    items[i].addEventListener('click', function() {
        // Alternar la clase 'selected' al hacer clic
        this.classList.toggle('selected');
    });
}

chks[0].addEventListener('click', function(){
    chks[1].checked = !this.checked;
});

// days_list[0].addEventListener('click', ChechTimes);

bloqueOriginal.addEventListener('click', CheckTimes);
bloqueOriginal.addEventListener('keyup', CheckTimes);
  