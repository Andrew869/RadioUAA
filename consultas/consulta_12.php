<?php

include 'php/db_connect.php';

// Consulta SQL para obtener el número total de programas por género
$query = "
    SELECT g.nombre_genero, COUNT(pg.id_programa) AS total_programas
    FROM genero g
    LEFT JOIN programa_genero pg ON g.id_genero = pg.id_genero
    GROUP BY g.id_genero, g.nombre_genero;
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
    <title>Consulta 12: Total de Programas por Género</title>
</head>
<body>
    <h1>Total de Programas por Género</h1>

    <?php if ($result): ?>
        <table>
            <thead>
                <tr>
                    <th>Género</th>
                    <th>Total de Programas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nombre_genero']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_programas']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay géneros con programas asociados.</p>
    <?php endif; ?>
</body>
</html>