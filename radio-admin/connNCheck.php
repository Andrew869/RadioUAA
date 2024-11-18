<?php
session_start();
date_default_timezone_set("America/Mexico_City");

include "../php/db_connect.php";

if(!isset($_SESSION['id_user'])){
    header('Location: login');
    exit();
}

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
?>