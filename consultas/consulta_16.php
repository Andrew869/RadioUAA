<?php

include 'php/db_connect.php';

// Consulta SQL para obtener el programa más comentado
$query = "
    SELECT p.nombre_programa, COUNT(c.id_comentario) AS total_comentarios
    FROM programa p
    LEFT JOIN comentario c ON p.id_programa = c.id_programa
    GROUP BY p.id_programa, p.nombre_programa
    ORDER BY total_comentarios DESC
    LIMIT 1;
";

$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);  // Solo un resultado ya que LIMIT 1
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/stylesConsultas.css">
    <title>Consulta 16: Programa Más Comentado</title>
</head>
<body>
    <h1>Programa Más Comentado</h1>

    <?php if ($result): ?>
        <table>
            <thead>
                <tr>
                    <th>Nombre del Programa</th>
                    <th>Total de Comentarios</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo htmlspecialchars($result['nombre_programa']); ?></td>
                    <td><?php echo htmlspecialchars($result['total_comentarios']); ?></td>
                </tr>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay programas con comentarios registrados.</p>
    <?php endif; ?>
</body>
</html>
