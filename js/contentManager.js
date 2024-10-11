const deleteModal = document.getElementById("deleteModal");
const updateModal = document.getElementById("updateModal");
const createModal = document.getElementById("createModal");


let current_content, current_pk;

let inputs;
let input;

let originalschedule;
let replicants = [];

// variables para el control de seleccion en dias
let currentListOption, targetListOption;


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