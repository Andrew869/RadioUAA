<?php
include "db_connect.php";

try {
    $stmt = SQL::Select(SQL::PROGRAMA); // Reemplaza SQL::PROGRAMA con el nombre real de tu tabla
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $programas = $stmt->fetchAll();

    // Enviar los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($programas);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
