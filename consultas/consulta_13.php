<?php

include 'php/db_connect.php';

$query = "
    SELECT p.nombre_programa, h.dia_semana, h.hora_inicio, h.hora_fin
    FROM programa p
    JOIN horario h ON p.id_programa = h.id_programa
    WHERE h.es_retransmision = 1;
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
    <title>Consulta 13:Horarios de Retransmisión</title>
</head>
<body>
    <h1>Horarios de Retransmisión de Programas</h1>

    <?php if ($result): ?>
        <table>
            <thead>
                <tr>
                    <th>Programa</th>
                    <th>Día de la Semana</th>
                    <th>Hora de Inicio</th>
                    <th>Hora de Fin</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nombre_programa']); ?></td>
                        <td><?php echo htmlspecialchars($row['dia_semana']); ?></td>
                        <td><?php echo htmlspecialchars($row['hora_inicio']); ?></td>
                        <td><?php echo htmlspecialchars($row['hora_fin']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay programas con horarios de retransmisión.</p>
    <?php endif; ?>
</body>
</html>