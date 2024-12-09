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
    include_once $jsInitPath . 'php/utilities.php';

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
        $presentadores = explode(',',$program['presentadores']);
        $generos = explode(',',$program['generos']);
        $horarios = SQL::Select(SQL::HORARIO, ["id_programa" => $program['id']], [], "dia_semana", SQL::ASCENDANT)->fetchAll(PDO::FETCH_ASSOC);
    
?>
<div class="program-container">
    <div class="program-details">
        <div class="program-image">
            <img src="<?php echo $initPath . $jsInitPath . $program['imagen'] ?>" alt="imagen programa">
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
                $groups = [];

                foreach ($horarios as $horario) {
                    $inicio = ToMinutes($horario['hora_inicio']);
                    $fin = ToMinutes($horario['hora_fin']);
                    $retra = $horario['es_retransmision'];

                    $groups["$inicio,$fin,$retra"][] = $horario;
                }
                
                foreach ($groups as $key => $group) {
                    echo "<div class='schedule-group'>";
                    $timeRange = '';
                    $isRetra = '';
                    $currentValuesElement = "<div class='currentValue' style='display: none;'>args</div>";
                    $args= '';
                    $days = [];
                    echo "<div><ul class='schedule-days'>";
                    foreach ($group as $horario) {
                        echo "<li class='c1'>" . DAYS[$horario['dia_semana']] . "</li>";
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
                    // echo "</div>";
                    echo "</div>";
                }
                // echo "</div>";
                ?>
            </div>
        </div>
    </div>

    <div class="comments-section">
        <h2>Agregar un comentario</h2>
        <form class="comment-form">
            <input type="text" id="nombre" class="c1" placeholder="Nombre..." required>
            <input type="email" id="email" class="c1" placeholder="Email..." required>
            <textarea id="mensaje" class="c1" placeholder="Comentario..." required></textarea>
            <div id="error-mensaje" class="error"></div>
            <button type="button" onclick="agregarComentario()" class="c2">Enviar</button>
        </form>
        <div id="comentarios"></div>
    </div>
    <div id="comentarios"></div>
</div>
<?php
    }
?>