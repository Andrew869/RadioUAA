<?php
    session_start();
    date_default_timezone_set("America/Mexico_City");

    if(!isset($_SESSION['id_user'])){
        header('Location: login');
        exit();
    }

    include "../db_connect.php";

    $db_token = SQL::Select(SQL::USER, ["id_user" => $_SESSION['id_user']], ["session_token"])->fetchColumn();

    function ValidateFile($file) : bool{
        $uploadOk = 0;
        $imageFileType = strtolower(pathinfo(basename($file["name"]),PATHINFO_EXTENSION));
        //if (!file_exists($path)) { // Check if file already exists
            if ($file["size"] <= 500000) { // Check file size
                if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ) { // Allow certain file formats
                    $size = getimagesize($file["tmp_name"]); // Check if image file is a actual image or fake image
                    if($size !== false) {
                        $uploadOk = 1;
                    }
                }
            }
        // }
        return $uploadOk;
    }

    function CompareRelationship($list_1, $list_2){
        $diff_List = [];
        foreach ($list_1 as $value_1) {
            $founded = false;
            foreach ($list_2 as $value_2) {
                if($value_1 == $value_2){
                    $founded = true;
                    break;
                }
            }
            if(!$founded)
                $diff_List[] = $value_1;
        }
        return $diff_List;
    }

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
        $length = count($_POST);
        if($length === 5){ //types: schedules
            $prevTimes = explode(',', $_POST['prevTimes']);
            $contentId = $_POST['contentId'];
            SQL::Delete(SQL::HORARIO, ['id_programa' => $contentId, 'hora_inicio' => $prevTimes[0], 'hora_fin' => $prevTimes[1]]);

            foreach ($_POST['horarios'] as $horario) {
                $days = explode(',', $horario['dias']);
                $hora_inicio = $horario['hora_inicio'];
                $hora_fin = $horario['hora_fin'];
                $es_retransmision = strtoupper($horario['es_retransmision']);
                
                foreach ($days as $day) {
                    SQL::Create(SQL::HORARIO, [$contentId, $day, $hora_inicio, $hora_fin, $es_retransmision]);
                }
            }
        }
        else if($length === 4){ // types: text, password, enumList y boolean            
            if($_POST['contentName'] === SQL::PROGRAMA_PRESENTADOR || $_POST['contentName'] === SQL::PROGRAMA_GENERO){
                $relationship_name = $_POST['contentName'];
                $table_name = array_key_last($_POST);
                $id_name = SQL::GetPrimaryKeyName($_POST['fieldName']);
                $selected_input = explode(',' ,$_POST['newValue']);
                $selected_db = SQL::Select($relationship_name, ['id_programa' => $_POST['contentId']], [$id_name])->fetchAll(PDO::FETCH_COLUMN);
                $toAdd = CompareRelationship($selected_input, $selected_db);
                $toDelete = CompareRelationship($selected_db, $selected_input);
                foreach ($toDelete as $id) {
                    SQL::Delete($relationship_name, [$id_name => $id]);
                }
                foreach ($toAdd as $id) {
                    SQL::Create($relationship_name, [$_POST['contentId'], $id]);
                }
            }
            else
                SQL::Update($_POST['contentName'],$_POST['contentId'],[$_POST['fieldName'] => $_POST['newValue']]);
        }
        else if($length === 3){ // types: list y img
            if(count($_FILES)){
                $target_dir = "../resources/uploads/img/";
                $image_path = SQL::Select($_POST['contentName'], [SQL::GetPrimaryKeyName($_POST['contentName']) => $_POST['contentId']], [$_POST['fieldName']])->fetchColumn();
                $nombrePrograma = null;
                $version = null;
                
                $file = $_FILES['newValue'];
                $regex = '/\/([^\/]+)\[v(\d+)\]\.\w+$/'; // Expresión regular
                
                if (preg_match($regex, $image_path, $coincidencias)) {
                    $nombrePrograma = $coincidencias[1];
                    $version = ((int)$coincidencias[2]) + 1;
                }
                $newImageFileType = strtolower(pathinfo(basename($file["name"]),PATHINFO_EXTENSION));
                
                $target_file = $target_dir . $nombrePrograma . "[v$version]." . $newImageFileType;
                if(isset($version))
                    if(ValidateFile($file))
                        if(move_uploaded_file($file["tmp_name"], $target_file)){
                            SQL::Update($_POST['contentName'], $_POST['contentId'], [$_POST['fieldName'] => $target_file]);
                            unlink($image_path);
                        }
                
            }else{
                $relationship_name = $_POST['0'];
                $table_name = array_key_last($_POST);
                $id_name = SQL::GetPrimaryKeyName($table_name);
                $selected_input = explode(',' ,$_POST[$table_name]);
                $selected_db = SQL::Select($relationship_name, ['id_programa' => $_POST['id_programa']], [$id_name])->fetchAll(PDO::FETCH_COLUMN);
                $toAdd = CompareRelationship($selected_input, $selected_db);
                $toDelete = CompareRelationship($selected_db, $selected_input);
                foreach ($toDelete as $id) {
                    SQL::Delete($relationship_name, [$id_name => $id]);
                }
                foreach ($toAdd as $id) {
                    SQL::Create($relationship_name, [$_POST['id_programa'], $id]);
                }
            }
        }
    }
?>