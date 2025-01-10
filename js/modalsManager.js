import { AddInputToCurrentLayer, CheckHeights, GetInputHeight, AddContent, CreateEvent, SumbitCreateRequest, SumbitUpdateRequest ,CreateModal, CreateInput, SubmitDeleteRequest, ToHours } from './utilities.js?v=33b427';
// const modals_container = document.getElementById('modals_container');
// const originalModal = modals_container.querySelector('#originalModal');
// const original_forms = document.getElementById('original_forms');
const createBtns = document.getElementsByClassName('createBtn');

// const updateBtns = document.getElementsByClassName('updateBtn');

const contentFields = document.getElementsByClassName('contentField');

const deleteBtns = document.getElementsByClassName('deleteBtn');

if(createBtns.length){
    for (let index = 0; index < createBtns.length; index++) {
        const createBtn = createBtns[index];
        let contentName = createBtn.getAttribute('contentName');
        createBtn.addEventListener('click', function(e){
            AddContent(e ,contentName);
        });
    }
}

if(contentFields.length){
    for (let index = 0; index < contentFields.length; index++) {
        const contentField = contentFields[index];
        const updateBtn = contentField.querySelector('.updateBtn');
        const contentName = contentField.getAttribute('contentName');
        const contentId = contentField.getAttribute('contentId');
        const fieldName = contentField.getAttribute('fieldName');
        const fieldTitle = contentField.querySelector('.fieldTitle').textContent;
        const inputType = contentField.getAttribute('inputType');
        let currentValue = contentField.querySelector('.currentValue').textContent;
        if(inputType === 'boolean'){
            if(currentValue === 'No')
                currentValue = 0;
            else
                currentValue = 1;
        }
        
        updateBtn.addEventListener('click', function(e){
            UpdateContent(contentName, contentId, fieldName, fieldTitle, inputType, currentValue);
        });
    }
}

if(deleteBtns.length){
    for (let index = 0; index < deleteBtns.length; index++) {
        const deleteBtn = deleteBtns[index];
        let contentName = deleteBtn.getAttribute('contentName');
        let contentId = deleteBtn.getAttribute('contentId');
        deleteBtn.addEventListener('click', function(e){
            DeleteContent(contentName, contentId);
        });
    }
}

function UpdateContent(contentName, contentId, fieldName, fieldTitle, inputType, currentValue){
    const modal = CreateModal();
    const modal_content = modal.querySelector('.modal-content');
    const container = modal.querySelector('.container');
    const btns_container = modal.querySelector('.btns_container');

    const confirmBtn = btns_container.querySelector('.confirmBtn');

    const input = CreateInput(inputType, fieldName, [], fieldTitle, contentName, 'type something here...');
    
    container.insertBefore(input, btns_container); 

    // let file;
    // let confirmBtn = SetupModal(inputType);

    // let update_label = input.querySelector('LABEL');
    // if(!(inputType === 'enum' || inputType === 'boolean'));
    //     let update_input = input.querySelector('INPUT');

    switch (inputType) {
        case 'text':
            input.querySelector('input').value = currentValue;
            break;
        case 'textarea':
            input.querySelector('textarea').value = currentValue;
            break;
        case 'password':
            break;
        case 'file':
            break;
        case 'enum':
            {
                let selectElement = input.querySelector('.selectList');
                // Como se hace una peticion fetch para obtener datos de la DB, puede existir un retraso, por lo que creamos un evento que se activa cuando la peticion fue recibida y hubo respuesta. Asi nos aseguramos que ya existan las opciones cuando las queremos modificar.
                CreateEvent(selectElement, 'requestSuccessfully', 'Evento lanzado con éxito.');
                selectElement.addEventListener('requestSuccessfully', function(){
                    let options = selectElement.querySelectorAll('option');
                    options.forEach(option => {
                        if(option.textContent === currentValue)
                            option.selected = true;
                    });
                });
            }
            break;
        case 'boolean':
            input.querySelector('input').checked = currentValue;
            break;
        case 'schedules':
            {
                let values = JSON.parse(currentValue);
                let daysArray = values[0];
                let timesInMinutes = values[1];
                let retrasmision = values[2];

                let daysList = input.querySelector('.days_list');
                CreateEvent(daysList, 'requestSuccessfully', 'Evento lanzado con éxito.');
                daysList.addEventListener('requestSuccessfully', function(){
                    let options = daysList.querySelectorAll('li');
                    daysArray.forEach(selectedDay => {
                        for (let i = 0; i < options.length; i++) {
                            if (options[i].getAttribute('id_day') === selectedDay) {
                                options[i].classList.add('selected');
                                break;
                            }
                        }
                    });
                });
                let timesInHours = [];
                timesInMinutes.forEach(time => {
                    timesInHours.push(ToHours(time));
                });

                let prevTimes = timesInHours.join(',');

                let containers = input.querySelectorAll('.input_time');
                containers[0].setAttribute('prevTimes', prevTimes);
                
                let timeInputs = [];

                for (let i = 0; i < 2; i++) {
                    const container = containers[i];
                    timeInputs.push(container.querySelector('[type=time]'))
                }

                for (let i = 0; i < timeInputs.length; i++) {
                    const time = timeInputs[i];
                    time.value = ToHours(timesInMinutes[i]);
                    time.disabled = false;
                }

                const checkboxInput = containers[2].querySelector('[type="checkbox"]');
                checkboxInput.checked = retrasmision;
            }
            break;
        case 'list':
            {
                let selected = JSON.parse(currentValue);
                selected.sort((a, b) => a - b);

                let selectedContainer = input.querySelector('.optionsSelected')
                let optionsAvailable = input.querySelector('.optionsAvailable');
                CreateEvent(optionsAvailable, 'requestSuccessfully', 'Evento lanzado con éxito.');
                optionsAvailable.addEventListener('requestSuccessfully', function(){
                    let options = optionsAvailable.querySelectorAll('li');
                    selected.forEach(selectedOption => {
                        for (let i = 0; i < options.length; i++) {
                            if(options[i].id == selectedOption){
                                options[i].classList.add('selected');
                                selectedContainer.appendChild(options[i]);
                                break;
                            }
                        }
                    });
                });
            }
            break;
    }

    AddInputToCurrentLayer(modal_content, [inputType]);

    CheckHeights();

    // let resizeTimeout;
    // window.addEventListener('resize', () => {
    //     clearTimeout(resizeTimeout);
    //     resizeTimeout = setTimeout(() => {
    //         CheckHeights();
    //     }, 200);
    // });

    confirmBtn.addEventListener('click', function(){
        SumbitUpdateRequest(contentName, contentId, fieldName, input);
    });
}

function DeleteContent(contentName, contentId){
    const modal = CreateModal();
    const container = modal.querySelector('.container');
    const btns_container = modal.querySelector('.btns_container');
    const confirmBtn = btns_container.querySelector('.confirmBtn');

    const divWarning = document.createElement('div');
    divWarning.classList.add('warning');
    const warning_text = document.createElement('p');
    warning_text.classList.add('delete-message');
    warning_text.innerHTML = "Estas a punto de <span class='highlight'>eliminar</span> el contenido, ¿deseas continuar?";
    divWarning.appendChild(warning_text);
    container.insertBefore(divWarning, btns_container);

    confirmBtn.addEventListener('click', function(){
        SubmitDeleteRequest(contentName, contentId);
    })
}