<?php
    $jsInitPath = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $jsInitPath = $_POST['initPath'];
    }

    include_once $jsInitPath . 'php/db_connect.php';
?>
<h1>Contenido</h1>
<div class="container">
    <div class="controles">
        <select class="program-filter" id="filtroGenero">
            <option value="">Todos los géneros</option>
        </select>
        <select class="program-filter" id="filtroPresentador">
            <option value="">Todos los presentadores</option>
        </select>
        <input class="program-input" type="text" id="buscadorNombre" placeholder="Buscar por nombre">
        <button id="alternarVista" aria-label="Alternar vista">
            <svg class="toggle-view" id="icon" viewBox="0 0 24 24" width="24" height="24">
                <g id="gridIcon">
                    <rect x="3" y="3" width="8" height="8" />
                    <rect x="13" y="3" width="8" height="8" />
                    <rect x="3" y="13" width="8" height="8" />
                    <rect x="13" y="13" width="8" height="8" />
                </g>
                <g id="listIcon" style="display: none;">
                    <rect x="3" y="3" width="18" height="4" />
                    <rect x="3" y="10" width="18" height="4" />
                    <rect x="3" y="17" width="18" height="4" />
                </g>
            </svg>
        </button>
    </div>
    <div id="contenedorProgramas" class="lista">
        <?php
            // foreach ($programs as $program) {
            //     $name = $program['nombre_programa'];
            //     $url = $program['url_img'];
            //     $description = $program['descripcion'];
            //     $genres = $program['generos'];
            //     echo "<div class='programa'>";
            //         echo "<img src='$url.300' alt='$name'>";
            //         echo "<div class='programa-info'>";
            //             echo "<div class='programa-nombre'>$name</div>";
            //             echo "<div class='adicional-info'>";
            //                 echo "<div class='description'>$description</div>";
            //                 echo "<div class='generos' style='display: none;' >$genres</div>";
            //             echo "</div>";
            //         echo "</div>";
            //     echo "</div>";
            // }
        ?>
    </div>
</div>

<div id="modal" class="modal">
    <div class="contenido-modal">
        <span class="cerrar">&times;</span>
        <img id="imagenModal" class="imagen-modal" src="" alt="">
        <div class="modal-info">
            <h2 id="nombreModal"></h2>
            <p id="descripcionModal"></p>
            <p><strong>Horario:</strong> <span id="horarioModal"></span></p>
            <p><strong>Presentadores:</strong> <span id="presentadoresModal"></span></p>
            <p><strong>Género:</strong> <span id="generoModal"></span></p>
        </div>
        <div class="formulario-comentario">
            <h3>Agregar un comentario</h3>
            <input class="program-input" type="text" id="nombre" placeholder="Tu nombre" maxlength="20" required>
            <input class="program-input" type="email" id="email" placeholder="Tu correo electrónico" maxlength="20" required>
            <textarea id="mensaje" placeholder="Tu comentario" maxlength="100" required></textarea>
            <div id="error-mensaje" class="error"></div>
            <button onclick="agregarComentario()">Enviar comentario</button>
        </div>
        <div id="comentarios"></div>
    </div>
</div>