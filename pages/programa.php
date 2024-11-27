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
    <img id="imagenModal" class="imagen-modal" src="<?php echo $initPath . $program['imagen'] ?>" alt="imagen programa">
    <div class="modal-info">
        <h2 id="nombreModal"><?php echo $program['nombre'] ?></h2>
        <p id="descripcionModal"><?php echo $program['descripcion'] ?></p>
        <?php
        $groups = [];

        foreach ($horarios as $horario) {
            $inicio = ToMinutes($horario['hora_inicio']);
            $fin = ToMinutes($horario['hora_fin']);
            $retra = $horario['es_retransmision'];

            $groups["$inicio,$fin,$retra"][] = $horario;
        }
        
        echo "<div class='contentName'>Horarios</div>";
        foreach ($groups as $key => $group) {
            echo "<div class='contentField' contentName='horario'>";
            echo "<div class='schedule-group'>";
            $timeRange = '';
            $isRetra = '';
            $currentValuesElement = "<div class='currentValue' style='display: none;'>args</div>";
            $args= '';
            $days = [];
            echo "<div><ul class='schedule-days'>";
            foreach ($group as $horario) {
                echo "<li>" . $dias_semana[$horario['dia_semana']] . "</li>";
                $days[] = $horario['dia_semana'];
                // if(!isset($retra)) $retra = $horario['es_retransmision'];
                // echo $horario['dia_semana'] . ($horario['es_retransmision'] ? " (Retrasmision) " : "" ) . "";
                $timeRange = "De " . $horario['hora_inicio'] . " a " . $horario['hora_fin'];
                $isRetra = $horario['es_retransmision'];
                // echo $rangoHorario;
            }
            echo "<ul></div>";
            echo "<div class='schedule-time'>$timeRange</div>";
            $tagText = ($isRetra ? "Retrasmision" : "En vivo" );
            $tagStatus = ($isRetra ? "retransmission" : "live" );
            echo "<div class='schedule-tag'><span class='$tagStatus'>$tagText</span></div>";
            $jsonDays = json_encode($days, JSON_UNESCAPED_UNICODE);
            // $jsonDays = str_replace('"', "'", $jsonDays);
            // $jsonDays = addslashes($jsonDays);
            $args = "[$jsonDays,[$key],$isRetra]";
            $currentValuesElement = str_replace("args" , $args, $currentValuesElement);
            $fieldNameElement = "<div class='fieldTitle' style='display: none;'>Horarios</div>";
            echo $fieldNameElement;
            echo $currentValuesElement;
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
        ?>
        <p><strong>Presentadores:</strong><span id="presentadoresModal"><?php echo $program['presentadores'] ?></span></p>
        <p><strong>Género:</strong> <span id="generoModal"></span><?php echo $program['generos'] ?></p>
    </div>
    <div class="formulario-comentario">
        <h3>Agregar un comentario</h3>
        <input class="program-input" type="text" id="nombre" placeholder="Tu nombre" maxlength="20" required>
        <input class="program-input" type="email" id="email" placeholder="Tu correo electrónico" maxlength="20" required>
        <textarea id="mensaje" placeholder="Tu comentario" maxlength="100" required></textarea>
        <div id="error-mensaje" class="error"></div>
        <button onclick="agregarComentario()">Enviar comentario</button>
    </div>
    <div id="comentarios"></div>
<?php
    }
?>