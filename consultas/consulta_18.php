<?php

include 'php/db_connect.php';

// Consulta SQL para obtener el número total de presentadores únicos en todos los programas
$query = "
    SELECT COUNT(DISTINCT pr.id_presentador) AS total_presentadores
    FROM programa_presentador pp
    JOIN presentador pr ON pp.id_presentador = pr.id_presentador;
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
    <title>Consulta 18: Total Presentadores Únicos</title>
</head>
<body>
    <h1>Total de Presentadores Únicos en Todos los Programas</h1>

    <?php if ($result): ?>
        <p>Total de presentadores únicos: <?php echo htmlspecialchars($result['total_presentadores']); ?></p>
    <?php else: ?>
        <p>No se pudo obtener la información.</p>
    <?php endif; ?>
</body>
</html>