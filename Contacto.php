<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https:/use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">

    <title>Consejo Ciudadano</title>
    <link rel="stylesheet" href="css/Contacto.css">
    <link rel="stylesheet" href="css/Contacto.css">


</head>
<body>
    
    <nav class="navbar">
        <div class="logo">
            <a href="Inicio.html">
                <img src="imgs/logo-radio-uaa-blanco.png" alt="Logo" />
            </a>
        </div>

        <ul class="nav-links">
            <li><a href="Inicio.html">Inicio</a></li>
            <li class="dropdown">
                <a href="Acerca de Radio UAA.html">Nosotros ⏷</a>
                <ul class="dropdown-content">
                    <li><a href="Acerca de Radio UAA.html">Acerca de Radio UAA</a></li>
                    <li><a href="Preguntas_Frecuentes.html">Preguntas Frecuentes</a></li>
                    <li><a href="Consejo Ciudadano.html">Consejo Ciudadano</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Defensoría ⏷</a>
                <ul class="dropdown-content">
                    <li><a href="#">Defensoría de las Audiencias</a></li>
                    <li><a href="#">Derechos de las Audiencia</a></li>
                    <li><a href="#">Quejas y Sugerencias</a></li>
                    <li><a href="#">Transparencía</a></li>
                    <li><a href="#">Politicas de privacidad</a></li>
                </ul>
            </li> 
            <li><a href="#">Programación</a></li>
            <li><a href="#">Contenido</a></li>
            <li><a href="Contacto.html">Contacto</a></li>
        </ul>
        <!-- Botón Modo Oscuro -->
        <div>
            <label for="toggle" id="label_toggle"><i id="theme-icon" class="fa-solid fa-moon"></i></label>
            <input type="checkbox" id="toggle" style="display:none;">
        </div>
    </nav>

    <!-- Sección Consejo Ciudadano -->
     <br>
    <h1>Contacto</h1>
    <!-- Sección Documentos Consejo -->
<!-- Slideshow container -->

<div class="slideshow-container">
    <div class="mySlides fade">
        <img src="imgs/Foto1.png" alt="">
    </div>

    <div class="mySlides fade">
        <img src="imgs/Foto2.png" alt="">
    </div>

    <div class="mySlides fade">
        <img src="imgs/Foto3.png" alt="">
    </div>
</div>

        <div class="documentos-texto">
            <ul>
                <h3>Horario de Oficina</h3>
                <li>lunes a viernes de 8:00 hrs a 15:30 hrs</li>
                <h3>Correo Electrónico</h3>
                <br>
                <li>Quejas ó Sugerencias sobre la pagina. <br> Favor de contestar el Formulario de Defensoria de las Audiencias <br> <br> <a href="#"><strong>Hacer una Queja o Sugerencia</strong></a></a></li>
                <h3>Telefonos</h3>
                <br>
                <li>449-9-10-74-55 <br>449-9-10-74-59</li>
                <br>
                <h3>Dirección</h3>
                <li>Av. Universidad #940, Ciudad Universitaria <br>
                    C.P. 20100 Aguascalientes, Ags. México <br>
                    <b>Edificio 14, Unidad «José Dávila Rodríguez»</b></li>
            </ul>
        </div>

        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3701.489300716953!2d-102.31544110000002!3d21.915733299999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8429ef1d8785c705%3A0x8bc11629b865eeec!2sEdificio%2014%20Radio%20UAA!5e0!3m2!1ses-419!2smx!4v1728190559481!5m2!1ses-419!2smx" 
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        


    <div class="social-buttons">
        <a href="https://wa.me/524499121588" target="_blank" class="social-button whatsapp">
            <i class="fab fa-whatsapp"></i>
        </a>
        <a href="https://www.instagram.com/radiouaa94.5fm?igsh=ZnpsMnBrcjdjMnZ1" target="_blank" class="social-button instagram">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.facebook.com/RadioUAA?mibextid=ZbWKwL" target="_blank" class="social-button facebook">
            <i class="fab fa-facebook"></i>
        </a>
        <a href="https://open.spotify.com/show/33OclgjRhmrjS1GaSAwXoU" target="_blank" class="social-button spotify">
            <i class="fab fa-spotify"></i>
        </a>
    </div>
    
    <div class="ContenedorBoton">
        <form id="search-form" onsubmit="return handleSearch(event);">
            <input type="text" placeholder="Buscar en Radio UAA..." id="search-input">
            <div class="boton" onclick="handleSearch(event)">
                <i class="fa fa-search"></i>
            </div>
        </form>
        <div id="search-results" style="display: none;"></div>
    </div>
    <br>
            <hr>
            <br>

            <div class="container-uaa">
                <a href="https://www.uaa.mx/portal/" target="_blank">
                    <img src="imgs/UAA-LOGO.png" alt="Logo UAA" class="logo-uaa">
                </a>
                <a href="https://www.uaa.mx/dgdv/" target="_blank">
                    <img src="imgs/UAA-DG.png" alt="Logo UAA" class="logo-uaa">
                </a>
                <a href="https://www.uaa.mx/portal/comunicacion/radio-y-tv/" target="_blank">
                    <img src="imgs/UAA-TV-RADIO.png" alt="Logo UAA" class="logo-uaa">
                </a>
            </div>
            <br>



    <footer>
        <p>© Derechos de autor 1978-2024 Radio UAA – Proyección de la voz universitaria | Política de privacidad | Transparencia</p>
    </footer>

    <script src="js/theme.js"></script> <!-- Script para el cambio de tema -->
    <script src="js/Galeria.js"></script>


</body>
</html>