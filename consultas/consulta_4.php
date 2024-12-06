<?php
include 'php/db_connect.php';

// Variables por defecto para los filtros
$dia_semana = '';
$hora_inicio = '';
$hora_fin = '';
$result = [];

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener valores del formulario
    $dia_semana = $_POST['dia_semana'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];

    // Consulta SQL con parámetros dinámicos
    $query = "
        SELECT DISTINCT p.nombre_programa
        FROM programa p
        JOIN horario h ON p.id_programa = h.id_programa
        WHERE h.dia_semana = :dia_semana
          AND h.hora_inicio >= :hora_inicio
          AND h.hora_fin <= :hora_fin
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':dia_semana', $dia_semana, PDO::PARAM_INT);
    $stmt->bindParam(':hora_inicio', $hora_inicio, PDO::PARAM_STR);
    $stmt->bindParam(':hora_fin', $hora_fin, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/sytlesConsultas.css">
    <title>Consulta 4: Programas por Día y Horario</title>
</head>
<body>
    <h1>Consulta de Programas por Día y Horario</h1>

    <!-- Formulario para filtrar -->
    <form method="POST">
        <label for="dia_semana">Día de la Semana (1 = Lunes, 7 = Domingo):</label>
        <input type="number" id="dia_semana" name="dia_semana" min="1" max="7" value="<?php echo htmlspecialchars($dia_semana); ?>" required>

        <label for="hora_inicio">Hora de Inicio (HH:MM):</label>
        <input type="time" id="hora_inicio" name="hora_inicio" value="<?php echo htmlspecialchars($hora_inicio); ?>" required>

        <label for="hora_fin">Hora de Fin (HH:MM):</label>
        <input type="time" id="hora_fin" name="hora_fin" value="<?php echo htmlspecialchars($hora_fin); ?>" required>

        <button type="submit">Consultar</button>
    </form>

    <!-- Resultados -->
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
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
            <p>No se encontraron programas para los criterios especificados.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
