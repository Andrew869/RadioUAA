<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
    <title>Contenido</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/Contenido.css">
</head>

<body>
    <?php include 'main_header.php' ?>
    <div class="container">
        <div class="controles">
            <select id="filtroGenero">
                <option value="">Todos los géneros</option>
            </select>
            <select id="filtroPresentador">
                <option value="">Todos los presentadores</option>
            </select>
            <input type="text" id="buscadorNombre" placeholder="Buscar por nombre">
            <button id="alternarVista" aria-label="Alternar vista">
                <svg id="icon" viewBox="0 0 24 24" width="24" height="24">
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
        <div id="contenedorProgramas" class="cuadricula"></div>
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
        </div>
    </div>



    <?php include 'main_footer.php' ?>
    <script src="js/contenido.js"></script>
</body>
</html>
