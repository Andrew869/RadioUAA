<?php

include 'php/db_connect.php';

$query = "
    SELECT DISTINCT pr.nombre_presentador
    FROM presentador pr
    LEFT JOIN programa_presentador pp ON pr.id_presentador = pp.id_presentador
    WHERE pp.id_programa IS NULL
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
    <link rel="stylesheet" href="/css/sytlesConsultas.css">
    <title>Consulta 5: Presentadores sin Programas</title>
</head>
<body>
    <h1>Presentadores sin Programas Asociados</h1>

    <!-- Resultados -->
    <?php if ($result): ?>
        <table>
            <thead>
                <tr>
                    <th>Nombre del Presentador</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nombre_presentador']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay presentadores sin programas asociados.</p>
    <?php endif; ?>
</body>
</html>
