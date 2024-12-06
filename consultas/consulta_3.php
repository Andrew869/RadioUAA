<?php
include 'php/db_connect.php';

// Consulta SQL para obtener programas con al menos un presentador
$query = "
    SELECT DISTINCT p.nombre_programa
    FROM programa p
    JOIN programa_presentador pp ON p.id_programa = pp.id_programa
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
    <title>Consulta 3: Programas con Presentadores</title>
</head>
<body>
    <h1>Programas Asociados a Presentadores</h1>
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
                        <td><?php echo htmlspecialchars($row['nombre_programa']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se encontraron programas con presentadores asociados.</p>
    <?php endif; ?>
</body>
</html>