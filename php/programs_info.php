<?php
    include_once 'db_connect.php';
    include_once 'utilities.php'; 

    // $programs[] = GetCurrProgram();

    $programs = array_merge(GetNextPrograms(4));
    // echo "<pre>";
    // // print_r($programs);
    // echo json_encode($programs, JSON_UNESCAPED_UNICODE);
    // echo "</pre>";

    foreach (GetNextPrograms(4) as $program) {
        echo "<div class='next-program'>";
            echo "<img src='". $program['url_img'] .".300' alt='logo_programa'>";
            echo "<div class='info'>";
                echo "<div class='name'><span>". $program['nombre_programa'] ."</span></div>";
                echo "<div class='schedule'><span>". date("H:i", strtotime($program['hora_inicio'])) .' - '. date("H:i", strtotime($program['hora_fin'])) ."</span></div>";    
            echo "</div>";
        echo "</div>";
    }
?>