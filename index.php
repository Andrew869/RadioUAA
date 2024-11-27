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

    function CheckRoutes(&$url) {
        // Eliminar caracteres innecesarios y descomponer la URL en segmentos
        // $url = rtrim($url, '/');
        $segments = explode('/', $url);
        
        // Obtener el último segmento de la URL
        // $last_segment = end($segments);
        
        // Verificar si el último segmento es un archivo (contiene un punto)
        if (count($segments) <= 1) {
            return true; // Es un archivo
        } else {
            if($segments[0] === "programa") {
                $url = "programa";
                return true;
            }
            else
                return false;
            // return false;
        }
    }

    function getRelativePath($request) {
        // Get the current URL
    
        // Calculate the number of directory levels from the root of the site
        $numLevels = substr_count($request, '/'); // Subtracting 2 because the URL includes '/' at the start and '/file.php' at the end
    
        if ($numLevels > 0) {
            $relativePath = '';
            for ($i = 0; $i < $numLevels; $i++) {
                $relativePath .= '../';
            }
            return $relativePath;
        }
    }

    $request = $_SERVER['REQUEST_URI'];

    // Filtrar la URL para evitar ataques y eliminar caracteres innecesarios
    $request = trim($request, '/');
    $initPath = getRelativePath($request);

    if(!CheckRoutes($request)){
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
    // if($request === "programa"){
    //     $initPath = "../";
    // }

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
    <link rel="shortcut icon" href="<?php echo $initPath ?>resources/img/logoRadioUAA.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo $initPath ?>css/normalize.css">
    <link rel="stylesheet" href="<?php echo $initPath ?>css/styles.css?v=<?php echo PROJECT_HASH ?>">
    <link rel="stylesheet" href="<?php echo $initPath ?>css/headerStyles.css?v=<?php echo PROJECT_HASH ?>">
    <link rel="stylesheet" href="<?php echo $initPath ?>css/playerStyles.css?v=<?php echo PROJECT_HASH ?>">
    <link rel="stylesheet" href="<?php echo $initPath ?>css/contacto.css?v=<?php echo PROJECT_HASH ?>">
    <link rel="stylesheet" href="<?php echo $initPath ?>css/contenido.css?v=<?php echo PROJECT_HASH ?>">
    <link rel="stylesheet" href="<?php echo $initPath ?>css/defensoria.css?v=<?php echo PROJECT_HASH ?>">
    <link rel="stylesheet" href="<?php echo $initPath ?>css/inicio.css?v=<?php echo PROJECT_HASH ?>">
    <link rel="stylesheet" href="<?php echo $initPath ?>css/nosotros.css?v=<?php echo PROJECT_HASH ?>">
    <link rel="stylesheet" href="<?php echo $initPath ?>css/programacion.css?v=<?php echo PROJECT_HASH ?>">
</head>
<body class="<?php echo $currentTheme ?>">
    <?php 
        include 'php/main_header.php';
    ?>

    <main id="content">
        <?php
            include($file);
        ?>
    </main>

    <?php include 'php/main_footer.php' ?>
    <script type="module" src="<?php echo $initPath ?>js/playerManager.js?v=<?php echo PROJECT_HASH ?>"></script>
    <!-- <script type="module" src="<?php echo $initPath ?>js/contenido.js?v=<?php echo PROJECT_HASH ?>"></script> -->
    <script type="module" src="<?php echo $initPath ?>js/searchManager.js?v=<?php echo PROJECT_HASH ?>"></script>
    <!-- <script src="<?php echo $initPath ?>js/Galeria.js"></script> -->
    <!-- <script type="module" src="<?php echo $initPath ?>js/utilities.js?v=<?php echo PROJECT_HASH ?>"></script> -->
    <script type="module" src="<?php echo $initPath ?>js/app.js?v=<?php echo PROJECT_HASH ?>"></script>
    <script type="module" src="<?php echo $initPath ?>js/light-dark-mode.js?v=<?php echo PROJECT_HASH ?>"></script>
    <script src="<?php echo $initPath ?>js/navbar.js?v=<?php echo PROJECT_HASH ?>"></script>
</body>
</html>
