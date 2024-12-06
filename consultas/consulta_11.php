<?php

include 'php/db_connect.php';

// Consulta SQL para obtener programas con más de 3 géneros
$query = "
    SELECT p.nombre_programa
    FROM programa p
    JOIN programa_genero pg ON p.id_programa = pg.id_programa
    GROUP BY p.id_programa
    HAVING COUNT(pg.id_genero) > 3;
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
    <title>Consulta 11:Programas con más de 3 géneros</title>
</head>
<body>
    <h1>Programas con más de 3 géneros</h1>

    <?php if ($result): ?>
        <table>
            <thead>
                <tr>
                    <th>Nombre del Programa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nombre_programa']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay programas con más de 3 géneros.</p>
    <?php endif; ?>
</body>
</html>