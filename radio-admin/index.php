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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radio Admin</title>
</head>
<body>
    <header>
    <?php
        include "nav_header.php";
    ?>
    </header>
    <aside></aside>
    <main>
        <div>
            programan en vivo
        </div>
        <div>
            ultimos programas añadidos
        </div>
        <div>
            ultimos presentadores añadidos
        </div>
        <div>
            utimos generos añadidos
        </div>
        <div>
            ultimos comentarios publicados
        </div>
    </main>
    <footer>
        TODO: footer
    </footer>
</body>
</html>