<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https:/use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">

    <title>Contenido</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/Contenido.css">
</head>

<body>
    <?php include 'main_header.php' ?>

    <div class="container">
        <h2>Contenido</h2>
        <div class="grid" id="programas-grid"></div>
    </div>

    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3 id="modal-titulo"></h3>
            <img id="modal-imagen" class="modal-image">
            <p><strong>Presentado por <br></strong> <span id="modal-produccion"></span></p>
            <p><strong>Género <br></strong> <span id="modal-genero"></span></p>
            <p><strong>Horario <br></strong> <span id="modal-horario"></span> </p>
            <p><strong>Acerca del programa <br></strong> <span id="modal-descripcion"></span></p>

            <!-- Formulario de comentarios -->
            <p>Deja tu comentario!</p> 
            <form id="form-comentario"">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                <label for="comentario">Comentario:</label>
                <textarea id="comentario" name="comentario" required></textarea>
                <button type="submit">Publicar comentario</button>
            </form>
        </div>
    </div>
    <?php include 'main_footer.php' ?>
    <script src="js/contenido.js"></script>
</body>
</html>