<?php
include 'php/db_connect.php';

// Consulta SQL para obtener la cantidad de presentadores asociados a cada programa
$query = "
    SELECT p.nombre_programa, COUNT(pp.id_presentador) AS cantidad_presentadores
    FROM programa p
    LEFT JOIN programa_presentador pp ON p.id_programa = pp.id_programa
    GROUP BY p.nombre_programa
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
    <link rel="stylesheet" href="/css/sytlesConsultas.css">>
    <title>Consulta: Cantidad de presentadores por programa</title>
</head>
<body>
    <h1>Cantidad de presentadores asociados a cada programa</h1>

    <!-- Mostrar Resultados -->
    <?php if ($result): ?>
        <table>
            <thead>
                <tr>
                    <th>Programa</th>
                    <th>Cantidad de Presentadores</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nombre_programa']); ?></td>
                        <td><?php echo htmlspecialchars($row['cantidad_presentadores']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se encontraron programas con presentadores asociados.</p>
    <?php endif; ?>
</body>
</html>
