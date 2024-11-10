<?php
    $currentTheme = null;
    if(isset($_COOKIE['theme']))
        $currentTheme = $_COOKIE['theme'];
    else
        $currentTheme = 'light';

    $iconProperties = [
        'dark' => [
            'url' => 'resources/img/svg/sun.svg',
            'styles' => ["18px", "18px", "white"]
        ],
        'light' => [
            'url' => 'resources/img/svg/moon.svg',
            'styles' => ["18px", "18px", "white"]
        ]
    ];

    function GetSVG($url, $styles) {
        // Obtener el contenido del archivo SVG
        $svgContent = file_get_contents($url);
        
        if ($svgContent === false) {
            return 'Error al cargar el archivo SVG.';
        }
    
        // Extraer los estilos
        list($width, $height, $fill) = $styles;
    
        // Reemplazar width
        $svgContent = preg_replace('/width:\s*\d+px/', "width: $width", $svgContent);
    
        // Verificar si el height ya está en el SVG
        if (strpos($svgContent, 'height:') !== false) {
            // Reemplazar el height si existe
            $svgContent = preg_replace('/height:\s*\d+px/', "height: $height", $svgContent);
        } else {
            // Agregar el height si no existe
            $svgContent = preg_replace('/style="/', "style=\"height: $height; ", $svgContent);
        }
    
        if($fill !== ''){
            // Reemplazar fill si existe, o agregarlo si no
            if (strpos($svgContent, 'fill:') !== false) {
                $svgContent = preg_replace('/fill:\s*[^;]+/', "fill: $fill", $svgContent);
            } else {
                // Si no existe, agregar fill al estilo
                $svgContent = preg_replace('/style="/', "style=\"fill: $fill; ", $svgContent);
            }
        }
    
        return $svgContent;
    }
?>