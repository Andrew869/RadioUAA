<?php
    $jsInitPath = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $jsInitPath = $_POST['initPath'];
    }

    include_once $jsInitPath . 'php/db_connect.php';
?>
<h1>Contenido</h1>
<div class="container">
    <div class="controles c1">
        <select class="program-filter c2" id="filtroGenero">
            <option value="">Todos los géneros</option>
        </select>
        <select class="program-filter c2" id="filtroPresentador">
            <option value="">Todos los presentadores</option>
        </select>
        <input class="program-input c2" type="text" id="buscadorNombre" placeholder="Buscar por nombre">
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