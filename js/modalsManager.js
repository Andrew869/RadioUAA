import { CreateModal, CreateInput, CheckSchedules, CloneSchedule, InputFileManager } from './utilities.js';
const modals_container = document.getElementById('modals_container');
// const originalModal = modals_container.querySelector('#originalModal');
// const original_forms = document.getElementById('original_forms');
const createBtn = document.getElementById('createBtn');

createBtn.addEventListener('click', function(){
    AddContent('programa');
});

let currentLayer;
const layers = [];

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
        }, 390);
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
    return currentModal;
}

function AddContent(content){
    const modal = SetupModal(CreateModal());
    const modal_content = modal.querySelector('.container');
    const btns_container = modal.querySelector('.btns_container');

    // const origianl_form = original_forms.querySelector('#' + content);
    // let current_form = origianl_form.cloneNode(true);
    let input = CreateInput('boolean', 'schedules', ["asd", "fdsa"], "es retransmision", "programa");

    modal_content.insertBefore(input, btns_container);
}