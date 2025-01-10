<?php
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    include_once "db_connect.php";
    
    $db_token = SQL::Select(SQL::USER, ["id_user" => $_SESSION['id_user']], ["session_token"])->fetchColumn();

    $tmp = array();

    $tmp['sesion_valida'] = ($_SESSION['session_token'] === $db_token && isset($_COOKIE['session_token']));
    $tmp['token_expired'] = (!isset($_COOKIE['session_token']));

    echo json_encode($tmp);
?>