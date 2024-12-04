<?php
    $mayProceed = true;
    $jsInitPath = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $initPath = '';
        $jsInitPath = $_POST['initPath'];
        $request = $_POST['REQUEST_URI'];
    }
    else {
        $request = $_SERVER['REQUEST_URI'];
    }

    include_once $jsInitPath . 'php/db_connect.php';

    $request = rtrim($request, '/');
    $segments = explode('/', $request);


    if(count($segments) > 3)
        $mayProceed = false;

    $program_id = $segments[2];

    if(ctype_digit($program_id))
        if($program_id <= 0)
            $mayProceed = false;

    $sql = "
        SELECT 
            p.id_programa AS id,
            p.nombre_programa AS nombre,
            p.url_img AS imagen,
            p.descripcion,
            (
                SELECT GROUP_CONCAT(pr.nombre_presentador SEPARATOR ', ')
                FROM programa_presentador pp
                JOIN presentador pr ON pp.id_presentador = pr.id_presentador
                WHERE pp.id_programa = p.id_programa
            ) AS presentadores,
            (
                SELECT GROUP_CONCAT(g.nombre_genero SEPARATOR ', ')
                FROM programa_genero pg
                JOIN genero g ON pg.id_genero = g.id_genero
                WHERE pg.id_programa = p.id_programa
            ) AS generos
        FROM programa p
        WHERE p.id_programa = :id_programa;
    ";
    $stmt = SQL::$conn->prepare($sql);
    $stmt->bindParam(':id_programa', $program_id);

    $stmt->execute();

    $program = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$program)
        $mayProceed = false;

    // echo "<pre>";
    // print_r($program);
    // echo "</pre>";

    if(!$mayProceed) {
        include "pages/404.html";
    }
    else{
        $dias_semana = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
            7 => 'Domingo'
        ];
        $presentadores = explode(',',$program['presentadores']);
        $generos = explode(',',$program['generos']);
        $horarios = SQL::Select(SQL::HORARIO, ["id_programa" => $program['id']], [], "dia_semana", SQL::ASCENDANT)->fetchAll(PDO::FETCH_ASSOC);
    
?>
<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $program['nombre']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .program-details {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        .program-image {
            flex: 0 0 300px;
        }
        .program-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .program-info {
            flex: 1;
        }
        .program-title {
            font-size: 28px;
            font-weight: bold;
            color: #000000;
        }
        .program-description {
            margin-bottom: 15px;
            line-height: 1.6;
        }
        .program-metadata {
            margin-bottom: 15px;
        }
        .program-metadata strong {
            font-weight: bold;
        }
        .schedule-group {
            background-color: #f0f0f0;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .schedule-days {
            list-style-type: none;
            padding: 0;
            margin: 0 0 5px 0;
        }
        .schedule-days li {
            display: inline-block;
            background-color: #e0e0e0;
            padding: 3px 8px;
            margin-right: 5px;
            border-radius: 3px;
            font-size: 14px;
        }
        .schedule-time {
            font-size: 14px;
        }
        .schedule-tag {
            font-size: 12px;
            font-weight: bold;
        }
        .schedule-tag .live {
            color: green;
        }
        .schedule-tag .retransmission {
            color: orange;
        }
        
        .comments-section h2 {
            margin-bottom: 2px; 
        }

        .comment-form input:first-of-type {
            margin-top: 10px;
        }

        .comment-form input,
        .comment-form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
            max-width: 100%; 
        }
        .comment-form button {
            background-color: #5eaf4d;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        .comment-form button:hover {
            background-color: #3c6229;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="program-details">
            <div class="program-image">
                <img src="https://radio.uaa.mx/wp-content/uploads/2024/04/Captura-de-Pantalla-2024-04-04-a-las-9.47.15-300x135.png">
            </div>
            <div class="program-info">
                <h1 class="program-title"><?php echo $program['nombre']; ?></h1>
                <p class="program-description"><?php echo $program['descripcion']; ?></p>
                <div class="program-metadata">
                    <p><strong>Presentadores:</strong> <?php echo $program['presentadores']; ?></p>
                    <p><strong>Género:</strong> <?php echo $program['generos']; ?></p>
                </div>
                <div class="program-schedule">
                    <h2>Horarios</h2>
                    <?php
                    foreach ($groups as $key => $group) {
                        echo "<div class='schedule-group'>";
                        echo "<ul class='schedule-days'>";
                        foreach ($group as $horario) {
                            echo "<li>" . $dias_semana[$horario['dia_semana']] . "</li>";
                        }
                        echo "</ul>";
                        list($inicio, $fin, $retra) = explode(',', $key);
                        $timeRange = "De " . MinutesToTime($inicio) . " a " . MinutesToTime($fin);
                        echo "<div class='schedule-time'>$timeRange</div>";
                        $tagText = ($retra ? "Retransmisión" : "En vivo");
                        $tagStatus = ($retra ? "retransmission" : "live");
                        echo "<div class='schedule-tag'><span class='$tagStatus'>$tagText</span></div>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
        
        <div class="comments-section">
            <h2>Agregar un comentario</h2>
            <form class="comment-form">
                <input type="text" id="nombre" placeholder="Tu nombre" maxlength="20" required>
                <input type="email" id="email" placeholder="Tu correo electrónico" maxlength="20" required>
                <textarea id="mensaje" placeholder="Tu comentario" maxlength="100" required></textarea>
                <div id="error-mensaje" class="error"></div>
                <button type="button" onclick="agregarComentario()">Enviar</button>
            </form>
            <div id="comentarios"></div>
        </div>
    </div>

</body>
</html>
<?php
    }
?>