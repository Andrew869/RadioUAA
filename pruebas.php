<?php
    include "db_connect.php";

    try {
        $db_token = SQL::Select(SQL::USER, ["id_user" => 1])->fetchAll(PDO::FETCH_ASSOC);
        foreach ($db_token as $value) {
            foreach ($value as $key => $tupla) {
                echo "$key => $tupla";
            }
        }
        // SQL::Update(SQL::USER, $user['id_user'], ["ultimo_acceso" => date("Y-m-d H:i:s"), "session_token" => $token]);
        // $sql = "UPDATE user SET ultimo_acceso ='" . date("Y-m-d H:i:s"). "', session_token = null WHERE id_user = 1";
        // $sql = "UPDATE user SET ultimo_acceso = '2024-10-30 12:02:48', session_token = '8c141f0203b100475821f8f4d9606460' WHERE id_user = 1";
        SQL::$stmt = SQL::$conn->prepare($sql);
        SQL::$conn->exec($sql);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }

?>