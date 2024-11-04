<?php 
    include 'php/utilities.php';

    $request = $_SERVER['REQUEST_URI'];

    // Filtrar la URL para evitar ataques y eliminar caracteres innecesarios
    $request = trim($request, '/');

    $file = null;
    // Verificar qué página se solicita
    switch ($request) {
        case 'inicio':
        case 'nosotros':
        case 'preguntas-frecuentes':
        case 'consejo-ciudadano':
        case 'defensoria-de-las-audiencias':
        case 'derechos-de-la-audiencia':
        case 'quejas-sugerencias':
        case 'transparencia':
        case 'politica-de-privacidad':
        case 'programacion':
        case 'contenido':
        case 'contacto':
            $file = "pages/$request.html";
            break;
        case '':
            $file = 'pages/inicio.html';
            break;
        default:
            // Página no encontrada (404)
            $file = 'pages/404.html';
            break;
    } 

    if( $_SERVER["REQUEST_METHOD"] == "POST"){
        echo file_get_contents($file);
        exit();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Radio UAA</title>
    <link rel="stylesheet" href="css/styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/Contacto.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/Contenido.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/Defensoria.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/Index.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/Nosotros.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/programacion.css?v=<?php echo time(); ?>">
</head>
<body class="<?php echo ($currentTheme === 'dark' ? $currentTheme : '')?>">
    <?php 
        include 'php/main_header.php';
        include 'pages/player.html';
    ?>

    <main id="content">
        <?php
            include($file);
        ?>
    </main>

    <?php include 'php/main_footer.php' ?>
    <script src="js/playerManager.js?v=<?php echo time(); ?>"></script>
    <script type="module" src="js/contenido.js?v=<?php echo time(); ?>"></script>
    <!-- <script src="js/Galeria.js"></script> -->
    <script type="module" src="js/app.js?v=<?php echo time(); ?>"></script>
</body>
</html>
