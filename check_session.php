<?php
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    include_once "db_connect.php";

    $sql = 'SELECT session_token FROM users WHERE id_user = ?';
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_SESSION['id_user']]);

    $db_token = $stmt->fetchColumn();

    $tmp = array();

    $tmp['sesion_valida'] = ($_SESSION['session_token'] === $db_token && isset($_COOKIE['session_token']));
    $tmp['token_expired'] = (!isset($_COOKIE['session_token']));

    echo json_encode($tmp);
    
?>