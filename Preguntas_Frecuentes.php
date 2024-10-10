<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https:/use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">


    <title>Preguntas Frecuentes</title>
    <link rel="stylesheet" href="css/styles.css">
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
            </li>            <li><a href="#">Programación</a></li>
            <li><a href="#">Contenido</a></li>
            <li><a href="Contacto.html">Contacto</a></li>
        </ul>
        <!-- Botón Modo Oscuro -->
        <div>
            <label for="toggle" id="label_toggle"><i id="theme-icon" class="fa-solid fa-moon"></i></label>
            <input type="checkbox" id="toggle"style="display:none;">
        </div>
    </nav>

    <br>
    <br>


    <h1>Preguntas Frecuentes</h1> 

        <h2>¿Qué es Radio UAA?</h2>
        <p>Radio Universidad, nace el 13 de enero de 1978 con la premisa fundamental de ser un vínculo entre la Institución 
            y la sociedad en general, de manera especial con la comunidad de nuestra Máxima Casa de Estudios, transmitiendo 
            la cultura en sus diversas manifestaciones, el conocimiento, los valores y el quehacer universitario con plena 
            responsabilidad social.</p>

        <h2>¿Qué contenidos se transmiten en Radio UAA?</h2>
        <p>Radio Universidad, cuenta con una variada programación musical desde piezas clásicas hasta contemporáneas, 
            espacios informativos propios y nacionales, análisis de debate de temas políticos, históricos y de género, 
            así como de difusión académica y cultural.</p>

        <h2>¿Quién integra Radio UAA?</h2>
        <p>Radio UAA está encabezado por el Rector de la Universidad Autónoma de Aguascalientes (Dr. en C. Francisco Javier Avelar Gonzalez), 
            el Director General de Difusión y Vinculación (Dr. en T. Ismael Manuel Rodríguez Herrera), el Jefe de Departamento de Radio y 
            Televisión (Ing. en E. Uriel Landeros Pérez) y un excelente grupo de productores, reporteros, conductores, técnicos y colaboradores.</p>

        <h2>En mi navegador no se visualizan los contenidos apropiadamente.</h2>
        <p>Este sitio ha sido probado en Google Chrome. Para mejorar tu experiencia, puedes descargar la última versión de Google Chrome aquí. 
            Por favor, utiliza nuestra página de contacto para reportar cualquier inconveniente, pregunta y comentario.</p>

        <h2>¿En qué medios puedo escuchar Radio UAA?</h2>
        <p>Radio UAA, se puede sintonizar en Aguascalientes, MX en el 94.5 MHz de FM; así como a través de internet en radio.uaa.mx.</p>

        <h2>Soy miembro de la comunidad universitaria y tengo una idea de un programa.</h2>
        <p>Si te gustaría colaborar con Radio UAA entra en contacto con nosotros, estamos buscando gente interesada en participar con nosotros.</p>
        
        <h2>Soy externo a la comunidad universitaria y tengo una idea de un programa.</h2>
        <p>Si te gustaría colaborar con Radio UAA entra en contacto con nosotros, estamos buscando gente interesada en participar con nosotros.</p>
        
        <h2>¿Dónde encuentro el Aviso de Privacidad?</h2>
        <p>Consúltalo en Políticas de Privacidad y Términos de Servicio.</p>
        
        <h2>¿Dónde encuentro los términos de servicio?</h2>
        <p>Consúltalo en Políticas de Privacidad y Términos de Servicio</p>

    <div class="social-buttons">
        <!-- <a href="https://wa.me/yournumber" target="_blank" class="social-button whatsapp">
            <i class="fab fa-whatsapp"></i>
        </a>
        <a href="https://instagram.com/yourprofile" target="_blank" class="social-button instagram">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="https://facebook.com/yourpage" target="_blank" class="social-button facebook">
            <i class="fab fa-facebook"></i>
        </a> -->
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
    <p>© Derechos de autor 1978-2024 Radio UAA – Proyección de la voz universitaria   |   Política de privacidad   |  Transparencia</p>
</footer>


<script src="js/theme.js"></script> <!-- Script para el cambio de tema -->
<script src="js/search.js"></script>

    
</body>
</html>