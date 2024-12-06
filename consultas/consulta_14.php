<?php

include 'php/db_connect.php';

// Consulta SQL para obtener el número total de comentarios por programa
$query = "
    SELECT id_programa, COUNT(*) AS total_comentarios
    FROM comentario
    GROUP BY id_programa;
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
    <title>Consulta 14:Total de Comentarios por Programa</title>
</head>
<body>
    <h1>Total de Comentarios por Programa</h1>

    <?php if ($result): ?>
        <table>
            <thead>
                <tr>
                    <th>ID Programa</th>
                    <th>Total Comentarios</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id_programa']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_comentarios']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay comentarios registrados para ningún programa.</p>
    <?php endif; ?>
</body>
</html>