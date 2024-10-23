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
    <?php include 'main_header.php' ?>

    <div class="container"> 
        <div class="titulos">
        <h2>RADIO UAA <br> PROYECCION DE LA VOZ UNIVERSITARIA</h2>
        </div>
        <br><br>

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
            <img src="resources/img/tu_espacio.png" class="imgprog" alt="">
            <div class="descrip">
            <p class="title_descrip">   Tu Espacio</p>
            <p>   con Vladimir Guerrero</p>
            <p>   lunes 12:00 - 13:00</p>
            </div>
            
        </div>
        <div class="programas_div_impar">
            <img src="resources/img/dilemas eticos.png" class="imgprog" alt="">
            <div class="descrip">
            <p class="title_descrip">   Dilemas Eticos</p>
            <p>   con Juan Jose Lariz</p>
            <p>   lunes 11:00 - 12:00</p>
            </div>

        </div>

        <div class="programas_div_par">
            <img src="resources/img/estacionPolitica.jpg" class="imgprog" alt="">
            <div class="descrip">
            <p class="title_descrip">   Estacion Politica</p>
            <p>   Administrador del sitio</p>
            <p>   lunes 14:00 - 15:00</p>
            </div>
            
        </div>
        <div class="programas_div_impar">
            <img src="resources/img/dialogoporlacu.png" class="imgprog" alt="">
            <div class="descrip">
            <p class="title_descrip">   Dialogospor la Cultura</p>
            <p>   con Irlanda Godina</p>
            <p>   lunes 15:00 - 16:00</p>
            </div>

        </div>

    </div>
        
    
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
        <div class="app-buttons">
            <a href="https://play.google.com/store/search?q=radio+uaa+94.5fm&c=apps&pli=1" target="_blank" class="app-button google-play">
                <i class="fab fa-google-play"></i>
            </a>
            <a href="https://apps.apple.com/mx/app/radio-uaa-94-5fm/id6670407197" target="_blank" class="app-button apple-store">
                <i class="fab fa-apple"></i>
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
                <!-- <a href="https://www.uaa.mx/portal/comunicacion/radio-y-tv/" target="_blank">
                    <img src="resources/img/UAA-TV-RADIO.png" alt="Logo UAA" class="logo-uaa">
                </a> -->
            </div>
            <br>

    <?php include 'main_footer.php' ?>
    <script src="js/playerManager.js"></script>
</body>
</html>
