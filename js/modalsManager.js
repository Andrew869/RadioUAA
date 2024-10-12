import { SendDataBaseRequest, CreateModal, CreateInput, SendDeleteRequest } from './utilities.js';
const modals_container = document.getElementById('modals_container');
// const originalModal = modals_container.querySelector('#originalModal');
// const original_forms = document.getElementById('original_forms');
const createBtns = document.getElementsByClassName('createBtn');
const deleteBtns = document.getElementsByClassName('deleteBtn');

if(createBtns.length){
    for (let index = 0; index < createBtns.length; index++) {
        const createBtn = createBtns[index];
        let contentName = createBtn.getAttribute('contentName');
        createBtn.addEventListener('click', function(e){
            AddContent(contentName);
        });
    }
}

if(deleteBtns.length){
    for (let index = 0; index < deleteBtns.length; index++) {
        const deleteBtn = deleteBtns[index];
        let contentName = deleteBtn.getAttribute('contentName');
        let pk = deleteBtn.getAttribute('pk');
        deleteBtn.addEventListener('click', function(e){
            DeleteContent(contentName, pk);
        });
    }
}

// function HideModal(modal){
//     if(layers[layers.length - 1] === currentLayer){
//         console.log("Closing...");
//         modal.querySelector('.modal-content').classList.add('fadeout');
//         layers.pop();
//         setTimeout(function() {
//             modal.style.display = 'none';
//             modal.remove();
//             if(layers){
//                 currentLayer = layers[layers.length - 1];
//             }
//         }, 390);
//     }
// }

// function SetupModal(modal){
//     let currentModal = modal;

//     currentModal.style.display = 'block';

//     setTimeout(function() {
//         let xBtn = currentModal.querySelector('.close');
//         xBtn.addEventListener('click', () => {
//             HideModal(currentModal);
//         });

//         let cancelBtn = currentModal.querySelector('#cancelBtn');
//         cancelBtn.addEventListener('click', () => {
//             HideModal(currentModal);
//         });

//         window.addEventListener('click', (event) => {
//             if(event.target === currentModal){
//                 HideModal(currentModal);
//             }
//         });
//     }, 400);

//     modals_container.appendChild(currentModal);
//     layers.push(currentModal);
//     currentLayer = currentModal;
//     return currentModal;
// }

function AddContent(contentName){
    const modal = CreateModal();
    const modal_content = modal.querySelector('.container');
    const btns_container = modal.querySelector('.btns_container');

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
        SendDataBaseRequest(0, contentName, inputs);
    });
}

function DeleteContent(contentName, pk){
    const modal = CreateModal();
    const modal_content = modal.querySelector('.container');
    const btns_container = modal.querySelector('.btns_container');
    const confirmBtn = btns_container.querySelector('#confirmBtn');

    const warning_text = document.createElement('p');
    warning_text.textContent = "Estas a punto de eliminar este contenido, deseas continuar?"
    modal_content.insertBefore(warning_text, btns_container);

    confirmBtn.addEventListener('click', function(){
        SendDeleteRequest(contentName, pk);
    })
}