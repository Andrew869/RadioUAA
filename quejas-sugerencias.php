<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https:/use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
    <title>Quejas y Sugerencias</title>
    
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/Defensoria.css">
</head>
<body>
    <?php include 'main_header.php' ?>

    <div class="container-quejas">
        <!-- Columna Izquierda -->
        <div class="izquierda-quejas">
            <h1>Quejas y sugerencias</h1>
            <a href="defensoria.html" class="new-boton">Volver a Defensoría de las audiencias</a>
            <h2>Formulario de contacto de Defensoría</h2>
            <p>El objetivo de Radio UAA es tener contacto permanente con sus audiencias, por lo que te invitamos hacernos llegar tus comentarios y sugerencias de nuestros contenidos.</p>
        </div>

        <!-- Columna Derecha -->
        <div class="derecha-quejas">
            <section>
                <h2>Contacto</h2>
                <form class="formulario">
                    <fieldset>
                        <legend>Contáctanos llenando todos los campos</legend>
                        <div class="campo">
                            <label> Nombre: </label>
                            <input class="input-text" type="text" placeholder="Ingrese su nombre" required>
                        </div>
                        <div class="campo">
                            <label> E-mail: </label>
                            <input class="input-text" type="email" placeholder="Ingrese su correo electrónico" required>
                        </div>
                        <div class="campo">
                            <label> Mensaje: </label>
                            <textarea class="input-text" placeholder="Escribe tu mensaje aquí" required></textarea>
                        </div>
        
                        <!-- CAPTCHA de Google reCAPTCHA -->
                        <div class="g-recaptcha" data-sitekey="TU_SITE_KEY_AQUÍ"></div>
        
                        <!-- Botón de Enviar -->
                        <div class="alinear-derecha">
                            <input class="new-boton-formulario w-sm-100" type="submit" value="Enviar">
                        </div>
                    </fieldset>
                </form>
            </section>
        </div>
    </div>
        <hr>
        <br>

        <div class="container-uaa">
            <a href="https://www.uaa.mx/portal/" target="_blank">
                <img src="resources/img/UAA-LOGO.png" alt="Logo UAA" class="logo-uaa">
            </a>
            <a href="https://www.uaa.mx/dgdv/" target="_blank">
                <img src="resources/img/UAA-DG.png" alt="Logo UAA" class="logo-uaa">
            </a>
            <!-- <a href="https://www.uaa.mx/portal/comunicacion/radio-y-tv/" target="_blank">
                <img src="resources/img/UAA-TV-RADIO.png" alt="Logo UAA" class="logo-uaa">
            </a> -->
        </div>
        <br>
    

    <?php include 'main_footer.php' ?>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer>
</script>
</body>
</html>