<?php
    include "db_connect.php";

    // echo date("H:i:s\n");
    // echo date("N");
    echo "23:30:00";

    try {
        // $sql = "
        // SELECT p.id_programa, p.nombre_programa, p.url_img, h.dia_semana, h.hora_inicio, h.hora_fin, h.es_retransmision
        // FROM programa p
        // INNER JOIN horario h ON p.id_programa = h.id_programa
        // WHERE (WEEKDAY(NOW()) + 1) = h.dia_semana  -- Filtrar por día actual (considerando que 0 es lunes)
        // AND TIME(NOW()) BETWEEN h.hora_inicio AND h.hora_fin  -- Filtrar por hora actual
        // ORDER BY h.dia_semana, h.hora_inicio;
        // ";

        $sql = "
            SELECT p.id_programa, p.nombre_programa, p.url_img, h.dia_semana, h.hora_inicio, h.hora_fin, h.es_retransmision
            FROM programa p
            INNER JOIN horario h ON p.id_programa = h.id_programa
            WHERE (WEEKDAY(NOW()) + 1) = h.dia_semana AND TIME(NOW()) < h.hora_inicio
            ORDER BY h.dia_semana, h.hora_inicio
            LIMIT 5;
        ";

        $stmt = SQL::$conn->prepare($sql);
        // Ejecutar la consulta
        $stmt->execute();
        // Obtener todos los resultados en forma de arreglo asociativo
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $programs = array_merge($row);

        $currDay = date("N");
        $nextDay = $currDay;
        $nextHour = "00:00:00";
        // $tmp = 1;
        while(count($programs) < 5){
            if($nextDay < 7)
                $nextDay++;
            else
                $nextDay = 1;

            $sql = "SELECT p.id_programa, p.nombre_programa, p.url_img, h.dia_semana, h.hora_inicio, h.hora_fin, h.es_retransmision
                FROM programa p
                INNER JOIN horario h ON p.id_programa = h.id_programa
                WHERE $nextDay = h.dia_semana AND h.hora_inicio >= '$nextHour'
                ORDER BY h.dia_semana, h.hora_inicio
                LIMIT 5; ";

            // $tmp++;

            $stmt = SQL::$conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $left = abs(count($row) - count($programs));

            for ($i=0; $i < $left; $i++) { 
                array_push($programs, $row[$i]);
            }

            // $programs = array_merge($row);

        }

        // if($length < 5){

        // }
        
        // $sql = "
        //     DROP TABLE programa_presentador;
        //     DROP TABLE programa_genero;
        //     DROP TABLE genero;
        //     DROP TABLE presentador;
        //     DROP TABLE horario;
        //     DROP TABLE comentario;
        //     DROP TABLE programa;
        //     DROP TABLE user;
        // ";
        // $stmt = SQL::$conn->prepare($sql);
        
        // $stmt->execute();
        // $tmp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // echo $tmp[0]['Value'];


        // $db_token = SQL::Select(SQL::HORARIO, ["id_horario" => 16], ["dia_semana"])->fetchColumn();
        // echo $db_token;

        // foreach ($db_token as $value) {
        //     foreach ($value as $key => $tupla) {
        //         echo "$key => $tupla";
        //     }
        // }
        // SQL::Update(SQL::USER, $user['id_user'], ["ultimo_acceso" => date("Y-m-d H:i:s"), "session_token" => $token]);
        // $sql = "UPDATE user SET ultimo_acceso ='" . date("Y-m-d H:i:s"). "', session_token = null WHERE id_user = 1";
        // $sql = "UPDATE user SET ultimo_acceso = '2024-10-30 12:02:48', session_token = '8c141f0203b100475821f8f4d9606460' WHERE id_user = 1";
        // SQL::$stmt = SQL::$conn->prepare($sql);
        // SQL::$conn->exec($sql);

        echo "<pre>";
        print_r($programs);
        echo "</pre>";
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }

?>