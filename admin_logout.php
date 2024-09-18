<?php
// Asegúrate de que la sesión esté iniciada
session_start();
include "db_connect.php";

SQL::Update(SQL::USER, $_SESSION['id_user'], "session_token", SQL::NULL);

// Destruir todas las variables de sesión
// $_SESSION = array();
setcookie("session_token", "", time() - 3600);
session_unset();
session_destroy();

// Redirigir al usuario a la página de inicio de sesión o a otra página de tu elección
header("Location: admin_login.php");
exit();
?>
