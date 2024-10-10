<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Radio UAA</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/Index.css">
</head>
<body>

    <nav class="navbar">
        <div class="logo">
            <a href="Inicio.html">
                <img src="resources/img/logo-radio-uaa-blanco.png" alt="Radio UAA Logo" />
            </a>        
        </div>

        <!-- Botón Hamburguesa -->
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <ul class="nav-links" id="nav-links">
            <li><a href="Inicio.html">Home</a></li>
            <li class="dropdown">
                <a href="#" class="arrow-down">Nosotros</a>
                <ul class="dropdown-content">
                    <li><a href="Acerca de Radio UAA.html">Acerca de Radio UAA</a></li>
                    <li><a href="Preguntas_Frecuentes.html">Preguntas Frecuentes</a></li>
                    <li><a href="Consejo Ciudadano.html">Consejo Ciudadano</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="arrow-down">Defensoría</a>
                <ul class="dropdown-content">
                    <li><a href="#">Defensoría de las Audiencias</a></li>
                    <li><a href="#">Derechos de las Audiencias</a></li>
                    <li><a href="#">Quejas y Sugerencias</a></li>
                    <li><a href="#">Transparencia</a></li>
                    <li><a href="#">Políticas de privacidad</a></li>
                </ul>
            </li>         
            <li><a href="#">Programación</a></li>
            <li><a href="#">Contenido</a></li>
            <li><a href="Contacto.html">Contacto</a></li>
        </ul>

        <!-- Botón Modo Oscuro -->
        <div class="dark-mode-toggle">
            <label for="toggle" id="label_toggle" aria-label="Toggle Dark Mode">
                <i id="theme-icon" class="fa-solid fa-moon"></i>
            </label>
            <input type="checkbox" id="toggle" aria-hidden="true">
        </div>

        <!-- Search Icon -->
        <div id="cont-icon-search" aria-label="Search">
            <i class="fas fa-search" id="icon-search"></i>
        </div>
        <!-- Search Bar -->
        <div id="cont-bars-search">
            <input type="text" id="inputSearch" placeholder="Buscar en Radio UAA..." aria-label="Search">
        </div>
        <!-- Search Suggestions -->
    <ul id="box-search">
        <li><a href="Inicio.html"><i class="fas fa-search"></i>Inicio</a></li>
        <li><a href="Acerca de Radio UAA.html"><i class="fas fa-search"></i>Acerca de Radio UAA</a></li>
        <li><a href="Preguntas_Frecuentes.html"><i class="fas fa-search"></i>Preguntas Frecuentes</a></li>
        <li><a href="Consejo Ciudadano.html"><i class="fas fa-search"></i>Consejo Ciudadano</a></li>
        <li><a href="Contacto.html"><i class="fas fa-search"></i>Contacto</a></li>
    </ul>
    </nav>
    
    <div class="container"> 
        <div class="titulos">
        <h2>RADIO UAA <br> PROYECCION DE LA VOZ UNIVERSITARIA</h2>
        </div>
        <br>

        <div class="slider-box">
            <ul>
                <li>
                    <img src="resources/img/img-carru1.jpg" alt="">
                </li>
                <li>
                    <img src="resources/img/img-carru1.2.jpg" alt="">
                </li>
                <li>
                    <img src="resources/img/img-carri1.3.jpg" alt="">
                </li>
                <li>
                    <img src="resources/img/img-carru1.4.jpeg" alt="">
                </li>
            </ul>
        </div>
    </div>
    

    <div class="player container-radio-player">
        <div class="radio-player">
            <audio id="audio" src="https://streamingcwsradio30.com/8148/stream"></audio>
            <div id="loading" class="loading">Cargando...</div>
            <div class="station-info">
                <h2>Radio UAA</h2>
                <p id="metadata">Transmisión en vivo</p>
            </div>
            <div class="controls">
                <button id="playPauseBtn"><i id="playPauseIcon" class="fa-solid fa-play"></i></button>
                <button id="syncBtn"><i class="fa-solid fa-rotate"></i></button>
            </div>
            <div class="volume-control">
                <label for="volumeSlider">Volumen:</label>
                <input type="range" id="volumeSlider" min="0" max="1" step="0.01" value="1">
                    <!-- <input type="range" id="seekBar" min="0" value="1"> -->
                    <!-- <div id="currentTime">0:00</div> -->
                    <!-- <div id="duration">0:00</div> -->
            </div>
        </div>
    </div>
    <div class="programacion_cont">
        <div class="programas_div_par">
            <img src="/resources/img/tu_espacio.png" class="imgprog" alt="">
            <div class="descrip">
            <p class="title_descrip">   Tu Espacio</p>
            <p>   con Vladimir Guerrero</p>
            <p>   lunes 12:00 - 13:00</p>
            </div>
            
        </div>
        <div class="programas_div_impar">
            <img src="/resources/img/dilemas eticos.png" class="imgprog" alt="">
            <div class="descrip">
            <p class="title_descrip">   Dilemas Eticos</p>
            <p>   con Juan Jose Lariz</p>
            <p>   lunes 11:00 - 12:00</p>
            </div>

        </div>

        <div class="programas_div_par">
            <img src="/resources/img/estacionPolitica.jpg" class="imgprog" alt="">
            <div class="descrip">
            <p class="title_descrip">   Estacion Politica</p>
            <p>   Administrador del sitio</p>
            <p>   lunes 14:00 - 15:00</p>
            </div>
            
        </div>
        <div class="programas_div_impar">
            <img src="/resources/img/dialogoporlacu.png" class="imgprog" alt="">
            <div class="descrip">
            <p class="title_descrip">   Dialogospor la Cultura</p>
            <p>   con Irlanda Godina</p>
            <p>   lunes 15:00 - 16:00</p>
            </div>

        </div>

    </div>
        
    
        <script src="js/playerManager.js"></script> <!-- Enlaza el archivo JS -->
        <script src="https://kit.fontawesome.com/9b86802e8e.js" crossorigin="anonymous"></script>
 

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
    
            <hr>
            <br>

            <div class="container-uaa">
                <a href="https://www.uaa.mx/portal/" target="_blank">
                    <img src="resources/img/UAA-LOGO.png" alt="Logo UAA" class="logo-uaa">
                </a>
                <a href="https://www.uaa.mx/dgdv/" target="_blank">
                    <img src="resources/img/UAA-DG.png" alt="Logo UAA" class="logo-uaa">
                </a>
                <a href="https://www.uaa.mx/portal/comunicacion/radio-y-tv/" target="_blank">
                    <img src="resources/img/UAA-TV-RADIO.png" alt="Logo UAA" class="logo-uaa">
                </a>
            </div>
            <br>

<footer>
    <p>© Derechos de autor 1978-2024 Radio UAA – Proyección de la voz universitaria   |   Política de privacidad   |  Transparencia</p>
</footer>

<script src="js/barrabuscar.js"></script>
<script src="js/navbar.js"></script>
<script src="js/theme.js"></script>
</body>
</html>
