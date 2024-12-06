<?php
include 'php/db_connect.php';

$query = "
    SELECT p.nombre_programa, g.nombre_genero
    FROM programa p
    JOIN programa_genero pg ON p.id_programa = pg.id_programa
    JOIN genero g ON pg.id_genero = g.id_genero
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
    <title>Consulta 2</title>
</head>
<body>
    <h1>Programas y sus Géneros Asociados</h1>
    <?php if ($result): ?>
        <table>
            <thead>
                <tr>
                    <th>Programa</th>
                    <th>Género</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nombre_programa']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_genero']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se encontraron programas con géneros asociados.</p>
    <?php endif; ?>
</body>
</html>