<?php
// Asegúrate de que la sesión esté iniciada
session_start();
include "db_connect.php";

$sql = 'UPDATE users SET sesion_activa = FALSE WHERE id_user = :id_user LIMIT 1';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_user', $_SESSION['id_user']);
$stmt->execute();

// Destruir todas las variables de sesión
// $_SESSION = array();
session_unset();

// Si se desea destruir la cookie de sesión
// if (ini_get("session.use_cookies")) {
//     $params = session_get_cookie_params();
//     setcookie(session_name(), '', time() - 42000,
//         $params["path"], $params["domain"],
//         $params["secure"], $params["httponly"]
//     );
// }

// Finalmente, destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio de sesión o a otra página de tu elección
header("Location: admin_login.php");
exit();
?>
