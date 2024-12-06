<?php

include 'php/db_connect.php';
$query = "
    SELECT c.id_programa, COUNT(c.id_comentario) AS num_comentarios_aprobados
    FROM comentario c
    WHERE c.aprobado = TRUE
    GROUP BY c.id_programa
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
    <title>Consulta 6: Comentarios Aprobados por Programa</title>
</head>
<body>
    <h1>Reporte: Comentarios Aprobados por Programa</h1>

    <!-- Mostrar Resultados -->
    <?php if ($result): ?>
        <table>
            <thead>
                <tr>
                    <th>ID del Programa</th>
                    <th>Número de Comentarios Aprobados</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id_programa']); ?></td>
                        <td><?php echo htmlspecialchars($row['num_comentarios_aprobados']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay comentarios aprobados para los programas.</p>
    <?php endif; ?>
</body>
</html>