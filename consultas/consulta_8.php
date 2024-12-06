<?php

include 'php/db_connect.php';
$query = "
    SELECT DISTINCT p.nombre_programa
    FROM programa p
    LEFT JOIN comentario c ON p.id_programa = c.id_programa
    WHERE c.id_comentario IS NULL OR c.aprobado = FALSE
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
    <title>Consulta: Programas sin comentarios o no aprobados</title>
</head>
<body>
    <h1>Consulta 8: Programas sin comentarios o no aprobados</h1>

    <!-- Mostrar Resultados -->
    <?php if ($result): ?>
        <table>
            <thead>
                <tr>
                    <th>Programa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nombre_programa'] ?: 'N/A'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se encontraron programas sin comentarios o con comentarios no aprobados.</p>
    <?php endif; ?>
</body>
</html>