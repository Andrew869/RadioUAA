<?php 
    include 'php/utilities.php';

    function IsFILE($url) {
        // Eliminar caracteres innecesarios y descomponer la URL en segmentos
        $url = rtrim($url, '/');
        $segments = explode('/', $url);
        
        // Obtener el último segmento de la URL
        $last_segment = end($segments);
        
        // Verificar si el último segmento es un archivo (contiene un punto)
        if (count($segments) <= 1) {
            return true; // Es un archivo
        } else {
            return false; // Es una carpeta
        }
    }

    $request = $_SERVER['REQUEST_URI'];

    // Filtrar la URL para evitar ataques y eliminar caracteres innecesarios
    $request = trim($request, '/');

    if(!IsFILE($request)){
        header('Location: /404');
    }

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
        case 'contenido':
        case 'contacto':
            $file = "pages/$request.html";
            break;
        case 'programacion':
            $file = 'php/programacion.php';
            break;
        case '':
            $file = 'pages/inicio.html';
            break;
        case '404':
        default:
            // Página no encontrada (404)
            $file = 'pages/404.html';
            break;
    } 

    // if( $_SERVER["REQUEST_METHOD"] == "POST"){
    //     // echo file_get_contents($file);
    //     include($file);
    //     exit();
    // }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radio UAA</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/headerStyles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/playerStyles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/contacto.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/contenido.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/defensoria.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/inicio.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/nosotros.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/programacion.css?v=<?php echo time(); ?>">
</head>
<body class="<?php echo ($currentTheme === 'dark' ? $currentTheme : '')?>">
    <?php 
        include 'php/main_header.php';
    ?>

    <main>
        <!-- <iframe 
        src="https://www.facebook.com/plugins/video.php?height=314&href=https%3A%2F%2Fwww.facebook.com%2FRadioUAA%2Fvideos%2F1095161882345068%2F&show_text=false&width=560&t=0" 
        width="560" 
        height="314" 
        style="border:none;overflow:hidden" 
        scrolling="no" 
        frameborder="0" 
        allowfullscreen="false" 
        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
    </iframe> -->
        <div id="content">
            <?php
                include($file);
            ?>
        </div>
    </main>

    <?php include 'php/player.php' ?>
    <?php include 'php/main_footer.php' ?>
    <script type="module" src="js/playerManager.js?v=<?php echo time(); ?>"></script>
    <script type="module" src="js/contenido.js?v=<?php echo time(); ?>"></script>
    <!-- <script src="js/Galeria.js"></script> -->
    <script type="module" src="js/app.js?v=<?php echo time(); ?>"></script>
</body>
</html>
