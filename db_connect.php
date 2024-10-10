<?php
$dsn='mysql:host=localhost;port=3309;dbname=radio_db';
$usuario='root';
$contrasenia= '';
try {
    $conn = new PDO($dsn, $usuario, $contrasenia);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>