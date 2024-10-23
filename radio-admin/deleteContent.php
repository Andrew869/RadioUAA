<?php
    session_start();
    date_default_timezone_set("America/Mexico_City");

    if(!isset($_SESSION['id_user'])){
        header('Location: login');
        exit();
    }

    include "../db_connect.php";

    $db_token = SQL::Select(SQL::USER, ["id_user" => $_SESSION['id_user']], ["session_token"])->fetchColumn();

    if($_SESSION['session_token'] !== $db_token){
        setcookie("session_token", "", time() - 3600);
        session_unset();
        session_destroy();
        
        header("Location: login");
        exit();
    }else if(!isset($_COOKIE['session_token'])){
        header("Location: logout");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $wheres = [SQL::GetPrimaryKeyName($_POST['contentName']) => $_POST['pk']];

        switch ($_POST['contentName']) {
            case SQL::PROGRAMA:
                {
                    SQL::Delete(SQL::HORARIO, $wheres);
                    SQL::Delete(SQL::PROGRAMA_PRESENTADOR, $wheres);
                    SQL::Delete(SQL::PROGRAMA_GENERO, $wheres);
                    // Borrar imagen
                    // $image_path = self::Select(self::PROGRAMA, self::GetPrimaryKeyName(self::PROGRAMA), $primary_key, ["url_imagen"])->fetchColumn();
                    $image_path = SQL::Select(SQL::PROGRAMA, $wheres, ['url_img'])->fetchColumn();
                    unlink($image_path);
                }
                break;
            case SQL::PRESENTADOR:
                {
                    SQL::Delete(SQL::PROGRAMA_PRESENTADOR, $wheres);
                    $image_path = SQL::Select(SQL::PRESENTADOR, $wheres, ['url_img'])->fetchColumn();
                    unlink($image_path);
                }
                break;
            case SQL::GENERO:
                {
                    SQL::Delete(SQL::PROGRAMA_GENERO, $wheres);
                }
                break;
        }

        // if($_POST['contentName'] === SQL::PROGRAMA){
            
        // }
        // else if($_POST['contentName'] === SQL::PRESENTADOR){
        //     $image_path = SQL::Select(SQL::PRESENTADOR, $wheres, ['url_img'])->fetchColumn();
        //     unlink($image_path);
        // }

        SQL::DELETE($_POST['contentName'], $wheres);
    }
?>