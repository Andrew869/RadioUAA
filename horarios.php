<?php 
include "db_connect.php";

// $dia_semana = $_GET['dia_semana'];
// $hora_inicio = $_GET['hora_inicio'];
// $hora_fin = $_GET['hora_fin'];

function ToMinutes($time) {
    // Convierte el formato HH:MM en minutos totales desde la medianoche
    list($hours, $minutes) = explode(':', $time);
    return ($hours * 60) + $minutes;
}

function Intersect($hi_1,$hf_1,$hi_2,$hf_2) : bool{
    $hi_1 = ToMinutes($hi_1);
    $hf_1 = ToMinutes($hf_1);
    $hi_2 = ToMinutes($hi_2);
    $hf_2 = ToMinutes($hf_2);

    return $hi_1 < $hf_2 && $hf_1 > $hi_2;
}

if(count($_GET)){
    // $hi_1 = $_GET['hi_1'];
    // $hf_1 = $_GET['hf_1'];
    // $hi_2 = $_GET['hi_2'];
    // $hf_2 = $_GET['hf_2'];
    $horarios = null;
    $collisions = [];
    $flag = 0;
    foreach (explode(',', $_GET['dias']) as $dia) {
        $horarios = SQL::Select(SQL::HORARIO, ["dia_semana" => $dia])->fetchAll(PDO::FETCH_ASSOC);
        foreach ($horarios as $value) {
            if(Intersect($_GET['hora_inicio'], $_GET['hora_fin'], $value['hora_inicio'], $value['hora_fin'])){
                $collisions[] = $value;
                $flag = true;
            }

            // $flag |= Intersect($_GET['hora_inicio'], $_GET['hora_fin'], $value['hora_inicio'], $value['hora_fin']);
        }
    }
    if($flag){
        echo "<div>Solapaciones</div>";
        foreach ($collisions as $key => $value) {
            echo "<div>" . $value['dia_semana'] . " de " . $value['hora_inicio'] . " a " . $value['hora_fin'] . "</div>";
        }
    }else
        echo "No hay solapaciones!";
}

// SQL::Select(SQL::HORARIO, ['dia_semana' => $dia_semana, 'hora_inicio' => $hora_inicio, 'hora_fin' => $hora_fin]);

?>
<!-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php //htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
        <input type="time" name="hi_1" id="" value="<?php //echo $hi_1 ?>">
        <input type="time" name="hf_1" id="" value="<?php //echo $hf_1 ?>">
        <input type="time" name="hi_2" id="" value="<?php //echo $hi_2 ?>">
        <input type="time" name="hf_2" id="" value="<?php //echo $hf_2 ?>">
        <input type="submit" value="">
    </form>
    <pre>
    <?php
        // if(count($_GET)){
        //     echo "\n$hi_1\n";
        //     echo "$hf_1\n\n";
        //     echo "$hi_2\n";
        //     echo "$hf_2\n\n";
        //     if(Intersect($hi_1,$hf_1,$hi_2,$hf_2))
        //         echo "interseca";
        //     else
        //         echo "no interseca";
        // }
    ?>
    </pre>
</body>
</html>
    -->