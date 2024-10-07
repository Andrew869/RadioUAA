<?php
    session_start();
    date_default_timezone_set("America/Mexico_City");

    if(!isset($_SESSION['id_user'])){
        header('Location: login');
        exit();
    }

    include "../db_connect.php";

    $db_token = SQL::Select(SQL::USER, ["id_user" => $_SESSION['id_user']], ["session_token"])->fetchColumn();

    function ValidateFile($file, $path) : bool{
        $flag = 0;
        $imageFileType = strtolower(pathinfo(basename($file["name"]),PATHINFO_EXTENSION));
        //if (!file_exists($path)) { // Check if file already exists
            if ($file["size"] <= 500000) { // Check file size
                if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ) { // Allow certain file formats
                    $size = getimagesize($file["tmp_name"]); // Check if image file is a actual image or fake image
                    if($size !== false) {
                        $flag = 1;
                    }
                }
            }
        // }
        return $flag;
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
            $id = $_POST['id'];
            $newDays = explode(',', $_POST['days']);
            $inicios = explode(',', $_POST['inicio']);
            $fins = explode(',', $_POST['fin']);
            $retra = strtoupper($_POST['retra']);
            
            
            SQL::Delete(SQL::HORARIO, ['id_programa' => $_POST['id'], 'hora_inicio' => $inicios[0], 'hora_fin' => $fins[0]]);
            foreach ($newDays as $day) {
                SQL::Create(SQL::HORARIO, [$id, $day, $inicios[1], $fins[1], $retra]);
            }
        }
        else if($length === 4) // types: text, password, enumList y boolean
            SQL::Update($_POST[0],$_POST[1],[$_POST[2] => $_POST[3]]);
        else if($length === 3){ // types: list y img
            if(count($_FILES)){

                $image_path = SQL::Select($_POST['table_name'], [SQL::GetPrimaryKeyName($_POST['table_name']) => $_POST['primary_key']], [$_POST['field']])->fetchColumn();
                // unlink($image_path);

                $file = $_FILES['fileToUpload'];

                if(ValidateFile($file, $image_path))
                    move_uploaded_file($file["tmp_name"], $image_path);
                
            }else{
                $relationship_name = $_POST['0'];
                $table_name = array_key_last($_POST);
                $id_name = SQL::GetPrimaryKeyName($table_name);
                $selected_input = explode(',' ,$_POST[$table_name]);
                $selected_db = SQL::Select($relationship_name, ['id_programa' => $_POST['id_programa']], [$id_name])->fetchAll(PDO::FETCH_COLUMN);
                $toAdd = CompareRelationship($selected_input, $selected_db);
                // foreach ($selected_input as $value) {
                //     $input = (int)$value;
                //     $founded = false;
                //     foreach ($selected_db as $db) {
                //         if($input === $db){
                //             $founded = true;
                //             break;
                //         }
                //     }
                //     if(!$founded)
                //         $toAdd[] = $input;
                // }
                $toDelete = CompareRelationship($selected_db, $selected_input);
                // foreach ($selected_db as $db) {
                //     $founded = false;
                //     foreach ($selected_input as $value) {
                //         $input = (int)$value;
                //         if($db === $input){
                //             $founded = true;
                //             break;
                //         }
                //     }
                //     if(!$founded)
                //         $toDelete[] = $db;
                // }
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