<?php

include 'php/db_connect.php';

// Consulta SQL para obtener los programas sin horarios asignados
$query = "
    SELECT p.nombre_programa
    FROM programa p
    LEFT JOIN horario h ON p.id_programa = h.id_programa
    WHERE h.id_horario IS NULL;
";

$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Obtener todos los resultados
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/stylesConsultas.css">
    <title>Consulta 17: Programas sin Horarios</title>
</head>
<body>
    <h1>Programas sin Horarios Asignados</h1>

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
        <p>No hay programas sin horarios asignados.</p>
    <?php endif; ?>
</body>
</html>
