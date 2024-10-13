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

    function LoadImage() : string{
        $uploadOk = 0;
        $next_id = SQL::GetCurrentIdIndex(SQL::PROGRAMA, SQL::GetPrimaryKeyName(SQL::PROGRAMA)) + 1;
        $target_dir = "../resources/uploads/img/";
        if(count($_FILES)){
            $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
            $target_file = $target_dir . $_POST['contentName'] . "_$next_id.$imageFileType";
        
            // if (!file_exists($target_file)) { // Check if file already exists
                if ($_FILES["fileToUpload"]["size"] <= 500000) { // Check file size
                    if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ) { // Allow certain file formats
                        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]); // Check if image file is a actual image or fake image
                        if($check !== false) { 
                            $uploadOk = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                        }
                    }
                }
            // }
        }

        if(!$uploadOk){
            $defaultImg_Path = "../resources/img/" . $_POST['contentName'] . "_default.jpg";
            $imageFileType = strtolower(pathinfo(basename($defaultImg_Path),PATHINFO_EXTENSION));
            $target_file = $target_dir . $_POST['contentName'] . "_$next_id.$imageFileType";
            copy($defaultImg_Path, $target_file);
        }

        return $target_file;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        switch ($_POST['contentName']) {
            case SQL::PROGRAMA:
                {
                    $target_file = LoadImage();

                    $id_programa = SQL::Create(SQL::PROGRAMA, [$_POST['nombre_programa'], $target_file, $_POST['descripcion']]);
                    foreach ($_POST['horarios'] as $value) {
                        foreach (explode(',', $value['dias']) as $dia) {
                            SQL::Create(SQL::HORARIO, [$id_programa, $dia, $value['hora_inicio'], $value['hora_fin'], $value['es_retransmision']]);
                        }
                    }
                    foreach (explode(',', $_POST['presentador']) as $value) {
                        SQL::Create(SQL::PROGRAMA_PRESENTADOR, [$id_programa, $value]);
                    }
                    foreach (explode(',', $_POST['genero']) as $value) {
                        SQL::Create(SQL::PROGRAMA_GENERO, [$id_programa, $value]);
                    }
                }
                break;
            case SQL::HORARIO:
                {
                    $id_programa = $_POST['id_programa'];
                    foreach ($_POST['horarios'] as $value) {
                        foreach (explode(',', $value['dias']) as $dia) {
                            SQL::Create(SQL::HORARIO, [$id_programa, $dia, $value['hora_inicio'], $value['hora_fin'], $value['es_retransmision']]);
                        }
                    }
                }
                break;
            case SQL::PRESENTADOR:
                {
                    $target_file = LoadImage();
                    SQL::Create(SQL::PRESENTADOR, [$_POST['nombre_presentador'], $_POST['biografia'], $target_file]);
                }
                break;
            case SQL::GENERO:
                SQL::Create(SQL::GENERO, [$_POST['nombre_genero']]);
                break;
            case SQL::USER:
                {
                    $pass_hash = hash('sha256', $_POST['password']);
                    SQL::Create(SQL::USER, [$_POST['username'], $_POST['email'], $_POST['password'], $_POST['nombre_completo'], $_POST['rol'], $_POST['cuenta_activa']]);
                }
                break;
        }
    }
?>