<?php 
    // include_once "db_connect.php";

    // $currentTime = date("H:i:s\n");

    // $sql = "
    //     SELECT p.id_programa, p.nombre_programa, p.url_img, h.dia_semana, h.hora_inicio, h.hora_fin, h.es_retransmision
    //     FROM programa p
    //     INNER JOIN horario h ON p.id_programa = h.id_programa
    //     WHERE (WEEKDAY(NOW()) + 1) = h.dia_semana AND TIME(NOW()) >= h.hora_inicio
    //     ORDER BY h.dia_semana, h.hora_inicio DESC
    //     LIMIT 1;
    // ";

    // $stmt = SQL::$conn->prepare($sql);
    // // Ejecutar la consulta
    // $stmt->execute();
    // // Obtener todos los resultados en forma de arreglo asociativo
    // $program = $stmt->fetch(PDO::FETCH_ASSOC);

    $program = GetCurrProgram();
?>
<!-- <div class="player container-radio-player"> -->
    <div class="radio-player <?php echo $currentTheme ?>">
        <audio id="audio" src="https://streamingcwsradio30.com/8148/stream"></audio>
        <div class="current-program-info">
            <img src="<?php echo $initPath . $program['url_img'] ?>.300" alt="logo_programa" class="c1 <?php echo $currentTheme ?>">
            <div>
                <div>
                    <span class="curr-pro-txt">
                        Programa actual
                    </span>
                </div>
                <div>
                    <span class="curr-pro">
                        <?php echo $program['nombre_programa'] ?>
                    </span>
                </div>
                <div class="container-tag-info">
                    <?php
                    $tagText = $program['es_retransmision'] ? "Retransmision" : "En vivo";
                    $tagClass = $program['es_retransmision'] ? "retransmission" : "live";
                    echo "<span class='current-tag-info $tagClass'>";
                    echo $tagText;
                    echo "</span>";
                    ?>
                </div>
            </div>
        </div>
        <!-- <div id="loading" class="loading">Cargando...</div> -->
        <!-- <div class="station-info">
            <h2>Radio UAA</h2>
            <p id="metadata">Transmisión en vivo</p>
        </div> -->
        <div class="controls c1 <?php echo $currentTheme ?>">
            <!-- <div class="control-buttons"> -->
                <button id="syncBtn" class="c2 <?php echo $currentTheme ?>">Sincronizar</button>
                <button id="playPauseBtn" class="c2 <?php echo $currentTheme ?>">
                    <?php echo GetSVG('resources/img/svg/play.svg', ["24px", "24px", "black"]) ?>
                </button>
                <div class="volume-control c2 <?php echo $currentTheme ?>">
                    <div class="icon">
                        <?php echo GetSVG('resources/img/svg/volume-high.svg', ["18px", "18px", "black"]) ?>
                    </div>
                    <input class="slider customRange" type="range" id="volumeSlider" min="0" max="1" step="0.01" value="1"/>
                </div>
            <!-- </div> -->
        </div>

        <!-- <div class="app-promo">
            <div class="app-promo-content">
                <p>¡Descarga nuestra nueva app!</p>
                <p>Disponible para Android y iOS</p>
                <div class="app-links">
                    <a href="#" class="app-link android">Descargar para Android</a>
                    <a href="#" class="app-link ios">Descargar para iOS</a>
                </div>
            </div>
        </div> -->
    </div>
<!-- </div> -->