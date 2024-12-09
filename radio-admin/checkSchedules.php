<?php
    include "connNCheck.php";
    include_once "../php/utilities.php";
// $dia_semana = $_POST['dia_semana'];
// $hora_inicio = $_POST['hora_inicio'];
// $hora_fin = $_POST['hora_fin'];

function Intersect($hi_1,$hf_1,$hi_2,$hf_2) : bool{
    $hi_1 = ToMinutes($hi_1);
    $hf_1 = ToMinutes($hf_1);
    $hi_2 = ToMinutes($hi_2);
    $hf_2 = ToMinutes($hf_2);

    return $hi_1 < $hf_2 && $hf_1 > $hi_2;
}

if(count($_POST)){
    // $hi_1 = $_POST['hi_1'];
    // $hf_1 = $_POST['hf_1'];
    // $hi_2 = $_POST['hi_2'];
    // $hf_2 = $_POST['hf_2'];
    $horarios = null;
    $collisions = [];
    $flag = 0;
    foreach (explode(',', $_POST['dias']) as $dia) {
        $sql = "SELECT p.id_programa, p.nombre_programa, p.url_img, h.dia_semana, h.hora_inicio, h.hora_fin, h.es_retransmision
            FROM programa p
            INNER JOIN horario h ON p.id_programa = h.id_programa
            WHERE $dia = h.dia_semana
            ORDER BY h.dia_semana, h.hora_inicio;
        ";

        $stmt = SQL::$conn->prepare($sql);
        $stmt->execute();
        $horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // $horarios = SQL::Select(SQL::HORARIO, ["dia_semana" => $dia])->fetchAll(PDO::FETCH_ASSOC);
        foreach ($horarios as $value) {
            if(Intersect($_POST['hora_inicio'], $_POST['hora_fin'], $value['hora_inicio'], $value['hora_fin'])){
                $collisions[] = $value;
                $flag = true;
            }

            // $flag |= Intersect($_POST['hora_inicio'], $_POST['hora_fin'], $value['hora_inicio'], $value['hora_fin']);
        }
    }
    if($flag){
        echo "<div><b>Solapaciones</b></div>";
        foreach ($collisions as $key => $value) {
            // echo "<div>" . $value['dia_semana'] . " de " . $value['hora_inicio'] . " a " . $value['hora_fin'] . "</div>";
            echo "<div>" . $value['nombre_programa'] . " - " . DAYS[$value['dia_semana']] . " de " . $value['hora_inicio'] . " a " . $value['hora_fin'] . "</div>";
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
        // if(count($_POST)){
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