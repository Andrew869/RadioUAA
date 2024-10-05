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
var deleteModal = document.getElementById("deleteModal");
var updateModal = document.getElementById("updateModal");

// Get the button that opens the modal
var deleteBtn = document.getElementById("deleteBtn");
var updateBtns = document.getElementsByClassName("updateBtn");


var cancelBtn = document.getElementById('cancelBtn');
var confirmBtn = document.getElementById('confirmBtn');

// When the user clicks the button, open the modal 
if(deleteBtn){
	// Get the <span> element that closes the modal
	var deleteX = deleteModal.querySelector('SPAN');
	var uptadeX = updateModal.querySelector('SPAN');

	deleteBtn.onclick = function() {
		deleteModal.style.display = "block";
	}

	// for (let i = 0; i < updateBtns.length; i++) {
	// 	const element = updateBtns[i];
	// 	element.addEventListener('click', function(){
	// 		updateModal.style.display = 'block';
	// 	});
	// }

	// When the user clicks on <span> (x), close the modal
	deleteX.onclick = function() {
		deleteModal.style.display = "none";
	}

	uptadeX.onclick = function() {
		updateModal.style.display = "none";
	}

	cancelBtn.addEventListener('click', function(){ 
		modal.style.display = 'none';
	});

	confirmBtn.addEventListener('click', deleteRecord);

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == deleteModal || event.target == updateModal) {
			deleteModal.style.display = "none";
			updateModal.style.display = "none";
		}
	}
}

function deleteRecord(e) {
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

function showUpdateForm(table_name, primary_key, field, current_value, type){

    let update_label = updateModal.querySelector('LABEL');
    let update_input = updateModal.querySelector('INPUT');
    update_label.textContent = field;
    update_input.value = current_value;

    updateModal.style.display = 'block';

    switch (type) {
        case 'text':
            
            break;
        case 'password':
            
            break;
        case 'image':
            
            break;
        case 'date':
            
            break;
        case 'boolean':
            
            break;
    
        default:
            break;
    }

    containers.forEach(element => {
        element.style.display = "none";
    });

    inputs.forEach(element => {
        element.disabled = true;
    });

    rec_id_user.value = primary_key;

    switch (field) {
        case 'username':
            {
                rec_username_container.style.display = 'block';
                rec_username.disabled = false;
                rec_username.value = value;
            }
            break;
        case 'email':
            {
                rec_email_container.style.display = 'block';
                rec_email.disabled = false;
                rec_email.value = value;
            }
            break;
        case 'password_hash':
            {
                rec_password_container.style.display = 'block';
                rec_password.disabled = false;
                // rec_password.value = value;
            }
            break;
        case 'nombre_completo':
            {
                rec_nombre_container.style.display = 'block';
                rec_nombre.disabled = false;
                rec_nombre.value = value;
            }
            break;
        case 'rol':
            {
                rec_rol_container.style.display = 'block';
                rec_rol.disabled = false;
                switch (value) {
                    case "SuperAdmin":
                        rec_rol1.selected = true;
                        break;
                    case "Editor":
                        rec_rol2.selected = true;
                        break;
                    case "Moderador":
                        rec_rol3.selected = true;
                        break;
                }
            }
            break;
        case 'cuenta_activa':
            {
                rec_cuenta_activa_container.style.display = 'block';
                rec_true.disabled =  false;
                rec_false.disabled = false;
                switch (value) {
                    case '0':
                        rec_false.checked = true;
                        break;
                    case '1':
                        rec_true.checked = true;
                        break;
                }
            }
            break;
    }
}