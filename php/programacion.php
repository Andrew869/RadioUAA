<?php
    include "db_connect.php";

    $hourHeight = 160; // 40px
    $maxSize = 18;
    $hourSize = ($hourHeight/2 <= $maxSize? $hourHeight/2 : $maxSize );
    $contentHeight = 24*$hourHeight;

    function GetHexa() {
        // Generar componentes de color RGB aleatorios
        $r = str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
        $g = str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
        $b = str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
        
        // Combinar componentes en un color hexadecimal
        $color = '#' . $r . $g . $b;
        
        return $color;
    }

    // Consulta SQL para obtener los programas ordenados por día y hora
    $sql = "
        SELECT p.id_programa, p.nombre_programa, p.url_img, h.dia_semana, h.hora_inicio, h.hora_fin, h.es_retransmision
        FROM programa p
        INNER JOIN horario h ON p.id_programa = h.id_programa
        ORDER BY h.dia_semana, h.hora_inicio;
    ";
    
    // Preparar la consulta
    $stmt = SQL::$conn->prepare($sql);
    // Ejecutar la consulta
    $stmt->execute();
    // Obtener todos los resultados en forma de arreglo asociativo
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Arreglo donde almacenaremos los programas por día
    $programs = array();
    
    $prevFin = "00:00:00";
    // $prevDay = "";

    // Iterar sobre los resultados y organizar por día
    foreach ($rows as $row) {
        $dia = $row['dia_semana'];

        // if($prevDay !== $dia){
        //     $prevFin = "00:00:00";
        //     $prevDay = $dia;
        // }

        $inicio = $row['hora_inicio'];
        $fin = $row['hora_fin'];

        if($prevFin !== $inicio){
            $programa = array(
                'id_programa' => "0",
                'nombre_programa' => "void",
                'url_img' => "",
                'hora_inicio' => "$prevFin",
                'hora_fin' => $inicio,
                'es_retransmision' => "0"
            );
            $programs[$dia][] = $programa;
        }

        $programa = array(
            'id_programa' => $row['id_programa'],
            'nombre_programa' => $row['nombre_programa'],
            'url_img' => $row['url_img'],
            'hora_inicio' => $row['hora_inicio'],
            'hora_fin' => $row['hora_fin'],
            'es_retransmision' => $row['es_retransmision']
            // 'color' => GetHexa()
        );
    
        // Añadir el programa al día correspondiente
        if (!isset($programs[$dia])) {
            $programs[$dia] = array();
        }
        $programs[$dia][] = $programa;

        $prevFin = $fin;
    }

    // $colores = [
    //     "#FF5733", "#FFC300", "#36D7B7", "#3498DB", "#9B59B6",
    //     "#E74C3C", "#F39C12", "#2ECC71", "#1ABC9C", "#3498DB",
    //     "#34495E", "#2980B9", "#8E44AD", "#C0392B", "#D35400",
    //     "#27AE60", "#16A085", "#2980B9", "#8E44AD", "#2C3E50",
    //     "#F1C40F", "#E67E22", "#E74C3C", "#ECF0F1"
    // ];
    
    // Imprimir el arreglo de programas por día (para propósitos de demostración)
    // echo "<pre>";
    // print_r($programs);
    // echo "</pre>";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Horarios</title>
    <style>
        td {
            /* background-color: #fff; */
            font-size: <?php echo $hourSize . "px" ?>;
            height: <?php echo $hourHeight . "px" ?>
        }
        .pro{
            height: <?php echo $contentHeight . "px" ?>;
            position: relative;
        }
        .pro > div {
            left: 0;
            position: absolute;
            border: solid #ddd;
            border-width: 0 0 1px 0;
            /* border-radius: 6px; */
            width: 100%;
            font-size: .8rem;
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: end;
            overflow: hidden;
            cursor: pointer;
        }

        .pro > div img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            position: absolute;
            transition: transform 0.2s ease, object-fit 0.2s ease;
        }
        .pro > div:hover img {
            transform: scale(1.2);
            /* object-fit: contain; */
        }

        .pro > div:last-child {
            border-width: 0 0 0 0;
            /* border-radius: 0 0 12px 0; */
        }
        .pro > div:hover{
            /* background-color: #f2f2f2; */
        }
        .pro > div:nth-child(odd) {
            /* background-color: #F9F9F9; */
        }
        .program-info {
            color: white;
            width: 100%;
            height: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: rgb(0, 0, 0); /* Fallback color */
            background: rgba(0, 0, 0, 0.8);
            position: absolute;
            /* text-align: left; */
            /* border-radius: 0 0 6px 6px; */
        }
        .tag-info {
            color: white;
            font-size: 0.8rem;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 4px;
            background-color: #f39c12;
            position: absolute;
            top: 5px;
            right: 5px;
        }
        .program-info > div:not(:last-child) {
            width: 100%;
            white-space: nowrap; /* Evita el salto de línea */
            overflow: hidden; /* Oculta el texto que se desborda */
            text-overflow: ellipsis;
        }
        /* .i16_0_60{
            background-color: red;
            top: 0;
            height: 40px;
        }
        .i76_60_120{
            background-color: yellow;
            top: 40px;
            height: 40px;
        } */
        <?php
            $cssSelectors = [];
            foreach ($programs as $day) {
                foreach ($day as $program) {
                    $id_programa = $program['id_programa'];
                    // $url = $program['url_img'];
                    $inicio = ToMinutes($program['hora_inicio']);
                    $fin = ToMinutes($program['hora_fin']);
                    $cssSelector = ".i$id_programa" . '_' . $inicio . '_' . $fin;
                    if (!in_array($cssSelector, $cssSelectors)) {
                        // Si no ha sido impreso, imprimir y agregar al arreglo
                        $total = ($inicio > $fin && $fin === 0) ? 60 * 24 - $inicio : $fin - $inicio;
                        $height = $total * $hourHeight / 60 . "px";
                        $yPos = $inicio * $contentHeight / 1440 . "px";
                        
                        echo "$cssSelector { height: $height; top: $yPos; }";
                        
                        $cssSelectors[] = $cssSelector; // Agregar el selector al arreglo
                    }
                }
            }
        ?>
    </style>
</head>
<body>
<div>
    <table>
        <thead>
        <tr>
                <th>Horas</th>
                <th class="day-column">Lunes</th>
                <th class="day-column">Martes</th>
                <th class="day-column">Miércoles</th>
                <th class="day-column">Jueves</th>
                <th class="day-column">Viernes</th>
                <th class="day-column">Sábado</th>
                <th class="day-column">Domingo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>00:00 - 01:00</td>
                <?php
                    foreach ($programs as $day) {
                        $numday = array_key_first($day);
                        echo "<td rowspan='24' class='pro'>";
                        foreach ($day as $key => $program) {
                            $id_programa = $program['id_programa'];
                            $urlImg = $program['url_img'];
                            $h_inicio = date("H:i", strtotime($program['hora_inicio']));
                            $h_fin = date("H:i", strtotime($program['hora_fin']));
                            $inicio = ToMinutes($program['hora_inicio']);
                            $fin = ToMinutes($program['hora_fin']);
                            // echo "<div class='a" . $inicio . '_' . $fin . "'>$h_inicio - $h_fin</div>";
                            echo "<div class='i$id_programa" . '_' . $inicio . '_' . $fin . "'>";
                            if($id_programa){
                                echo "<img src='../$urlImg.300' alt='void'>";
                                echo ($program['es_retransmision']? "<div class='tag-info'>Retransmision</div>" : '' );
                                echo "<div class='program-info'>";
                                    echo "<div>" . htmlspecialchars($program['nombre_programa']) . "</div>";
                                    echo "<div>De $h_inicio a $h_fin</div>";
                                echo"</div>";
                            }
                            echo"</div>";
                        }
                        echo "</td>";
                    }
                ?>
            </tr>
            <?php
                for ($i=60; $i < 1440; $i+=60) {
                    $start = ToHours($i);
                    $end = ToHours($i + 60);
                    $end = ($end === '24:00'? "00:00" : $end );
                    echo "<tr><td>" . $start . " - " . $end . "</td></tr>";
                }
            ?>
        </tbody>
    </table>
</div>
<hr>

</body>
</html>
