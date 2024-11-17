<?php
    define('PROJECT_HASH', '2a4a54');
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

    function GetCurrProgram(){
        $sql = "
            SELECT p.id_programa, p.nombre_programa, p.url_img, h.dia_semana, h.hora_inicio, h.hora_fin, h.es_retransmision
            FROM programa p
            INNER JOIN horario h ON p.id_programa = h.id_programa
            WHERE (WEEKDAY(NOW()) + 1) = h.dia_semana AND TIME(NOW()) >= h.hora_inicio
            ORDER BY h.dia_semana, h.hora_inicio DESC
            LIMIT 1;
        ";

        $stmt = SQL::$conn->prepare($sql);
        // Ejecutar la consulta
        $stmt->execute();
        // Obtener todos los resultados en forma de arreglo asociativo
        $program = $stmt->fetch(PDO::FETCH_ASSOC);

        return $program;
    }

    function GetNextPrograms($maxPrograms){
        $sql = "
            SELECT p.id_programa, p.nombre_programa, p.url_img, h.dia_semana, h.hora_inicio, h.hora_fin, h.es_retransmision
            FROM programa p
            INNER JOIN horario h ON p.id_programa = h.id_programa
            WHERE (WEEKDAY(NOW()) + 1) = h.dia_semana AND TIME(NOW()) < h.hora_inicio
            ORDER BY h.dia_semana, h.hora_inicio
            LIMIT $maxPrograms;
        ";

        $stmt = SQL::$conn->prepare($sql);
        // Ejecutar la consulta
        $stmt->execute();
        // Obtener todos los resultados en forma de arreglo asociativo
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $programs = array_merge($rows);

        $currDay = date("N");
        $nextDay = $currDay;
        $nextHour = "00:00:00";
        // $tmp = 1;
        while(count($programs) < $maxPrograms){
            if($nextDay < 7)
                $nextDay++;
            else
                $nextDay = 1;

            $sql = "SELECT p.id_programa, p.nombre_programa, p.url_img, h.dia_semana, h.hora_inicio, h.hora_fin, h.es_retransmision
                FROM programa p
                INNER JOIN horario h ON p.id_programa = h.id_programa
                WHERE $nextDay = h.dia_semana AND h.hora_inicio >= '$nextHour'
                ORDER BY h.dia_semana, h.hora_inicio
                LIMIT $maxPrograms;
            ";

            // $tmp++;

            $stmt = SQL::$conn->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $left = $maxPrograms - count($programs);

            if($left > count($rows))
                $left = count($rows);

            for ($i=0; $i < $left; $i++) { 
                array_push($programs, $rows[$i]);
            }

            // $programs = array_merge($rows);

        }

        return $programs;
    }
?>