<?php 
    include_once 'php/db_connect.php';
    include_once 'php/utilities.php';

    // $carpeta = '../';

    // if (is_dir($carpeta)) {
    //     $fecha_modificacion = filemtime($carpeta);
    //     echo "La carpeta fue modificada por última vez el: " . date("Y-m-d H:i:s", $fecha_modificacion);
    // } else {
    //     echo "La ruta no corresponde a una carpeta válida.";
    // }

    function IsFILE($url) {
        // Eliminar caracteres innecesarios y descomponer la URL en segmentos
        $url = rtrim($url, '/');
        $segments = explode('/', $url);
        
        // Obtener el último segmento de la URL
        // $last_segment = end($segments);
        
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

    $js_path = 'js/app.js';

    $js_content = file_get_contents($js_path);
    $pattern = '/const routes = (\{[^;]+)\;/s';
    preg_match($pattern, $js_content, $matches);

    $routes_json = $matches[1];
    
    $routes = json_decode($routes_json, true);

    // Decodificar el contenido JSON a un array asociativo
    // $routes = json_decode($jsonData, true);

    $file = $routes[$request];

    if(!$file)
        $file = 'pages/404.html';

    // Verificar qué página se solicita
    // switch ($request) {
    //     case 'nosotros':
    //     case 'preguntas-frecuentes':
    //     case 'consejo-ciudadano':
    //     case 'defensoria-de-las-audiencias':
    //     case 'derechos-de-la-audiencia':
    //     case 'quejas-sugerencias':
    //     case 'transparencia':
    //     case 'politica-de-privacidad':
    //     case 'contenido':
    //     case 'contacto':
    //         $file = "pages/$request.html";
    //         break;
    //     case 'programacion':
    //         $file = 'php/programacion.php';
    //         break;
    //     case '':
    //     case 'inicio':
    //         $file = 'php/inicio.php';
    //         break;
    //     case '404':
    //     default:
    //         // Página no encontrada (404)
    //         $file = 'pages/404.html';
    //         break;
    // } 

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
    <link rel="shortcut icon" href="resources/img/logoRadioUAA.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/styles.css?v=<?php echo PROJECT_HASH ?>">
    <link rel="stylesheet" href="css/headerStyles.css?v=<?php echo PROJECT_HASH ?>">
    <link rel="stylesheet" href="css/playerStyles.css?v=<?php echo PROJECT_HASH ?>">
    <link rel="stylesheet" href="css/contacto.css?v=<?php echo PROJECT_HASH ?>">
    <link rel="stylesheet" href="css/contenido.css?v=<?php echo PROJECT_HASH ?>">
    <link rel="stylesheet" href="css/defensoria.css?v=<?php echo PROJECT_HASH ?>">
    <link rel="stylesheet" href="css/inicio.css?v=<?php echo PROJECT_HASH ?>">
    <link rel="stylesheet" href="css/nosotros.css?v=<?php echo PROJECT_HASH ?>">
    <link rel="stylesheet" href="css/programacion.css?v=<?php echo PROJECT_HASH ?>">
</head>
<body class="<?php echo ($currentTheme === 'dark' ? $currentTheme : '')?>">
    <?php 
        include 'php/main_header.php';
    ?>

    <main id="content">
        <?php
            include($file);
        ?>
    </main>

    <?php include 'php/main_footer.php' ?>
    <script type="module" src="js/playerManager.js?v=<?php echo PROJECT_HASH ?>"></script>
    <!-- <script type="module" src="js/contenido.js?v=<?php echo PROJECT_HASH ?>"></script> -->
    <script type="module" src="js/searchManager.js?v=<?php echo PROJECT_HASH ?>"></script>
    <!-- <script src="js/Galeria.js"></script> -->
    <!-- <script type="module" src="js/utilities.js?v=<?php echo PROJECT_HASH ?>"></script> -->
    <script type="module" src="js/app.js?v=<?php echo PROJECT_HASH ?>"></script>
</body>
</html>
