<?php

include 'php/db_connect.php';

// Consulta SQL para obtener el número total de comentarios por programa
$query = "
    SELECT pr.nombre_presentador, COUNT(pp.id_programa) AS total_programas
    FROM presentador pr
    JOIN programa_presentador pp ON pr.id_presentador = pp.id_presentador
    GROUP BY pr.id_presentador, pr.nombre_presentador;
";

$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/stylesConsultas.css">
    <title>Consulta 15: Total de Programas Presentados por Presentador</title>
</head>
<body>
    <h1>Total de Programas Presentados por Presentador</h1>

    <?php if ($result): ?>
        <table>
            <thead>
                <tr>
                    <th>Nombre Presentador</th>
                    <th>Total Programas Presentados</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nombre_presentador']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_programas']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay datos disponibles para los presentadores y programas.</p>
    <?php endif; ?>
</body>
</html>
