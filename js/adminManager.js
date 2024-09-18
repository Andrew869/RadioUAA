const rec_Form = document.getElementById('rec_form');
const rec_legend = document.getElementById('rec_legend');
// Containers
const rec_id_user_container = document.getElementById('rec_id_user_container');
const rec_username_container = document.getElementById('rec_username_container');
const rec_email_container = document.getElementById('rec_email_container');
const rec_password_container = document.getElementById('rec_password_container');
const rec_nombre_container = document.getElementById('rec_nombre_container');
const rec_rol_container = document.getElementById('rec_rol_container');
const rec_cuenta_activa_container = document.getElementById('rec_cuenta_activa_container');
// inputs
const rec_id_user = document.getElementById('rec_id_user');
const rec_username = document.getElementById('rec_username');
const rec_email = document.getElementById('rec_email');
const rec_password = document.getElementById('rec_password');
const rec_nombre = document.getElementById('rec_nombre');
const rec_rol0 = document.getElementById('rec_rol0');
const rec_rol1 = document.getElementById('rec_rol1');
const rec_rol2 = document.getElementById('rec_rol2');
const rec_rol3 = document.getElementById('rec_rol3');
const rec_rol = document.getElementById('rec_rol');
const rec_true = document.getElementById('rec_true');
const rec_false = document.getElementById('rec_false');
const rec_submit = document.getElementById('rec_submit');

const containers = [
    rec_username_container,
    rec_email_container,
    rec_password_container,
    rec_nombre_container,
    rec_rol_container,
    rec_cuenta_activa_container
];

const inputs = [
    rec_username,
    rec_email,
    rec_password,
    rec_nombre,
    rec_rol,
    rec_true,
    rec_false
];


function showFullForm(){
    rec_Form.style.display = "initial";
    
    rec_legend.textContent = "Crear administrador";
    rec_submit.value = "1"; //1 = Crear
    rec_submit.textContent = "Crear";
        
    rec_id_user.value = "";
    rec_username.value = "";
    rec_email.value = "";
    rec_password.value = "";
    rec_nombre.value = "";

    rec_rol0.selected = true;
    rec_true.checked = true;

    rec_id_user_container.style.display = "none";
    rec_id_user.disabled = true;

    containers.forEach(element => {
        element.style.display = "block";
    });

    inputs.forEach(element => {
        element.disabled = false;
    });
}

function showUpdateForm(primary_key, field, value){
    rec_legend.textContent = "Actualizando " + field;
    rec_Form.style.display = 'initial';
    rec_submit.value = "2"; // 2 = Actualizar
    rec_submit.textContent = "Actualizar";
    
    rec_id_user_container.style.display = 'block';
    rec_id_user.disabled = false;

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

function deleteRecord(primary_key) {
    console.log("Dato recibido en JS: " + primary_key);

    // Crear una petición POST para enviar el dato de vuelta al servidor
    fetch("admin_panel.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: "id_user=" + encodeURIComponent(primary_key) + "&action=" + encodeURIComponent("3") // 3 = Eliminar
    })
    .then(response => response.text())
        .then(data => {
            // console.log("Respuesta del servidor:", data);
            // Recargar la página después de enviar los datos exitosamente
            location.reload(); // Recarga la página actual
        })
        .catch(error => {
        console.error("Error:", error);
    });
}

setInterval(checkActiveSession, 5000); // Verificar cada 5 segundos

function checkActiveSession() {
    fetch('check_session.php')
        .then(response => response.json())
        .then(data => {
            if (!data.sesion_valida) {
                if(!data.token_expired)
                    alert('Tu sesión ha sido cerrada desde otro dispositivo.');
                else
                    alert('Tu sesión ha caducado.');
                window.location.href = 'admin_panel.php';
            }
        });
}