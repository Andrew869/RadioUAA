const deleteModal = document.getElementById("deleteModal");
const updateModal = document.getElementById("updateModal");
const createModal = document.getElementById("createModal");

const forms = createModal.querySelectorAll('.form');

let current_content, current_pk;

let inputs;
let input;

let originalschedule;
let replicants = [];

// variables para el control de seleccion en dias
let currentListOption, targetListOption;
let isDragging = false;

if(deleteModal){
    let deleteX = deleteModal.querySelector('SPAN');
    
    let confirmBtn = deleteModal.querySelector('#confirmBtn');

    deleteX.onclick = function() {
        HideModal(deleteModal);
    }

   

    confirmBtn.addEventListener('click', function(){
        DeleteContent(current_content, current_pk);
    });

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == deleteModal) {
            deleteModal.style.display = "none";
        }
    }
}

if(updateModal){
    inputs = updateModal.querySelectorAll('.inputModal');
    InputFileManager(updateModal.querySelector('#input_file'));
    DaysSelectionSystem(updateModal.querySelector('.days_list'));
    ListSelectionSystem(document.getElementById('optionsSelected'), document.getElementById('optionsAvailable'));
}

if(createModal){
    const createX = createModal.querySelector('.close');
    const cancelBtn = createModal.querySelector('#cancelBtn');

    inputs_file = createModal.querySelectorAll('#input_file');

    InputFileManager(inputs_file[0]);
    InputFileManager(inputs_file[1]);

    // Obtener las listas
    // const presentadoresSelected = document.getElementById('presentadoresSelected');
    // const presentadoresAvailable = document.getElementById('presentadoresAvailable');
    
    // const generosSelected = document.getElementById('generosSelected');
    // const generosAvailable = document.getElementById('generosAvailable');

    DaysSelectionSystem(createModal.querySelector('.days_list'));
    ListSelectionSystem(createModal.querySelector('#presentadoresSelected'), createModal.querySelector('#presentadoresAvailable'))
    ListSelectionSystem(createModal.querySelector('#generosSelected'), createModal.querySelector('#generosAvailable'))


    createX.addEventListener('click', function(){
        createModalExit();
    });

    cancelBtn.addEventListener('click', function(){
        createModalExit();
    });

    window.onclick = function(event) {
        if (event.target == createModal) {
            createModalExit();
        }
    }
    window.addEventListener('mouseup', function(){
        isDragging = false;
    });
}

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

function CloneSchedule(schedulesContainer, newScheduleBtn) {
    // Clonar el bloque (con sus hijos)
    const replicant = originalschedule.cloneNode(true);
    const inputs = replicant.querySelectorAll('input');
    const checkbox = replicant.querySelector('#es_retransmision');

    replicant.addEventListener('click', CheckTimes);
    replicant.addEventListener('keyup', CheckTimes);

    // Reiniciando valores en la replica
    inputs.forEach(element => {
        if(element.type !== 'checkbox')
        element.value = null;
    });
    checkbox.checked = false;

    // Cambiando la clase de la lista
    const days_list = replicant.querySelector('.days_list')
    // days_list_clone.className = ++index_list;

    DaysSelectionSystem(days_list);

    // Cambia los name de los input
    // inputs.forEach(element => {
    //     let name_text = name_submit + "["+ element.getAttribute('field_name') + "]";
    //     element.name = name_text.replace('[x]', '[' + index_list + ']');
    // });

    // Asignacion de event listeners a las opciones de la lista
    let items_clone = days_list.querySelectorAll('li');

    items_clone.forEach(element => {
        element.classList.remove('selected');
        element.addEventListener('click', function() {
            // Alternar la clase 'selected' al hacer clic
            this.classList.toggle('selected');
        });
    });
    
    // agregar el bloque a contenedor padre
    // times_container.appendChild(replicant);
    schedulesContainer.insertBefore(replicant, newScheduleBtn);
    replicants.push(replicant);
}

function InputFileManager(input_file){
    const dropZone = input_file.querySelector('#drop-zone');
    const actual_input = input_file.querySelector('#fileInput')
    const feedback = input_file.querySelector('#feedback_file');
    
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
            console.log("asd");
            actual_input.files = files; // Asignar archivos al input file
            // Disparar manualmente el evento change
            const event = new Event('change', { bubbles: true });
            actual_input.dispatchEvent(event);
            // dropZone.textContent = actual_input.files[0].name;
        }
    });

    // Hacer clic en el área de arrastre para seleccionar archivos
    dropZone.onclick = () => {
        actual_input.click();
    };

    actual_input.addEventListener('change', function(event) {
        console.log("aqui");
        let fileInput = event.target;
        file = fileInput.files[0]; // Obtener el archivo seleccionado
        feedback.textContent = ''; // Limpiar mensaje previo

        if (actual_input.files.length) {
            dropZone.textContent = file.name;
        }
        
        // Comprobar si se ha seleccionado un archivo
        if (!file) {
            feedback.textContent = 'Por favor selecciona un archivo.';
            return;
        }
    
        // Verificar el tamaño del archivo (máximo 500KB)
        let maxSize = 500 * 1024; // 500KB
        if (file.size > maxSize) {
            feedback.textContent = 'El archivo es demasiado grande. Máximo 500KB.';
            fileInput.value = ''; // Limpiar el archivo seleccionado
            return;
        }
    
        // Verificar extensiones permitidas
        let allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        if (!allowedExtensions.exec(file.name)) {
            feedback.textContent = 'Solo se permiten archivos con extensiones .jpg, .jpeg, .png, .gif';
            fileInput.value = ''; // Limpiar el archivo seleccionado
            return;
        }
    
        // Verificar que sea un archivo de imagen con el tipo MIME
        if (!file.type.startsWith('image/')) {
            feedback.textContent = 'El archivo debe ser una imagen válida.';
            fileInput.value = ''; // Limpiar el archivo seleccionado
            return;
        }
    
        // Si todas las comprobaciones pasan, mostrar mensaje de éxito
        feedback.textContent = 'El archivo es válido y está listo para subir.';
    });
}

function DaysSelectionSystem(days_list){
    days_list.addEventListener('mousedown', function(e){
        targetListOption = e.target;
        if(targetListOption.tagName === 'LI'){
            isDragging = true;
            targetListOption.classList.toggle('selected');
            currentListOption = targetListOption;
        }
    });
    days_list.addEventListener('mousemove', function(e){
        if (isDragging) {  // Solo se ejecuta si el ratón está presionado
            targetListOption = e.target;
            if(targetListOption.tagName === 'LI' && currentListOption != targetListOption){
                currentListOption = targetListOption;
                targetListOption.classList.toggle('selected');
            }
        }
    });
    days_list.addEventListener('mouseup', function(){
        isDragging = false;
    });
}

function ListSelectionSystem(optionsSelected, optionsAvailable){
    optionsSelected.addEventListener('click', function(e){
        MoveOption(e, optionsSelected, optionsAvailable);
    });
    optionsAvailable.addEventListener('click', function(e){
        MoveOption(e, optionsSelected, optionsAvailable);
    });
}

function SwapInOrden(current_opction, target_list){
    let flag = 1;
    options = target_list.querySelectorAll('LI');
    options.forEach(element => {
        let available_id = parseInt(current_opction.getAttribute('id'), 10);
        let selected_id = parseInt(element.getAttribute('id'), 10);
        if(selected_id > available_id && flag){
            element.parentNode.insertBefore(current_opction, element); // pone el elemento antes
            flag = 0;
        }
    });
    if(flag)
        target_list.appendChild(current_opction);
    // current_opction.classList.add('selected');
}

function MoveOption(e, optionsSelected, optionsAvailable) {
    if (e.target.tagName !== 'LI') return;
    const optionList = e.target;
    if(e.currentTarget === optionsAvailable){
        SwapInOrden(optionList, optionsSelected);
        optionList.classList.add('selected');
    }
    else{
        SwapInOrden(optionList, optionsAvailable);
        optionList.classList.remove('selected');
    }
}

function DeleteLists(){
    let opctions = input.querySelectorAll("LI");

    opctions.forEach(element => {
        element.remove();
    });
}

function SetupModal(type){
    updateModal.style.display = 'block';
    updateModal.classList.add('show');
    updateModal.classList.remove('hide');
    // let deleteX = deleteModal.querySelector('SPAN');
    let uptadeX = updateModal.querySelector('SPAN');
    let cancelBtn = updateModal.querySelector('#cancelBtn');

    exitOptions = [uptadeX, cancelBtn];

    exitOptions.forEach(element => {
        element.addEventListener('click', function(){
            HideModal(updateModal);
            DeleteLists();
        });
    });

    window.onclick = function(event) {
		if (event.target == deleteModal || event.target == updateModal) {
            HideModal(updateModal);
            DeleteLists();
		}
	}

    window.addEventListener('mouseup', function(){
        isDragging = false;
    });

    inputs.forEach(element => {
        if(element.id !== type)
            element.style.display = "none";
        else{
            element.style.display = "block";
            input = element;
        }
    });

    return updateModal.querySelector('#confirmBtn');
}

function ToHours(minutes) {
    let hours = Math.floor(minutes / 60);
    let mins = minutes % 60;
    hours = hours < 10 ? '0' + hours : hours;
    mins = mins < 10 ? '0' + mins : mins;
    return hours + ':' + mins;
}

function createModalExit(){
    createModal.style.display = 'none';

    let days = originalschedule.querySelectorAll('LI');

    days.forEach(day => {
        day.classList.remove('selected');
    });

    replicants.forEach(replicant => {
        replicant.remove();
    });
}

function HideModal(modal){
    modal.style.display = 'none';
    // setTimeout(() => {
    // }, 500);
}

function showCreateForm(table_name){
    const confirmBtn = createModal.querySelector('#confirmBtn');
    createModal.style.display = 'block';
    let current_form;
    

    forms.forEach(form => {
        if(form.id === table_name){
            current_form = form;
            form.style.display = 'block';
        }
        else
            form.style.display = 'none';
    });

    const schedulesContainer = current_form.querySelector('#schedules_container');
    originalschedule = schedulesContainer.querySelector('.schedule');
    const newScheduleBtn = schedulesContainer.querySelector('#addNewSchedule');
    newScheduleBtn.addEventListener('click', function(){
        CloneSchedule(schedulesContainer, newScheduleBtn);
    });

    confirmBtn.onclick = function(){
        let record = [];
        switch (table_name) {
            case 'programa':
                {
                    // record.push(form.querySelector('#nombre_programa').value);
                    // record.push(form.querySelector('#fileInput').value);
                    // record.push(form.querySelector('#descripcion').value);
                    // record.push(form.querySelector('#nombre_programa').value);
                    // record.push(form.querySelector('#nombre_programa').value);
                }
                break;
        
            default:
                break;
        }
        CreateContent(table_name, )
    }
}

// Muestra al modal de eliminacion
function ShowConfirmationModal(content, pk) {
    deleteModal.style.display = "block";
    let cancelBtn = deleteModal.querySelector('#cancelBtn');

    cancelBtn.onclick = function(){ 
        HideModal(deleteModal);
    };

    current_content = content;
    current_pk = pk;
}

function showUpdateForm(table_name, primary_key, field, current_value, type){
    let file;
    let confirmBtn = SetupModal(type);

    let update_label = input.querySelector('LABEL');
    if(!(type === 'enum' || type === 'boolean'));
        let update_input = input.querySelector('INPUT');

    switch (type) {
        case 'text':
            update_label.textContent = field;
            update_input.value = current_value;
            break;
        case 'password':
            update_label.textContent = "Password";
            update_input.value = "";
            break;
        case 'image':
            update_label.textContent = "Imagen";
            break;
        case 'enum':
            {
                update_label.textContent = field;
                update_input = input.querySelector('#enumContent');
                update_input.setAttribute('name', field);
                let args = "user,rol"
                fetch("jsRequest.php", {
                    method: "POST",
                    headers: {
                      "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "GetEnumValues=" + encodeURIComponent(args)
                })
                .then(response => response.json())
                .then(data => {
                    
                    data.forEach(option => {
                        let optionTag = document.createElement('option');
                        optionTag.value = option;
                        optionTag.textContent = option;
                        if(current_value === option)
                            optionTag.selected = true;
                        update_input.appendChild(optionTag);
                    });
                    
                })
                .catch(error => console.error("Error:", error));
            }
            break;
        case 'boolean':
            update_label.textContent = field.replace('_', ' ');
            update_input = input.querySelector('#radioMaster');
            update_input.setAttribute('name', field);
            let update_inputs = input.querySelectorAll('.radio');
            update_inputs.forEach(element => {
                element.onclick = function(){
                    update_input.value = element.value;
                };
            });
            if(parseInt(current_value, 10))
                update_inputs[0].checked = true;
            else
                update_inputs[1].checked = true;
            break;
    }

    confirmBtn.onclick = function(){
        if(type === 'image')
            UpdateImg(table_name, primary_key, field, file);
        else
            UpdateContent(table_name, primary_key, field, update_input.value);
    }
}

function showUpdateSchedules(primary_key, days, inicio_fin, retra){
    let confirmBtn = SetupModal("schedules");
    let days_list = input.querySelector('.days_list');
    let hora_inputs = input.querySelectorAll('[type="time"]');
    let checkbox = input.querySelector('[type="checkbox"]');

    days = days.replace(/'/g, '"');
    daysParsed = JSON.parse(days);
    let args = "horario,dia_semana"
    fetch("jsRequest.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "GetEnumValues=" + encodeURIComponent(args)
    })
    .then(response => response.json())
    .then(data => {    
        data.forEach(option => {
            let optionTag = document.createElement('li');
            optionTag.textContent = option;
            // flag = 0;
            // daysParsed.forEach(day => {
            //     if(option === day){
            //         flag = 1;
                    
            //     }
            // });
            flag = daysParsed.some(day => option === day) ? 1 : 0;
            if(flag)
                optionTag.classList.add('selected');
            days_list.appendChild(optionTag);
        });
        
    })
    .catch(error => console.error("Error:", error));

    isDragging = false;

    let minutes = inicio_fin.split(',');
    let inicio = ToHours(minutes[0]);
    let fin = ToHours(minutes[1]);

    hora_inputs[0].value = inicio;
    hora_inputs[1].value = fin;

    checkbox.checked = parseInt(retra, 10);

    confirmBtn.addEventListener('click', function(){
        let selected = [];
        
        days_list.querySelectorAll('.selected').forEach((li) => {
            selected.push(li.textContent);
        });
        let str_selected = selected.join(',');

        inicio += ',' + hora_inputs[0].value;
        fin += ',' + hora_inputs[1].value;

        updateSchedules(primary_key, str_selected, inicio, fin, checkbox.checked);
    });
}

function ShowUpdateList(primary_key, table_name, selected, available){
    let confirmBtn = SetupModal("list");
    available = available.replace(/'/g, '"');
    let selectedParsed = JSON.parse(selected);
    let availableParsed = JSON.parse(available);

    let table_name_list = null;

    switch (table_name) {
        case "programa_presentador":
            availableParsed.forEach(function(optionList) { // Crea los <li>
                let li = document.createElement('li');
                // li.setAttribute('name_t', "presentador");
                table_name_list = "presentador";
                li.setAttribute('id', optionList.id_presentador);
                li.textContent = optionList.nombre_presentador;
                flag = false;
                selectedParsed.forEach(element => {
                    if(element === optionList.id_presentador)
                        flag = true;
                });
                if(flag){
                    li.classList.add('selected');
                    optionsSelected.appendChild(li);
                }
                else{
                    optionsAvailable.appendChild(li);
                }
            });
            break;
        case "programa_genero":
            availableParsed.forEach(function(optionList) { // Crea los <li>
                let li = document.createElement('li');
                // li.setAttribute('name_t', "genero");
                table_name_list = "genero";
                li.setAttribute('id', optionList.id_genero);
                li.textContent = optionList.nombre_genero;
                optionsAvailable.appendChild(li);
                flag = false;
                selectedParsed.forEach(element => {
                    if(element === optionList.id_genero)
                        flag = true;
                });
                if(flag){
                    li.classList.add('selected');
                    optionsSelected.appendChild(li);
                }
                else{
                    optionsAvailable.appendChild(li);
                }
            });
            break;
    }
    confirmBtn.addEventListener('click', function(){
        let selected = [];
        
        optionsSelected.querySelectorAll('li').forEach((li) => {
            selected.push(li.getAttribute('id'));
            // table_name_list = li.getAttribute('name_t');
        });
        let str_selected = selected.join(',');
        UpdateRelationships(table_name ,primary_key, table_name_list, str_selected);
    });
}

function CreateContent(content, record) {
    fetch("createContent.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: encodeURIComponent(content) + '=' + encodeURIComponent(pk)
    })
    .then(response => response.text())
    .then(data => {
        // console.log("Respuesta del servidor:", data);
        // Recargar la página después de enviar los datos exitosamente
        window.location.href = window.location.pathname;
    })
    .catch(error => {
        console.error("Error:", error);
    });
}

// Encargada de enviar la informacion al archivo php que se encarga de eliminar
function DeleteContent(content, pk) {
    fetch("deleteContent.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: encodeURIComponent(content) + '=' + encodeURIComponent(pk)
    })
    .then(response => response.text())
    .then(data => {
        // console.log("Respuesta del servidor:", data);
        // Recargar la página después de enviar los datos exitosamente
        window.location.href = window.location.pathname;
    })
    .catch(error => {
        console.error("Error:", error);
    });
}

function UpdateContent(table_name, primary_key, field, value) {
    fetch("updateContent.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: '0' + '=' + encodeURIComponent(table_name) + 
            "&1" + '=' + encodeURIComponent(primary_key) + 
            "&2" + '=' + encodeURIComponent(field) + 
            "&3" + '=' + encodeURIComponent(value)
    })
    .then(response => response.text())
        .then(data => {
            // console.log("Respuesta del servidor:", data);
            // Recargar la página después de enviar los datos exitosamente
            window.location.href = window.location.href;
        })
        .catch(error => {
        console.error("Error:", error);
    });
}

function UpdateImg(table_name, primary_key, field, file) {
    // Crear un objeto FormData
    let formData = new FormData();
    //FILES
    formData.append('fileToUpload', file); // Añadir el archivo de imagen al FormData
    //POST
    formData.append('table_name', table_name);
    formData.append('primary_key', primary_key);
    formData.append('field', field);

    // Hacer la petición fetch con el FormData
    fetch('updateContent.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text()) // Procesar la respuesta como texto
    .then(data => {
        // message.textContent = data; // Mostrar el mensaje del servidor
        window.location.href = window.location.href;
    })
    .catch(error => {
        console.error('Error al subir la imagen:', error);
        message.textContent = 'Hubo un error al subir la imagen.';
    });
}

function updateSchedules(primary_key, days, inicio, fin, retra){
    fetch("updateContent.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "id=" + encodeURIComponent(primary_key) +
        "&days=" + encodeURIComponent(days) +
        "&inicio=" + encodeURIComponent(inicio) +
        "&fin=" + encodeURIComponent(fin) +
        "&retra=" + encodeURIComponent(retra)
    })
    .then(response => response.text())
    .then(data => {
        window.location.href = window.location.href;
    })
    .catch(error => {
    console.error("Error:", error);
    });
}

function UpdateRelationships(table_name ,primary_key, table_name_list, str_selected){
    fetch("updateContent.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "0=" + encodeURIComponent(table_name) +
        "&id_programa" + '=' + encodeURIComponent(primary_key) +
        '&' + encodeURIComponent(table_name_list) + '=' + encodeURIComponent(str_selected)
    })
    .then(response => response.text())
    .then(data => {
        window.location.href = window.location.href;
    })
    .catch(error => {
        console.error("Error:", error);
    });
}
