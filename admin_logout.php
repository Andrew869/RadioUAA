<?php
// Asegúrate de que la sesión esté iniciada
session_start();
include "db_connect.php";

$sql = 'UPDATE users SET session_token = NULL WHERE id_user = :id_user';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_user', $_SESSION['id_user']);
$stmt->execute();

// Destruir todas las variables de sesión
// $_SESSION = array();
setcookie("session_token", "", time() - 3600);
session_unset();
session_destroy();

// Redirigir al usuario a la página de inicio de sesión o a otra página de tu elección
header("Location: admin_login.php");
exit();
?>
