<?php
include 'php/db_connect.php';

// Consulta SQL para obtener el promedio de presentadores por programa
$query = "
    SELECT AVG(total_presentadores) AS promedio_presentadores
    FROM (
        SELECT p.id_programa, COUNT(pp.id_presentador) AS total_presentadores
        FROM programa p
        LEFT JOIN programa_presentador pp ON p.id_programa = pp.id_programa
        GROUP BY p.id_programa
    ) tabla_presentadores;
";

$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);  // Obtener un solo resultado
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/stylesConsultas.css">
    <title>Consulta 20: Promedio de Presentadores por Programa</title>
</head>
<body>
    <h1>Promedio de Presentadores por Programa</h1>

    <?php if ($result): ?>
        <p>El promedio de presentadores por programa es: <?php echo number_format($result['promedio_presentadores'], 2); ?></p>
    <?php else: ?>
        <p>No se pudo calcular el promedio.</p>
    <?php endif; ?>
</body>
</html>
