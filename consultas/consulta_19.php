<?php
include 'php/db_connect.php';

// Consulta SQL para obtener el programa con el comentario más reciente
$query = "
    SELECT p.nombre_programa, MAX(c.fecha_creacion) AS ultimo_comentario
    FROM programa p
    JOIN comentario c ON p.id_programa = c.id_programa
    GROUP BY p.id_programa, p.nombre_programa
    ORDER BY ultimo_comentario DESC
    LIMIT 1;
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
    <title>Consulta 19: Programa con Comentario Más Reciente</title>
</head>
<body>
    <h1>Programa con el Comentario Más Reciente</h1>

    <?php if ($result): ?>
        <p>Programa: <?php echo htmlspecialchars($result['nombre_programa']); ?></p>
        <p>Último comentario: <?php echo htmlspecialchars($result['ultimo_comentario']); ?></p>
    <?php else: ?>
        <p>No se encontró información de comentarios.</p>
    <?php endif; ?>
</body>
</html>