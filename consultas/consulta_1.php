<?php
include 'php/db_connect.php';

$query = "
    SELECT p.id_programa, p.nombre_programa, p.url_img, h.dia_semana,
           h.hora_inicio, h.hora_fin, h.es_retransmision
    FROM programa p
    INNER JOIN horario h ON p.id_programa = h.id_programa
    WHERE (WEEKDAY(NOW()) + 1) = h.dia_semana AND TIME(NOW()) >= h.hora_inicio
    ORDER BY h.dia_semana, h.hora_inicio DESC
    LIMIT 1;
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
    <title>Consulta 1</title>
</head>
<body>
    <h1>Programa en el horario actual</h1>
    <?php if ($result): ?>
        <table>
            <thead>
                <tr>
                    <td><img src="<?php echo $row['url_img']; ?>" alt="Imagen del programa" style="width:100px;"></td>
                    <td><?php echo $row['nombre_programa']; ?></td>
                    <td><?php echo $row['hora_inicio'] . ' - ' . $row['hora_fin']; ?></td>
                    <td><?php echo $row['es_retransmision'] ? 'Sí' : 'No'; ?></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo $row['nombre_programa']; ?></td>
                        <td><?php echo $row['hora_inicio'] . ' - ' . $row['hora_fin']; ?></td>
                        <td><?php echo $row['es_retransmision'] ? 'Sí' : 'No'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay programas en el horario actual.</p>
    <?php endif; ?>
</body>
</html>