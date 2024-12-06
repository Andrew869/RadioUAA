<?php

include 'php/db_connect.php';

$query = "
    SELECT p.nombre_programa, pr.nombre_presentador, g.nombre_genero
    FROM programa p
    LEFT JOIN programa_presentador pp ON p.id_programa = pp.id_programa
    LEFT JOIN presentador pr ON pp.id_presentador = pr.id_presentador
    LEFT JOIN programa_genero pg ON p.id_programa = pg.id_programa
    LEFT JOIN genero g ON pg.id_genero = g.id_genero
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
    <title>Consulta 7: Programas, Presentadores y Géneros</title>
</head>
<body>
    <h1>Reporte: Programas, Presentadores y Géneros asociados</h1>

    <!-- Mostrar Resultados -->
    <?php if ($result): ?>
        <table>
            <thead>
                <tr>
                    <th>Programa</th>
                    <th>Presentador</th>
                    <th>Género</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nombre_programa'] ?: 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_presentador'] ?: 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_genero'] ?: 'N/A'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se encontraron programas con sus presentadores y géneros asociados.</p>
    <?php endif; ?>
</body>
</html>