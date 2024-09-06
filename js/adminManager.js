const rec_Form = document.getElementById('rec_form');
const rec_legend = document.getElementById('rec_legend');
const rec_id_admin_container = document.getElementById('rec_id_admin_container');
const rec_username_container = document.getElementById('rec_username_container');
const rec_email_container = document.getElementById('rec_email_container');
const rec_password_container = document.getElementById('rec_password_container');
const rec_nombre_container = document.getElementById('rec_nombre_container');
const rec_rol_container = document.getElementById('rec_rol_container');
const rec_activo_container = document.getElementById('rec_activo_container');
const rec_id_admin = document.getElementById('rec_id_admin');
const rec_username = document.getElementById('rec_username');
const rec_email = document.getElementById('rec_email');
const rec_password = document.getElementById('rec_password');
const rec_nombre = document.getElementById('rec_nombre');
const rec_rol1 = document.getElementById('rec_rol1');
const rec_rol2 = document.getElementById('rec_rol2');
const rec_rol3 = document.getElementById('rec_rol3');
const rec_rol = document.getElementById('rec_rol');
const rec_true = document.getElementById('rec_true');
const rec_false = document.getElementById('rec_false');
const rec_submit = document.getElementById('rec_sumbit');


function showForm(record = ['0','','','','','1']){
    rec_Form.style.display = "initial";
    if(record[0] === '0'){
        legend.textContent = "Crear administrador";
        rec_submit.value = "Crear";
    }else{
        legend.textContent = "Actualizar administrador";
        rec_submit.value = "Actualizar";
    }
    rec_username.value = record[1];
    rec_email.value = record[2];
    rec_nombre.value = record[3];
    switch (record[4]) {
        case "SuperAdmin":
            superAdmin.selected = true;
            break;
        case "Editor":
            editor.selected = true;
            break;
        case "Moderador":
            moderador.selected = true;
            break;
    }

    switch (record[5]) {
        case '0':
            rec_false.checked = true;
            break;
        case '1':
            rec_true.checked = true;
            break;
    }
    // console.log(rec_row.join(" "));
    // if(primary_key > 0){
    //     legend.textContent = "Actualizar administrador";
    //     rec_username.value = "asd";
    // }else{
    //     legend.textContent = "Crear administrador";
    // }
}

function showUpdateForm(primary_key, field, value){
    rec_legend.textContent = "Actualizando " + field;
    rec_Form.style.display = 'initial';
    rec_submit.value = "Actualizar";
    
    rec_id_admin_container.style.display = 'initial';
    rec_id_admin.value = primary_key;

    rec_username_container.style.display = 'none';
    rec_username.disabled = true;
    rec_email_container.style.display = 'none';
    rec_email.disabled = true;
    rec_password_container.style.display = 'none';
    rec_password.disabled = true;
    rec_nombre_container.style.display = 'none';
    rec_nombre.disabled = true;
    rec_rol_container.style.display = 'none';
    rec_rol.disabled = true;
    rec_activo_container.style.display = 'none';
    rec_true.disabled = true;
    rec_false.disabled = true;

    switch (field) {
        case 'username':
            {
                rec_username_container.style.display = 'initial';
                rec_username.disabled = false;
                rec_username.value = value;
            }
            break;
        case 'email':
            {
                rec_email_container.style.display = 'initial';
                rec_email.disabled = false;
                rec_email.value = value;
            }
            break;
        case 'password_hash':
            {
                rec_password_container.style.display = 'initial';
                rec_password.disabled = false;
                rec_password.value = value;
            }
            break;
        case 'nombre_completo':
            {
                rec_nombre_container.style.display = 'initial';
                rec_nombre.disabled = false;
                rec_nombre.value = value;
            }
            break;
        case 'rol':
            {
                rec_rol_container.style.display = 'initial';
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
        case 'activo':
            {
                rec_activo_container.style.display = 'initial';
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

function deleteRecord(primary_key){
    console.log("TODO: delete record with key " + primary_key + "!");
    // Variable a enviar
    let data = {
        id_admin: primary_key
    };

    // Enviar datos al servidor usando fetch
    fetch("ruta-del-servidor", {
        method: "POST", // Método de envío
        headers: {
            "Content-Type": "application/json", // Especificamos que estamos enviando JSON
        },
        body: JSON.stringify(data) // Convertimos los datos a JSON
    })
    .then(response => {
        if (response.ok) {
            // Recargar la página si la respuesta del servidor es exitosa
            location.reload();
        } else {
            console.error("Error al enviar los datos");
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function enviarDato(primary_key) {
    console.log("Dato recibido en JS: " + primary_key);

    // Crear una petición POST para enviar el dato de vuelta al servidor
    fetch("admin_panel.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: "id_admin=" + encodeURIComponent(primary_key) + "&action=" + encodeURIComponent("Eliminar")
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