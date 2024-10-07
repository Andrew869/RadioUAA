let defaultTab = document.getElementById("defaultOpen");
let rows = document.getElementsByClassName('values');
let currentContent;
let currentPK;

for (let i = 0; i < rows.length; i++) {
	rows[i].addEventListener('click', function () {
		// console.log(rows[i].querySelector('.pk').textContent);
		// console.log("Ruta (como PHP_SELF): " + window.location.pathname);
		currentPK = rows[i].querySelector('.pk').textContent;
		window.location.href = window.location.pathname + '?' + currentContent + '=' + currentPK;
	});
}

function ShowContent(evt, content) {
	// Declare all variables
	var i, tabcontent, tablinks;

	currentContent = content;

	// Get all elements with class="tabcontent" and hide them
	tabcontent = document.getElementsByClassName("tabcontent");
	for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	}

	// Get all elements with class="tablinks" and remove the class "active"
	tablinks = document.getElementsByClassName("tablinks");
	for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
	}

	// Show the current tab, and add an "active" class to the button that opened the tab
	document.getElementById(content).style.display = "block";
	evt.currentTarget.className += " active";
}

if(defaultTab)
	defaultTab.click();

// function DeleteContent(e, content) {

// }


// Get the modal
let deleteModal = document.getElementById("deleteModal");
let updateModal = document.getElementById("updateModal");

let inputs;
let input;


// Get the button that opens the modal
var deleteBtn = document.getElementById("deleteBtn");
var updateBtns = document.getElementsByClassName("updateBtn");

function HideModal(modal){
    updateModal.classList.remove('show');
    updateModal.classList.add('hide');

    setTimeout(() => {
        modal.style.display = 'none';
    }, 500);
}

// When the user clicks the button, open the modal 
if(deleteBtn){
    inputs = updateModal.querySelectorAll('.inputModal');;

	deleteBtn.onclick = function() {
		deleteModal.style.display = "block";

        let deleteX = deleteModal.querySelector('SPAN');
        let cancelBtn = deleteModal.querySelector('#cancelBtn');
        let confirmBtn = deleteModal.querySelector('#confirmBtn');

        deleteX.onclick = function() {
            HideModal(deleteModal);
        }

	    cancelBtn.addEventListener('click', function(){ 
            HideModal(deleteModal);
        });

	    confirmBtn.addEventListener('click', deleteContent);

        // When the user clicks anywhere outside of the modal, close it
	    window.onclick = function(event) {
	    	if (event.target == deleteModal) {
	    		deleteModal.style.display = "none";
	    	}
	    }
	}

	
}

function deleteContent(e) {
	currentContent = e.currentTarget.getAttribute('content');
	currentPK = e.currentTarget.getAttribute('pk');

    fetch("deleteContent.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: encodeURIComponent(currentContent) + '=' + encodeURIComponent(currentPK)
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
            // console.log("Respuesta del servidor:", data);
            // Recargar la página después de enviar los datos exitosamente
            window.location.href = window.location.href;
        })
        .catch(error => {
        console.error("Error:", error);
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
    current_opction.classList.add('selected');
}

function MoveOption(e) {
    if (e.target.tagName !== 'LI') return;
    const optionList = e.target;
    if(e.currentTarget.id === 'optionsAvailable')
        SwapInOrden(optionList, optionsSelected);
    else
        SwapInOrden(optionList, optionsAvailable);
}

const optionsSelected = document.getElementById('optionsSelected');
const optionsAvailable = document.getElementById('optionsAvailable');

optionsSelected.addEventListener('click', MoveOption);
optionsAvailable.addEventListener('click', MoveOption);

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
                // if(type !== "list") return;
                    DeleteLists();
        });
    });

    window.onclick = function(event) {
		if (event.target == deleteModal || event.target == updateModal) {
            HideModal(updateModal);
            // if(type === "list") return;
                DeleteLists();
		}
	}

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

            let dropZone = input.querySelector('#drop-zone');

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
                    update_input.files = files; // Asignar archivos al input file
                    dropZone.textContent = update_input.files[0].name;
                }
            });

            // Hacer clic en el área de arrastre para seleccionar archivos
            dropZone.addEventListener('click', () => {
                update_input.click();
            });

            update_input.addEventListener('change', function(event) {
                let fileInput = event.target;
                file = fileInput.files[0]; // Obtener el archivo seleccionado
                let feedback = document.getElementById('feedback_img');
                feedback.textContent = ''; // Limpiar mensaje previo

                if (update_input.files.length) {
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
                element.addEventListener('click', function(){
                    update_input.value = element.value;
                });
            });
            if(parseInt(current_value, 10))
                update_inputs[0].checked = true;
            else
                update_inputs[1].checked = true;
            break;
    }

    confirmBtn.addEventListener('click', function(){
        if(type === 'image')
            UpdateImg(table_name, primary_key, field, file);
        else
            UpdateContent(table_name, primary_key, field, update_input.value);
    });
}

function ToHours(minutes) {
    let hours = Math.floor(minutes / 60);
    let mins = minutes % 60;
    hours = hours < 10 ? '0' + hours : hours;
    mins = mins < 10 ? '0' + mins : mins;
    return hours + ':' + mins;
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

    let minutes = inicio_fin.split(',');
    let inicio = ToHours(minutes[0]);
    let fin = ToHours(minutes[1]);

    hora_inputs[0].value = inicio;
    hora_inputs[1].value = fin;

    checkbox.checked = parseInt(retra, 10);

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
        str_selected = selected.join(',');
        UpdateRelationships(table_name ,primary_key, table_name_list, str_selected);
    });
}
