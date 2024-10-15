const modals_container = document.getElementById('modals_container');
let isDragging = false;

let currentLayer;
const layers = [];

export function GetInputValues(input){
    const data = [];
    let inputType = input.getAttribute('inputType');
    switch (inputType) {
        case 'text':
        case 'email':
        case 'password':
            {
                let inputTag = input.querySelector('INPUT');
                let keyvalue = {name: inputTag.id, value: inputTag.value};
                data.push(keyvalue);
            }
            break;
        case 'textarea':
            {
                let inputTag = input.querySelector('TEXTAREA');
                let keyvalue = {name: inputTag.id, value: inputTag.value};
                data.push(keyvalue);
            }
            break;
        case 'file':
            {
                let inputTag = input.querySelector('INPUT');
                let keyvalue = {name: inputTag.id, value: inputTag.files[0]};
                data.push(keyvalue);
            }
            break;
        case 'enum':
            {
                let inputTag = input.querySelector('SELECT');
                let keyvalue = {name: inputTag.id, value: inputTag.value};
                data.push(keyvalue);
            }
            break;
        case 'boolean':
            {
                let inputTag = input.querySelector('INPUT');
                let checkbox = inputTag.checked;
                let keyvalue = {name: inputTag.id, value: checkbox.toString().toUpperCase()};
                data.push(keyvalue);
            }
            break;
        case 'schedules':
            {
                // let data = [
                //     {name: "horarios[0][dias]", value: "Lunes,Martes"},
                //     {name: "horarios[0][hora_inicio]", value: "11:00"},
                //     {name: "horarios[0][hora_fin]", value: "12:00"},
                //     {name: "horarios[0][es_retransmision]", value: "0"},
                //     {name: "horarios[1][dias]", value: "Miércoles,Jueves"},
                //     {name: "horarios[1][hora_inicio]", value: "20:00"},
                //     {name: "horarios[1][hora_fin]", value: "09:00"},
                //     {name: "horarios[1][es_retransmision]", value: "0"}
                // ];
                // data.forEach(datum => {
                //     formData.append(datum.name, datum.value);
                // });
                // data.push({name: "horarios[0][dias]", value: "Lunes,Martes"});

                let schedulesContainer = input.querySelector('#schedules_container');
                
                let schedules = schedulesContainer.querySelectorAll('.schedule');

                let scheduleIndex = 0;
                schedules.forEach(schedule => {                    
                    let daysSelected = schedule.querySelectorAll('.selected');
                    let arrayDays = [];
                    daysSelected.forEach(day => {
                        arrayDays.push(day.textContent);
                    });
                    let strDays = arrayDays.join(',');
                    data.push({name: "horarios[" + scheduleIndex + "][dias]", value: strDays});

                    let hora_inicio = schedule.querySelector('.hora_inicio').value;
                    data.push({name: "horarios[" + scheduleIndex + "][hora_inicio]", value: hora_inicio});

                    let hora_fin = schedule.querySelector('.hora_fin').value;
                    data.push({name: "horarios[" + scheduleIndex + "][hora_fin]", value: hora_fin});

                    let es_retra = schedule.querySelector('.es_retransmision').checked;
                    data.push({name: "horarios[" + scheduleIndex + "][es_retransmision]", value: es_retra})

                    scheduleIndex++;
                });
            }
            break;
        case 'list':
            {
                let optionsSelected = input.querySelectorAll('.selected');
                let contentName = input.id;
                let ids = [];
                optionsSelected.forEach(options => {
                    ids.push(options.id);
                });
                data.push({name: contentName, value: ids.join(',')});
            }
            break;
    }

    return data;
}

export function SumbitCreateRequest(contentName, inputs, cancelBtn){
    let formData = new FormData();
    formData.append('contentName', contentName);

    inputs.forEach(input => {
        let data = GetInputValues(input);
        data.forEach(datum => {
            formData.append(datum.name, datum.value);
        });
    });

    
    // //FILES
    // formData.append('fileToUpload', file); // Añadir el archivo de imagen al FormData
    // //POST
    // formData.append('table_name', table_name);
    // formData.append('primary_key', primary_key);
    // formData.append('field', field);

    // Hacer la petición fetch con el FormData
    fetch('createContent.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // Procesar la respuesta como texto
    .then(data => {
        cancelBtn.click();

        let table = document.querySelector('[table_for="' + contentName + '"]');
        // let 
        if(table){
            let tbody = table.querySelector('tbody');
            let tableHeader = tbody.querySelector('.tableHeader');
            let trElement = document.createElement('tr');
            trElement.classList.add('values');
            trElement.classList.add('rowfadein');

            let tdForID = document.createElement('td');
            tdForID.classList.add('pk');
            tdForID.textContent = data.id;
            trElement.appendChild(tdForID);

            let tdForName = document.createElement('td');
            tdForName.classList.add('name');
            tdForName.textContent = data.name;
            trElement.appendChild(tdForName);

            trElement.addEventListener('click', function () {
                window.location.href = window.location.pathname + '?' + contentName + '=' + data.id;
            });

            // table.appendChild(trElement);
            tbody.insertBefore(trElement, tableHeader.nextSibling);

            // window.location.href = window.location.pathname + "#new";
            setTimeout(function(){
                trElement.classList.remove('rowfadein');
            }, 1000);
        }
        
    })
    .catch(error => {
        console.error('Error al subir la imagen:', error);
    });
}

export function SumbitUpdateRequest(contentName, pk, fieldName, input){
    let formData = new FormData();
    formData.append('contentName', contentName);
    formData.append('pk', pk);
    formData.append('fieldName', fieldName);
    let data = GetInputValues(input);
    data.forEach(datum => {
        formData.append((contentName === 'horario' ? datum.name : 'newValue'), datum.value);
    });

    if(contentName === 'horario')
        formData.append('prevTimes', input.querySelector('.times_container').getAttribute('prevTimes'));

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
    });
}

// Encargada de enviar la informacion al archivo php que se encarga de eliminar
export function SubmitDeleteRequest(contentName, pk) {
    let formData = new FormData();
    formData.append('contentName', contentName);
    formData.append('pk', pk);

    fetch('deleteContent.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text()) // Procesar la respuesta como texto
    .then(data => {
        // message.textContent = data; // Mostrar el mensaje del servidor
        window.location.href = window.location.pathname;
    })
    .catch(error => {
        console.error('Error al subir la imagen:', error);
    });

    // fetch("deleteContent.php", {
    //     method: "POST",
    //     headers: {
    //       "Content-Type": "application/x-www-form-urlencoded"
    //     },
    //     body: encodeURIComponent(content) + '=' + encodeURIComponent(pk)
    // })
    // .then(response => response.text())
    // .then(data => {
    //     // console.log("Respuesta del servidor:", data);
    //     // Recargar la página después de enviar los datos exitosamente
    //     window.location.href = window.location.pathname;
    // })
    // .catch(error => {
    //     console.error("Error:", error);
    // });
}

export function AddContent(e, contentName){
    const modal = CreateModal();
    const modal_content = modal.querySelector('.container');
    const btns_container = modal.querySelector('.btns_container');

    const cancelBtn = btns_container.querySelector('#cancelBtn');
    const confirmBtn = btns_container.querySelector('#confirmBtn');

    // const origianl_form = original_forms.querySelector('#' + content);
    // let current_form = origianl_form.cloneNode(true);
    let inputs = [];

    const contents = {
        programa: [
            {inputType:'text', id:'nombre_programa', classes:[], title:'Nombre del programa' , tableName: contentName},
            {inputType:'file', id:'url_imagen', classes:[], title:'Imagen del programa', tableName: contentName},
            {inputType:'textarea', id:'descripcion', classes:[], title:'Descripcion', tableName: contentName},
            {inputType:'schedules', id:'horario', classes:[], title:'Horarios', tableName: contentName},
            {inputType:'list', id:'presentador', classes:[], title:'Presentadores', tableName: contentName},
            {inputType:'list', id:'genero', classes:[], title:'Generos', tableName: contentName},
        ],
        horario: [
            {inputType:'text', id:'id_programa', classes:[], title:'id del programa', tableName: contentName},
            {inputType:'schedules', id:'horario', classes:[], title:'Horarios', tableName: contentName},
        ],
        presentador: [
            {inputType:'text', id:'nombre_presentador', classes:[], title:'Nombre presentador' , tableName: contentName},
            {inputType:'file', id:'url_foto', classes:[], title:'foto del presentador', tableName: contentName},
            {inputType:'textarea', id:'biografia', classes:[], title:'Biografia', tableName: contentName},
        ],
        genero: [
            {inputType:'text', id:'nombre_genero', classes:[], title:'Nombre del genero' , tableName: contentName},
        ],
        user: [
            {inputType:'text', id:'username', classes:[], title:'Nombre de usuario' , tableName: contentName},
            {inputType:'email', id:'email', classes:[], title:'correo de usuario' , tableName: contentName},
            {inputType:'password', id:'password', classes:[], title:'contraseña' , tableName: contentName},
            {inputType:'text', id:'nombre_completo', classes:[], title:'Nombre completo' , tableName: contentName},
            {inputType:'enum', id:'rol', classes:[], title:'Rol del usuario' , tableName: contentName},
            {inputType:'boolean', id:'cuenta_activa', classes:[], title:'Cuenta Activa' , tableName: contentName},
        ]
    };

    switch (contentName) {
        case 'programa':
            contents.programa.forEach(input => {
                inputs.push(CreateInput(input.inputType, input.id, input.classes, input.title, input.tableName));
            });
            break;
        case 'horario':
            contents.horario.forEach(input => {
                inputs.push(CreateInput(input.inputType, input.id, input.classes, input.title, input.tableName));
            });
            let inputId = inputs[0].querySelector('#id_programa');
            inputId.value = e.target.id;
            inputId.readOnly = true;
            inputs[0].style.display = 'none';
            break;
        case 'presentador':
            contents.presentador.forEach(input => {
                inputs.push(CreateInput(input.inputType, input.id, input.classes, input.title, input.tableName));
            });
            break;
        case 'genero':
            contents.genero.forEach(input => {
                inputs.push(CreateInput(input.inputType, input.id, input.classes, input.title, input.tableName));
            });
            break;
        case 'user':
            contents.user.forEach(input => {
                inputs.push(CreateInput(input.inputType, input.id, input.classes, input.title, input.tableName));
            });
            break;
    }

    inputs.forEach(input => {
        modal_content.insertBefore(input, btns_container); 
    });

    confirmBtn.addEventListener('click', function(){
        SumbitCreateRequest(contentName, inputs, cancelBtn);
    });
}

export function CreateInput(inputType, id, classes, inputTitle, tableName){
    let container = document.createElement('div');
    classes.forEach(input_class => {
        container.classList.add(input_class);
    });

    let label = document.createElement('label');
    label.textContent = inputTitle;
    label.setAttribute('for', id);

    container.appendChild(label);

    container.setAttribute('inputType', inputType);

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
                input.id = "fileToUpload";
                input.accept = 'image/*';
                element.appendChild(input);

                let feedback_file = document.createElement('div');
                feedback_file.id = 'feedback_file';
                element.appendChild(feedback_file);
                
                InputFileManager(element);
                break;
            }
        case 'enum':
            {
                element = document.createElement('select');
                element.id = id;
                element.classList.add('selectList');

                EnumToList(element, tableName, id, 'option');
                // let opcion = document.createElement('option');
                // opcion.textContent = 'Admin';
                // element.appendChild(opcion);
                // let opcion2 = document.createElement('option');
                // opcion2.textContent = 'Editor';
                // element.appendChild(opcion2);
                // let opcion3 = document.createElement('option');
                // opcion3.textContent = 'Moderador';
                // element.appendChild(opcion3);
                    

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

                let schedule = document.createElement('div');
                // originalSchedule.id = 'originalschedule';
                schedule.classList.add('schedule');
                element.appendChild(schedule);

                schedule.addEventListener('click', CheckSchedules);
                schedule.addEventListener('keyup', CheckSchedules);

                let daysContainer = document.createElement('div');
                daysContainer.classList.add('days_container');
                schedule.appendChild(daysContainer);

                let daysList = document.createElement('ul');
                daysList.classList.add('days_list');
                daysContainer.appendChild(daysList);

                EnumToList(daysList, 'horario', 'dia_semana', 'li');
                DaysSelectionSystem(daysList);

                let timesContainer = document.createElement('div');
                timesContainer.classList.add('times_container');

                let labelHoraInicio = document.createElement('label');
                labelHoraInicio.textContent = "Hora inicio";
                timesContainer.appendChild(labelHoraInicio);

                let inputHoraInicio = document.createElement('input');
                inputHoraInicio.type = 'time';
                inputHoraInicio.classList.add('hora_inicio');
                timesContainer.appendChild(inputHoraInicio);

                let labelHoraFin = document.createElement('label');
                labelHoraFin.textContent = "Hora final";
                timesContainer.appendChild(labelHoraFin);

                let inputHoraFin = document.createElement('input');
                inputHoraFin.type = 'time';
                inputHoraFin.classList.add('hora_fin');
                timesContainer.appendChild(inputHoraFin);

                schedule.appendChild(timesContainer);

                let labelRetransmision = document.createElement('label');
                labelRetransmision.textContent = "Es retrasmision";
                schedule.appendChild(labelRetransmision);

                let inputRetransmision = document.createElement('input');
                inputRetransmision.type = 'checkbox';
                inputRetransmision.classList.add('es_retransmision');
                schedule.appendChild(inputRetransmision);

                let feedbackSchedules = document.createElement('div');
                feedbackSchedules.classList.add('feedback_schedules');
                schedule.appendChild(feedbackSchedules);

                let addNewScheduleButton = document.createElement('button');
                addNewScheduleButton.id = 'addNewSchedule';
                addNewScheduleButton.textContent = "añadir nuevo horario";
                element.appendChild(addNewScheduleButton);
                
                addNewScheduleButton.addEventListener('click', function(){
                    CloneSchedule(element, schedule, this);
                });
                break;
            }
        case 'list':
            {
                container.id = id;
                element = document.createElement('div');
                element.classList.add('lists-container');

                let divSelected = document.createElement('div');
                element.appendChild(divSelected);

                let h3Selected = document.createElement('h3');
                h3Selected.textContent = "Seleccionados";
                divSelected.appendChild(h3Selected);

                let createBtn = document.createElement('button');
                createBtn.classList.add('modalBtn');
                createBtn.classList.add('createBtn');
                let subContentName = tableName.split("_")[1];

                createBtn.setAttribute('contentName', subContentName);
                createBtn.textContent = "Crear " + subContentName;

                createBtn.addEventListener('click', function(e){
                    AddContent(e, subContentName);
                });

                divSelected.appendChild(createBtn);

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

function HideModal(modal){
    if(layers[layers.length - 1] === currentLayer){
        console.log("Closing...");
        modal.querySelector('.modal-content').classList.add('fadeout');
        layers.pop();
        setTimeout(function() {
            modal.style.display = 'none';
            modal.remove();
            if(layers){
                currentLayer = layers[layers.length - 1];
            }
        }, 300);
    }
}

function SetupModal(modal){
    let currentModal = modal;

    currentModal.style.display = 'block';

    setTimeout(function() {
        let xBtn = currentModal.querySelector('.close');
        xBtn.addEventListener('click', () => {
            HideModal(currentModal);
        });

        let cancelBtn = currentModal.querySelector('#cancelBtn');
        cancelBtn.addEventListener('click', () => {
            HideModal(currentModal);
        });

        window.addEventListener('click', (event) => {
            if(event.target === currentModal){
                HideModal(currentModal);
            }
        });
    }, 400);

    modals_container.appendChild(currentModal);
    layers.push(currentModal);
    currentLayer = currentModal;
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
    // confirmBtn.addEventListener('click', function () {
    //     CreateModal();
    // });
    btns_container.appendChild(confirmBtn);

    // let originalModal = modals_container.querySelector('.originalModal');

    
    // let replicant = originalModal.cloneNode(true);
    // replicant.classList.remove('originalModal');

    // let confirmBtn = replicant.querySelector('#confirmBtn');

    // confirmBtn.addEventListener('click', function(){
    //     CreateModal();
    // });

    SetupModal(modal);
    return modal;
}

let requestEvent;
let listener;

export function CreateEvent(element, eventName, detail) {
    requestEvent = new CustomEvent(eventName, {
        detail: detail
    });

    listener = element;
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
        if(listener) listener.dispatchEvent(requestEvent);
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
        // Despachar el evento en el elemento especificado
        if(listener) listener.dispatchEvent(requestEvent);
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
    const checkbox = replicant.querySelector('.es_retransmision');

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
        // element.addEventListener('click', function() {
        //     // Alternar la clase 'selected' al hacer clic
        //     this.classList.toggle('selected');
        // });
    });
    
    // agregar el bloque a contenedor padre
    // times_container.appendChild(replicant);
    schedulesContainer.insertBefore(replicant, newScheduleBtn);
    replicants.push(replicant);
}

export function InputFileManager(input_file){
    // const dropZone = input_file.querySelector('#drop-zone');
    const actual_input = input_file.querySelector('[type="file"]')
    const feedback = input_file.querySelector('#feedback_file');
    
    // Cambiar apariencia del área de arrastre cuando el archivo está sobre ella
    // dropZone.addEventListener('dragover', (e) => {
    //         e.preventDefault();
    //         dropZone.classList.add('dragover');
    // });

    // dropZone.addEventListener('dragleave', (e) => {
    //     e.preventDefault();
    //     dropZone.classList.remove('dragover');
    // });

    // Manejar el evento de soltar
    // dropZone.addEventListener('drop', (e) => {
    //     e.preventDefault();
    //     dropZone.classList.remove('dragover');

    //     // Obtener archivo soltado
    //     const files = e.dataTransfer.files;
    //     if (files.length) {
    //         console.log("asd");
    //         actual_input.files = files; // Asignar archivos al input file
    //         // Disparar manualmente el evento change
    //         const event = new Event('change', { bubbles: true });
    //         actual_input.dispatchEvent(event);
    //         // dropZone.textContent = actual_input.files[0].name;
    //     }
    // });

    // Hacer clic en el área de arrastre para seleccionar archivos
    // dropZone.onclick = () => {
    //     actual_input.click();
    // };

    actual_input.addEventListener('change', function(event) {
        let fileInput = event.target;
        let file = fileInput.files[0]; // Obtener el archivo seleccionado
        feedback.textContent = ''; // Limpiar mensaje previo

        // if (actual_input.files.length) {
        //     dropZone.textContent = file.name;
        // }
        
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

export function DSetupModal(type){ // deprecated <====================
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

export function DHideModal(modal){
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
