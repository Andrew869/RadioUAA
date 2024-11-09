const modals_container = document.getElementById('modals_container');
let isDragging = false;

// Obtiene la ruta completa del archivo actual
const fullPath = window.location.pathname;

// Elimina la última barra si está en la raíz, y divide la ruta en segmentos
const segments = fullPath.endsWith('/') ? fullPath.slice(0, -1).split('/') : fullPath.split('/');

// Obtiene la carpeta anterior al archivo, o una cadena vacía si está en la raíz
const currentDir = segments.length > 1 ? segments[segments.length - 2] : '';

// console.log(currentDir);


let currentLayer = -1;
const layers = [];
const layersModalContent = [];
const layersInputsType = [];
const layersNumSchedules = [];

const dias_semana = {
    1: 'Lunes',
    2: 'Martes',
    3: 'Miércoles',
    4: 'Jueves',
    5: 'Viernes',
    6: 'Sábado',
    7: 'Domingo'
};

let resizeTimeout;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
        CheckHeights();  // Llama a la función que deseas ejecutar al redimensionar
    }, 200);
});

export function GetSVG(parentNode, url, styles){
    console.log(`seahorse ${window.location.pathname}`);
    let args = url + ',' + styles;
    fetch((currentDir === '' ? '' : "../" ) + "php/jsRequest.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "GetSVG=" + encodeURIComponent(args)
    })
    .then(response => response.text())
    .then(svgContent => {
        let [width, height, fill] = styles;

        // Reemplazar width
        svgContent = svgContent.replace(/width:\s*\d+px/, `width: ${width}`);

        // Verificar si el height ya está en el SVG
        if (svgContent.includes('height:')) {
            // Reemplazar el height si existe
            svgContent = svgContent.replace(/height:\s*\d+px/, `height: ${height}`);
        } else {
            // Agregar el height si no existe
            svgContent = svgContent.replace('<svg ', `<svg style="height: ${height}; " `);
        }

        // Reemplazar fill si existe, o agregarlo si no
        if (svgContent.includes('fill:')) {
            svgContent = svgContent.replace(/fill:\s*[^;]+/, `fill: ${fill}`);
        } else {
            // Si no existe, agregar fill al estilo
            svgContent = svgContent.replace('style="', `style="fill: ${fill}; `);
        }

        // Insertar el SVG en el nodo padre
        parentNode.innerHTML = svgContent;
    })
    .catch(error => console.log('Error al cargar imagen SVG:', error));
}

export function AddInputToCurrentLayer(modal_content, inputsType){
    layersModalContent.push(modal_content);
    layersInputsType.push(inputsType);
    // console.log(`types array length ${layersInputsType.length}`);
    // inputsType.forEach(element => {
    //     console.log(element);
    // });
}

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
                let schedulesContainer = input.querySelector('#schedules_container');
                
                let schedules = schedulesContainer.querySelectorAll('.schedule');

                let scheduleIndex = 0;
                schedules.forEach(schedule => {                    
                    let daysSelected = schedule.querySelectorAll('.selected');
                    let arrayDays = [];
                    daysSelected.forEach(day => {
                        arrayDays.push(day.getAttribute('id_day'));
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
                let contentName = input.getAttribute('contentName');
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
        let optionsSelected = document.querySelector('#selected_list_' + contentName);
        if(optionsSelected){
            // let optionsSelected = inputSelector.querySelector('#optionsSelected');

            let liElement = document.createElement('li');
            liElement.id = data.id;
            liElement.textContent = data.name;
            liElement.classList.add('selected');
            liElement.classList.add('rowfadein');

            optionsSelected.appendChild(liElement);

            setTimeout(function(){
                liElement.classList.remove('rowfadein');
            }, 1000);
        }
        else if(table){
            let tbody = table.querySelector('tbody');
            let tableHeader = tbody.querySelector('.tableHeader');
            let trElement = document.createElement('tr');
            trElement.classList.add('values');
            trElement.classList.add('rowfadein');

            let tdForID = document.createElement('td');
            tdForID.classList.add('contentId');
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
        console.error('Error al guardar la informacion:', error);
    });
}

export function SumbitUpdateRequest(contentName, contentId, fieldName, input){
    let formData = new FormData();
    formData.append('contentName', contentName);
    formData.append('contentId', contentId);
    formData.append('fieldName', fieldName);
    let data = GetInputValues(input);
    data.forEach(datum => {
        formData.append((contentName === 'horario' ? datum.name : 'newValue'), datum.value);
    });

    if(contentName === 'horario')
        formData.append('prevTimes', input.querySelectorAll('.input_time')[0].getAttribute('prevTimes'));

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

export function CheckHeights(){
    for (let index = 0; index < layers.length; index++) {
        let inputsHeight = 86; // Altura de los botones de cancel y confirm
    
        layersInputsType[index].forEach(inputType => {
            inputsHeight += GetInputHeight(inputType);
        });
    
        const height = window.innerHeight;
        let optimalHeight = height * 0.8
        console.log(`inputs height = ${inputsHeight} > optimal height = ${optimalHeight}`);
        if(inputsHeight > optimalHeight)
            layersModalContent[index].style.height = '90%';
        else
            layersModalContent[index].style.height = '';
    }
}

export function GetInputHeight(inputType){
    switch (inputType) {
        case 'text':
        case 'email':
        case 'password':
        case 'enum':
        case 'boolean':
            return 100;
        case 'file':
            return 140;
        case 'textarea':
            return 250;
        case 'schedules':
            return 350 + (280 * layersNumSchedules[currentLayer]);
        case 'list':
            return 300;
    }
}

export function AddContent(e, contentName){
    const modal = CreateModal();
    const modal_content = modal.querySelector('.modal-content');
    const container = modal.querySelector('.container');
    const btns_container = modal.querySelector('.btns_container');

    const cancelBtn = btns_container.querySelector('.cancelBtn');
    const confirmBtn = btns_container.querySelector('.confirmBtn');

    // const origianl_form = original_forms.querySelector('#' + content);
    // let current_form = origianl_form.cloneNode(true);

    const contents = {
        programa: [
            {inputType:'text', fieldName:'nombre_programa', classes:[], title:'Nombre del programa' , tableName: contentName, placeholder: "nombre..."},
            {inputType:'file', fieldName:'url_img', classes:[], title:'Imagen del programa', tableName: contentName, placeholder: ''},
            {inputType:'textarea', fieldName:'descripcion', classes:[], title:'Descripcion', tableName: contentName, placeholder: "descripcion..."},
            {inputType:'schedules', fieldName:'horario', classes:[], title:'Horarios', tableName: contentName, placeholder: ''},
            {inputType:'list', fieldName:'presentador', classes:[], title:'Presentadores', tableName: 'programa_presentador', placeholder: ''},
            {inputType:'list', fieldName:'genero', classes:[], title:'Generos', tableName: 'programa_genero', placeholder: ''},
        ],
        horario: [
            {inputType:'text', fieldName:'id_programa', classes:[], title:'id del programa', tableName: contentName, placeholder: ''},
            {inputType:'schedules', fieldName:'horario', classes:[], title:'Horarios', tableName: contentName, placeholder: ''},
        ],
        presentador: [
            {inputType:'text', fieldName:'nombre_presentador', classes:[], title:'Nombre presentador' , tableName: contentName, placeholder: "nombre..."},
            {inputType:'file', fieldName:'url_img', classes:[], title:'foto del presentador', tableName: contentName, placeholder: ''},
            {inputType:'textarea', fieldName:'biografia', classes:[], title:'Biografia', tableName: contentName, placeholder: "biografia..."},
        ],
        genero: [
            {inputType:'text', fieldName:'nombre_genero', classes:[], title:'Nombre del genero' , tableName: contentName, placeholder: "nombre..."},
        ],
        user: [
            {inputType:'text', fieldName:'username', classes:[], title:'Nombre de usuario' , tableName: contentName, placeholder: "username..."},
            {inputType:'email', fieldName:'email', classes:[], title:'correo de usuario' , tableName: contentName, placeholder: "nombre..."},
            {inputType:'password', fieldName:'password', classes:[], title:'contraseña' , tableName: contentName, placeholder: "password..."},
            {inputType:'text', fieldName:'nombre_completo', classes:[], title:'Nombre completo' , tableName: contentName, placeholder: "nombre completo..."},
            {inputType:'enum', fieldName:'rol', classes:[], title:'Rol del usuario' , tableName: contentName, placeholder: ''},
            {inputType:'boolean', fieldName:'cuenta_activa', classes:[], title:'Cuenta Activa' , tableName: contentName, placeholder: ''},
        ]
    };
    
    // let inputsHeight = 0;
    let inputs = [];
    let inputsType = [];
    contents[contentName].forEach(input => {
        inputsType.push(input.inputType);
        // inputsHeight += GetInputHeight(input.inputType);
        inputs.push(CreateInput(input.inputType, input.fieldName, input.classes, input.title, input.tableName, input.placeholder));
    });

    if(contentName === 'horario'){
        let inputId = inputs[0].querySelector('#id_programa');
        inputId.value = e.target.id;
        inputId.readOnly = true;
        inputs[0].style.display = 'none';
    }

    AddInputToCurrentLayer(modal_content, inputsType);

    CheckHeights();
    // let resizeTimeout;
    // window.addEventListener('resize', () => {
    //     clearTimeout(resizeTimeout);
    //     resizeTimeout = setTimeout(() => {
    //         CheckHeights();
    //     }, 200);
    // });

    inputs.forEach(input => {
        container.insertBefore(input, btns_container); 
    });

    confirmBtn.addEventListener('click', function(){
        SumbitCreateRequest(contentName, inputs, cancelBtn);
    });
}

export function CreateInput(inputType, fieldName, classes, inputTitle, tableName, placeholder){
    let container = document.createElement('div');
    container.classList.add('input_content');
    classes.forEach(input_class => {
        container.classList.add(input_class);
    });

    let label = document.createElement('label');
    label.classList.add('input_content__label');
    label.textContent = inputTitle;
    label.setAttribute('for', fieldName);

    container.appendChild(label);
    container.setAttribute('inputType', inputType);
    if(inputType !== 'schedules')
        container.style.height = GetInputHeight(inputType) + 'px';

    let element;
    switch (inputType) {
        case 'text':
        case 'email':
        case 'password':
            {
                element = document.createElement('input');
                element.type = inputType;
                element.id = fieldName;
                element.setAttribute('fieldName', fieldName);
                element.classList.add('input_content__input');
                element.placeholder = placeholder;
                // input.setAttribute('name', id);
                break;
            }
        case 'textarea':
            {
                element = document.createElement('textarea');
                // element.type = inputType;
                element.classList.add('input_content__input--textarea');
                element.id = fieldName;
                element.setAttribute('fieldName', fieldName);
                element.placeholder = placeholder;
                break;
            }
        case 'file':
            {
                element = document.createElement('div');
                let btnLabel = document.createElement('label');
                btnLabel.classList.add('button');
                // btnLabel.setAttribute('for', 'fileToUpload');
                btnLabel.textContent = 'Seleccionar archivo';

                element.appendChild(btnLabel);

                let input = document.createElement('input');
                input.classList.add('input_content__input--file');
                input.type = inputType;
                input.id = 'fileToUpload';
                input.accept = 'image/*';

                element.appendChild(input);

                let name_file = document.createElement('span');
                // feedback_file.id = 'feedback_file';
                name_file.classList.add('input_content__filename--file');
                name_file.textContent = 'No se ha seleccionado archivo';
                element.appendChild(name_file);

                let feedback_file = document.createElement('div');
                // feedback_file.id = 'feedback_file';
                feedback_file.classList.add('input_content__feedback--file');
                feedback_file.textContent = '';
                element.appendChild(feedback_file);

                
                InputFileManager(element);
                break;
            }
        case 'enum':
            {
                element = document.createElement('select');
                element.id = fieldName;
                element.setAttribute('fieldName', fieldName);
                element.classList.add('selectList');
                element.classList.add('input_content__input--select');

                EnumToList(element, tableName, fieldName, 'option');
                break;
            }
        case 'boolean':
            {
                label.className = 'input_content__label-checkbox';
                element = document.createElement('input');
                element.classList.add('input_content__input-checkbox');
                element.id = fieldName;
                element.setAttribute('fieldName', fieldName);
                element.type = 'checkbox';
                element.checked = true;
                break;
            }
        case 'schedules':
            {
                element = document.createElement('div');
                element.id = 'schedules_container';
                // Crear el contenedor principal
                const scheduleDiv = document.createElement('div');
                scheduleDiv.classList.add('schedule');

                // Crear el contenedor de los inputs
                const scheduleInputsDiv = document.createElement('div');
                scheduleInputsDiv.classList.add('scheduel_inputs');

                // Crear el contenedor de la lista
                const listContainerDiv = document.createElement('div');
                listContainerDiv.classList.add('list_container');

                // Crear la lista de días
                const daysListUl = document.createElement('ul');
                daysListUl.classList.add('list', 'days_list');

                EnumToList(daysListUl, 'horario', 'dia_semana', 'li');

                CreateEvent(daysListUl, 'requestSuccessfully', 'Evento lanzado con éxito.');

                daysListUl.addEventListener('requestSuccessfully', function(){
                    let liDays = daysListUl.querySelectorAll('li');
                    // console.log("numero de dias =" + liDays.length);
                    
                    for (let i = 1; i <= liDays.length; i++) {
                        const days = liDays[i - 1];
                        days.setAttribute('id_day', i);
                        days.textContent = dias_semana[i];
                    }
                });

                DaysSelectionSystem(daysListUl);

                // Añadir la lista de días al contenedor
                listContainerDiv.appendChild(daysListUl);

                // Añadir el contenedor de la lista a los inputs
                scheduleInputsDiv.appendChild(listContainerDiv);

                // Crear el input de "Hora inicio"
                const horaInicioDiv = document.createElement('div');
                horaInicioDiv.classList.add('input_time');

                const horaInicioLabel = document.createElement('label');
                horaInicioLabel.classList.add('input_time__label');
                horaInicioLabel.textContent = 'Hora inicio';

                const horaInicioInput = document.createElement('input');
                horaInicioInput.type = 'time';
                horaInicioInput.classList.add('input_time__input', 'hora_inicio');

                horaInicioDiv.appendChild(horaInicioLabel);
                horaInicioDiv.appendChild(horaInicioInput);

                // Crear el input de "Hora final"
                const horaFinDiv = document.createElement('div');
                horaFinDiv.classList.add('input_time');

                const horaFinLabel = document.createElement('label');
                horaFinLabel.classList.add('input_time__label');
                horaFinLabel.textContent = 'Hora final';

                const horaFinInput = document.createElement('input');
                horaFinInput.type = 'time';
                horaFinInput.classList.add('input_time__input', 'hora_fin');

                horaFinDiv.appendChild(horaFinLabel);
                horaFinDiv.appendChild(horaFinInput);

                // Crear el checkbox de "Es retransmisión"
                const esRetransmisionDiv = document.createElement('div');
                esRetransmisionDiv.classList.add('input_time');

                const esRetransmisionLabel = document.createElement('label');
                esRetransmisionLabel.classList.add('input_time__label');
                esRetransmisionLabel.textContent = 'Es retrasmision';

                const esRetransmisionInput = document.createElement('input');
                esRetransmisionInput.type = 'checkbox';
                esRetransmisionInput.classList.add('input_time__input', 'es_retransmision');

                esRetransmisionDiv.appendChild(esRetransmisionLabel);
                esRetransmisionDiv.appendChild(esRetransmisionInput);

                // Añadir todos los inputs a los schedule inputs
                scheduleInputsDiv.appendChild(horaInicioDiv);
                scheduleInputsDiv.appendChild(horaFinDiv);
                scheduleInputsDiv.appendChild(esRetransmisionDiv);

                // Añadir el contenedor de inputs al contenedor principal
                scheduleDiv.appendChild(scheduleInputsDiv);

                // Crear la div de feedback
                const feedbackDiv = document.createElement('div');
                feedbackDiv.classList.add('feedback_schedules');
                feedbackDiv.textContent = 'hay solapaciones';

                // Añadir el feedback al contenedor principal
                scheduleDiv.appendChild(feedbackDiv);

                element.appendChild(scheduleDiv);

                let addNewScheduleButton = document.createElement('button');
                addNewScheduleButton.id = 'addNewSchedule';
                addNewScheduleButton.classList.add('button');
                addNewScheduleButton.textContent = "añadir nuevo horario";
                element.appendChild(addNewScheduleButton);

                addNewScheduleButton.addEventListener('click', function(){
                    layersNumSchedules[currentLayer]++;
                    CheckHeights(this.parentNode.parentNode.parentNode.parentNode);
                    CloneSchedule(element, scheduleDiv, this);
                });
                break;
            }
        case 'list':
            {
                container.id = "inputSelector_" + fieldName;
                container.setAttribute('contentName', tableName);
                element = document.createElement('div');
                element.classList.add('input_select');

                let divSelected = document.createElement('div');
                divSelected.classList.add('input_list');
                element.appendChild(divSelected);

                let h3Selected = document.createElement('h3');
                h3Selected.classList.add('title_list');
                h3Selected.textContent = "Seleccionados";
                divSelected.appendChild(h3Selected);

                let createBtn = document.createElement('button');
                createBtn.classList.add('miniBtn');
                createBtn.classList.add('tooltip');

                let subContentName = tableName.split("_")[1]; // x_value

                createBtn.setAttribute('contentName', subContentName);
                createBtn.textContent = '+';

                createBtn.addEventListener('click', function(e){
                    AddContent(e, subContentName);
                });

                let tooltip = document.createElement('span');
                tooltip.classList.add('tooltiptext');
                tooltip.textContent = 'Añadir nuevo ' + subContentName;

                createBtn.appendChild(tooltip)

                h3Selected.appendChild(createBtn);

                let ulSelected = document.createElement('ul');
                ulSelected.classList.add('list');
                ulSelected.classList.add('options');
                ulSelected.classList.add('optionsSelected');
                ulSelected.id = "selected_list_" + subContentName;
                divSelected.appendChild(ulSelected);

                let divDivision = document.createElement('div');
                divDivision.classList.add('division');

                // fetch('../resources/img/arrow-right-arrow-left-solid.svg')
                // .then(response => response.text())
                // .then(svgContent => {
                //     divDivision.innerHTML = svgContent;
                // })
                // .catch(error => console.log('Error al cargar el SVG:', error));

                GetSVG(divDivision ,'../resources/img/svg/arrow-right-arrow-left-solid.svg', ["14px", "14px", "#007BFF"]);
                element.appendChild(divDivision);

                let divAvailable = document.createElement('div');
                divAvailable.classList.add('input_list');
                element.appendChild(divAvailable);

                let h3Available = document.createElement('h3');
                h3Available.classList.add('title_list');
                h3Available.textContent = "Disponibles";
                divAvailable.appendChild(h3Available);

                let ulAvailable = document.createElement('ul');
                ulAvailable.classList.add('list');
                ulAvailable.classList.add('options');
                ulAvailable.classList.add('optionsAvailable');
                divAvailable.appendChild(ulAvailable);

                GetList(ulAvailable, fieldName);
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
    if((layers.length - 1) === currentLayer){
        console.log("Closing...");
        modal.querySelector('.modal-content').classList.add('fadeout');
        layers.pop();
        layersModalContent.pop();
        layersInputsType.pop();
        layersNumSchedules.pop();
        currentLayer--;
        setTimeout(function() {
            modal.style.display = 'none';
            modal.remove();
            // if(layers){
                // currentLayer = layers[layers.length - 1];
                // CheckHeights();
            // }
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

        let cancelBtn = currentModal.querySelector('.cancelBtn');
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
    layersNumSchedules.push(0);
    currentLayer++;
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
    cancelBtn.classList.add('button');
    cancelBtn.classList.add('cancelBtn');
    cancelBtn.textContent = 'Cancelar';
    btns_container.appendChild(cancelBtn);

    let confirmBtn = document.createElement('button');
    confirmBtn.type = 'button';
    confirmBtn.classList.add('button');
    confirmBtn.classList.add('confirmBtn');
    confirmBtn.textContent = 'Confirmar';
    // confirmBtn.addEventListener('click', function () {
    //     CreateModal();
    // });
    btns_container.appendChild(confirmBtn);

    // let originalModal = modals_container.querySelector('.originalModal');

    
    // let replicant = originalModal.cloneNode(true);
    // replicant.classList.remove('originalModal');

    // let confirmBtn = replicant.querySelector('.confirmBtn');

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
    fetch((currentDir === '' ? "" : "../" ) + "php/jsRequest.php", {
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
    fetch((currentDir === '' ? "" : "../" ) + "php/jsRequest.php", {
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
    const button = input_file.querySelector('.button');
    const actual_input = input_file.querySelector('[type="file"]');
    const nameELement = input_file.querySelector('.input_content__filename--file')
    const feedbackElement = input_file.querySelector('.input_content__feedback--file');
    
    button.addEventListener('click', function(){
        actual_input.click();
    });

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
        nameELement.textContent = file.name;
        feedbackElement.textContent = ''; // Limpiar mensaje previo

        // if (actual_input.files.length) {
        //     dropZone.textContent = file.name;
        // }
        
        // Comprobar si se ha seleccionado un archivo
        if (!file) {
            feedbackElement.textContent = 'Por favor selecciona un archivo.';
            return;
        }
    
        // Verificar el tamaño del archivo (máximo 500KB)
        let maxSize = 500 * 1024; // 500KB
        if (file.size > maxSize) {
            feedbackElement.textContent = 'El archivo es demasiado grande. Máximo 500KB.';
            fileInput.value = ''; // Limpiar el archivo seleccionado
            return;
        }
    
        // Verificar extensiones permitidas
        let allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        if (!allowedExtensions.exec(file.name)) {
            feedbackElement.textContent = 'Solo se permiten archivos con extensiones .jpg, .jpeg, .png, .gif';
            fileInput.value = ''; // Limpiar el archivo seleccionado
            return;
        }
    
        // Verificar que sea un archivo de imagen con el tipo MIME
        if (!file.type.startsWith('image/')) {
            feedbackElement.textContent = 'El archivo debe ser una imagen válida.';
            fileInput.value = ''; // Limpiar el archivo seleccionado
            return;
        }
    
        // Si todas las comprobaciones pasan, mostrar mensaje de éxito
        feedbackElement.textContent = 'El archivo es válido y está listo para subir.';
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
    let cancelBtn = updateModal.querySelector('.cancelBtn');

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

    return updateModal.querySelector('.confirmBtn');
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
