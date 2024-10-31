<?php
    include "db_connect.php";

    try {
        
        $sql = "
            DROP TABLE programa_presentador;
            DROP TABLE programa_genero;
            DROP TABLE genero;
            DROP TABLE presentador;
            DROP TABLE horario;
            DROP TABLE programa;
            DROP TABLE user;
        ";
        $stmt = SQL::$conn->prepare($sql);
        
        $stmt->execute();
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
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }

?>