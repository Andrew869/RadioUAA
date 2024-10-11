let isDragging = false;

export function CreateInput(inputType, id, classes, inputTitle, tableName){
    let container = document.createElement('div');
    classes.forEach(input_class => {
        container.classList.add(input_class);
    });

    let label = document.createElement('label');
    label.textContent = inputTitle;
    label.setAttribute('for', id);

    container.appendChild(label);

    let element;
    switch (inputType) {
        case 'text':
        case 'email':
        case 'password':
            {
                element = document.createElement('input');
                element.type = inputType;
                element.id = id;
                // input.setAttribute('name', id);
                break;
            }
        case 'textarea':
            {
                element = document.createElement('textarea');
                // input.type = inputType;
                element.id = id;   
                break;
            }
        case 'file':
            {
                element = document.createElement('div');
                let input = document.createElement('input');
                input.type = inputType;
                input.id = id;
                input.accept = 'image/*';
                element.appendChild(input);

                let feedback_file = document.createElement('div');
                feedback_file.id = 'feedback_file';
                element.appendChild(feedback_file);
                break;
            }
        case 'enum':
            {
                element = document.createElement('select');
                element.id = 'enumContent';

                EnumToList(element, tableName, id, 'option');

                break;
            }
        case 'boolean':
            {
                element = document.createElement('input');
                element.type = 'checkbox';
                element.id = id;
                element.checked = true;
                break;
            }
        case 'schedules':
            {
                element = document.createElement('div');
                element.id = 'schedules_container';

                let originalSchedule = document.createElement('div');
                // originalSchedule.id = 'originalschedule';
                originalSchedule.classList.add('schedule');
                element.appendChild(originalSchedule);

                originalSchedule.addEventListener('click', CheckSchedules);
                originalSchedule.addEventListener('keyup', CheckSchedules);

                let daysContainer = document.createElement('div');
                daysContainer.classList.add('days_container');
                originalSchedule.appendChild(daysContainer);

                let daysList = document.createElement('ul');
                daysList.classList.add('days_list');
                daysContainer.appendChild(daysList);

                EnumToList(daysList, 'horario', 'dia_semana', 'li');
                DaysSelectionSystem(daysList);

                let labelHoraInicio = document.createElement('label');
                labelHoraInicio.textContent = "Hora inicio";
                originalSchedule.appendChild(labelHoraInicio);

                let inputHoraInicio = document.createElement('input');
                inputHoraInicio.type = 'time';
                inputHoraInicio.id = 'hora_inicio';
                originalSchedule.appendChild(inputHoraInicio);

                let labelHoraFin = document.createElement('label');
                labelHoraFin.textContent = "Hora final";
                originalSchedule.appendChild(labelHoraFin);

                let inputHoraFin = document.createElement('input');
                inputHoraFin.type = 'time';
                inputHoraFin.id = 'hora_fin';
                originalSchedule.appendChild(inputHoraFin);

                let labelRetransmision = document.createElement('label');
                labelRetransmision.textContent = "Es retrasmision";
                originalSchedule.appendChild(labelRetransmision);

                let inputRetransmision = document.createElement('input');
                inputRetransmision.type = 'checkbox';
                inputRetransmision.id = 'es_retransmision';
                originalSchedule.appendChild(inputRetransmision);

                let feedbackSchedules = document.createElement('div');
                feedbackSchedules.classList.add('feedback_schedules');
                originalSchedule.appendChild(feedbackSchedules);

                let addNewScheduleButton = document.createElement('button');
                addNewScheduleButton.id = 'addNewSchedule';
                addNewScheduleButton.textContent = "añadir nuevo horario";
                element.appendChild(addNewScheduleButton);
                
                addNewScheduleButton.addEventListener('click', function(){
                    CloneSchedule(element, originalSchedule, this);
                });
                break;
            }
        case 'list':
            {
                element = document.createElement('div');
                element.classList.add('lists-container');

                let divSelected = document.createElement('div');
                element.appendChild(divSelected);

                let h3Selected = document.createElement('h3');
                h3Selected.textContent = "Seleccionados";
                divSelected.appendChild(h3Selected);

                let ulSelected = document.createElement('ul');
                ulSelected.id = 'optionsSelected';
                ulSelected.classList.add('options');
                divSelected.appendChild(ulSelected);

                let divAvailable = document.createElement('div');
                element.appendChild(divAvailable);

                let h3Available = document.createElement('h3');
                h3Available.textContent = "Disponibles";
                divAvailable.appendChild(h3Available);

                let ulAvailable = document.createElement('ul');
                ulAvailable.id = 'optionsAvailable';
                ulAvailable.classList.add('options');
                divAvailable.appendChild(ulAvailable);

                GetList(ulAvailable, id);
                ListSelectionSystem(ulSelected, ulAvailable);
            }
            break;
        default:
            break;
    }
    container.appendChild(element);

    return container;
}

export function CreateModal(){
    let modal = document.createElement('div');
    modal.classList.add('modal');

    let xBtn = document.createElement('span');
    xBtn.classList.add('close');
    xBtn.innerHTML = '&times;';
    modal.appendChild(xBtn);

    let content = document.createElement('div')
    content.classList.add('modal-content');
    modal.appendChild(content);

    let container = document.createElement('div');
    container.classList.add('container')
    content.appendChild(container);

    let btns_container = document.createElement('div');
    btns_container.classList.add('btns_container')
    container.appendChild(btns_container);

    let cancelBtn = document.createElement('button');
    cancelBtn.type = 'button';
    cancelBtn.id = 'cancelBtn';
    cancelBtn.classList.add('modalBtn');
    cancelBtn.textContent = 'Cancelar';
    btns_container.appendChild(cancelBtn);

    let confirmBtn = document.createElement('button');
    confirmBtn.type = 'button';
    confirmBtn.id = 'confirmBtn';
    confirmBtn.classList.add('modalBtn');
    confirmBtn.textContent = 'Confirmar';
    btns_container.appendChild(confirmBtn);

    return modal;
}

function GetList(container, tableName){
    let args = tableName;
    let list;
    fetch("jsRequest.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "GetList=" + encodeURIComponent(args)
    })
    .then(response => response.json())
    .then(data => {    
        data.forEach(option => {
            let optionTag;
            switch (tableName) {
                case "presentador":
                    optionTag = document.createElement('li');
                    optionTag.setAttribute('id', option.id_presentador);
                    optionTag.textContent = option.nombre_presentador;
                    container.appendChild(optionTag);
                    break;
                case "genero":
                    optionTag = document.createElement('li');
                    optionTag.setAttribute('id', option.id_genero);
                    optionTag.textContent = option.nombre_genero;
                    container.appendChild(optionTag);
                    break;
            }
        });
    })
    .catch(error => console.error("Error:", error));
}

function EnumToList(container, tableName, fieldName, tagName){
    let args = tableName + ',' + fieldName;
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
            let optionTag = document.createElement(tagName);
            optionTag.textContent = option;
            container.appendChild(optionTag);
        });
        
    })
    .catch(error => console.error("Error:", error));
}

export function CheckSchedules(e) {
    let selected = [];
    let feedback = e.currentTarget.querySelector(".feedback_schedules");
    e.currentTarget.querySelectorAll('.selected').forEach(function(item) {
        selected.push(item.textContent);
    });

    // let times = e.currentTarget.querySelectorAll('[type="time"]').forEach(element => {
    //     console.log(element.value);
    // });

    let times = e.currentTarget.querySelectorAll('[type="time"]')


    // console.log(e.currentTarget.tagName);

    if (!selected.length || times[0].value === "" || times[1].value === "") {
        feedback.innerHTML = "Completa todos los campos del horario";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                feedback.innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","checkSchedules.php?dias=" + selected.join(',') + "&hora_inicio=" + times[0].value + "&hora_fin=" + times[1].value ,true);
        xmlhttp.send();
    }
}

export function CloneSchedule(schedulesContainer, originalschedule, newScheduleBtn) {
    // Clonar el bloque (con sus hijos)
    const replicant = originalschedule.cloneNode(true);
    const inputs = replicant.querySelectorAll('input');
    const checkbox = replicant.querySelector('#es_retransmision');

    replicant.addEventListener('click', CheckSchedules);
    replicant.addEventListener('keyup', CheckSchedules);

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

export function InputFileManager(input_file){
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

export function DaysSelectionSystem(days_list){
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
    window.addEventListener('mouseup', function(){
        isDragging = false;
    });
}

export function SwapInOrden(current_opction, target_list){
    let flag = 1;
    let options = target_list.querySelectorAll('LI');
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

export function MoveOption(e, optionsSelected, optionsAvailable) {
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

export function ListSelectionSystem(optionsSelected, optionsAvailable){
    optionsSelected.addEventListener('click', function(e){
        MoveOption(e, optionsSelected, optionsAvailable);
    });
    optionsAvailable.addEventListener('click', function(e){
        MoveOption(e, optionsSelected, optionsAvailable);
    });
}

export function DeleteLists(){
    let opctions = input.querySelectorAll("LI");

    opctions.forEach(element => {
        element.remove();
    });
}

export function SetupModal(type){ // deprecated <====================
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

export function ToHours(minutes) {
    let hours = Math.floor(minutes / 60);
    let mins = minutes % 60;
    hours = hours < 10 ? '0' + hours : hours;
    mins = mins < 10 ? '0' + mins : mins;
    return hours + ':' + mins;
}

export function createModalExit(){
    createModal.style.display = 'none';

    let days = originalschedule.querySelectorAll('LI');

    days.forEach(day => {
        day.classList.remove('selected');
    });

    replicants.forEach(replicant => {
        replicant.remove();
    });
}

export function HideModal(modal){
    modal.style.display = 'none';
    // setTimeout(() => {
    // }, 500);
}

export function CreateContent(content, record) {
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
export function DeleteContent(content, pk) {
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

export function UpdateContent(table_name, primary_key, field, value) {
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

export function UpdateImg(table_name, primary_key, field, file) {
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

export function updateSchedules(primary_key, days, inicio, fin, retra){
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

export function UpdateRelationships(table_name ,primary_key, table_name_list, str_selected){
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
