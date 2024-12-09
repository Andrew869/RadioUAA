<?php
    include "connNCheck.php";
    include "php/utilities.php";

    function LoadImage() : string{
        $uploadOk = 0;
        $next_id = SQL::GetCurrentIdIndex($_POST['contentName'], SQL::GetPrimaryKeyName($_POST['contentName'])) + 1;
        $target_dir = "resources/uploads/img/";
        if(count($_FILES)){
            $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
            // $target_file = $target_dir . $_POST['contentName'] . '_' . $next_id . "[v0].$imageFileType";
            $target_file = $target_dir . $_POST['contentName'] . '_' . $next_id . "[v0]";
        
            // if (!file_exists($target_file)) { // Check if file already exists
                if ($_FILES["fileToUpload"]["size"] <= 500000) { // Check file size
                    if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ) { // Allow certain file formats
                        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]); // Check if image file is a actual image or fake image
                        if($check !== false) { 
                            $uploadOk = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "../$target_file");
                        }
                    }
                }
            // }
        }

        if(!$uploadOk){
            $defaultImg_Path = "../resources/img/" . $_POST['contentName'] . "_default.jpg";
            $imageFileType = strtolower(pathinfo(basename($defaultImg_Path),PATHINFO_EXTENSION));
            $target_file = $target_dir . $_POST['contentName'] . '_' . $next_id . "[v0]";
            copy($defaultImg_Path, "../$target_file");
        }
        else {
            $lowResWidth = 300;
            $lowResPath = $target_file . '.' . $lowResWidth;
            resize_image("../".$target_file, "../".$lowResPath, $lowResWidth);
        }

        return $target_file;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $contentValues = null;
        switch ($_POST['contentName']) {
            case SQL::PROGRAMA:
                {
                    $target_file = LoadImage();

                    $contentValues = SQL::Create(SQL::PROGRAMA, [$_POST['nombre_programa'], $target_file, $_POST['descripcion']]);
                    foreach ($_POST['horarios'] as $value) {
                        foreach (explode(',', $value['dias']) as $dia) {
                            SQL::Create(SQL::HORARIO, [$contentValues['id'], $dia, $value['hora_inicio'], $value['hora_fin'], $value['es_retransmision']]);
                        }
                    }
                    foreach (explode(',', $_POST[SQL::PROGRAMA_PRESENTADOR]) as $value) {
                        SQL::Create(SQL::PROGRAMA_PRESENTADOR, [$contentValues['id'], $value]);
                    }
                    foreach (explode(',', $_POST[SQL::PROGRAMA_GENERO]) as $value) {
                        SQL::Create(SQL::PROGRAMA_GENERO, [$contentValues['id'], $value]);
                    }
                }
                break;
            case SQL::HORARIO:
                {
                    $contentValues = $_POST['id_programa'];
                    foreach ($_POST['horarios'] as $horario) {
                        foreach (explode(',', $horario['dias']) as $dia) {
                            $es_retransmision = strtoupper($horario['es_retransmision']);
                            SQL::Create(SQL::HORARIO, [$contentValues, $dia, $horario['hora_inicio'], $horario['hora_fin'], $es_retransmision]);
                        }
                    }
                }
                break;
            case SQL::PRESENTADOR:
                {
                    $target_file = LoadImage();
                    $contentValues =  SQL::Create(SQL::PRESENTADOR, [$_POST['nombre_presentador'], $_POST['biografia'], $target_file]);
                }
                break;
            case SQL::GENERO:
                $contentValues = SQL::Create(SQL::GENERO, [$_POST['nombre_genero']]);
                break;
            case SQL::USER:
                {
                    $pass_hash = hash('sha256', $_POST['password']);
                    $contentValues =  SQL::Create(SQL::USER, [$_POST['username'], $_POST['email'], $_POST['password'], $_POST['nombre_completo'], $_POST['rol'], $_POST['cuenta_activa']]);
                }
                break;
        }
        echo json_encode($contentValues);
    }
?>