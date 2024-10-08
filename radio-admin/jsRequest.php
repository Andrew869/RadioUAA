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
        $fun = array_key_first($_POST);
        $args = explode(',', $_POST[$fun]);
        switch ($fun) {
            case 'GetEnumValues':
                $output = SQL::GetEnumValues($args[0], $args[1]);
                echo json_encode($output);
                break;
        }

    }
?>