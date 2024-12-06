<?php
include 'php/db_connect.php';

// Inicializar la variable para el día seleccionado
$diaSeleccionado = '';  // Variable vacía por defecto

// Verificar si el usuario ha seleccionado un día
if (isset($_POST['dia_semana']) && !empty($_POST['dia_semana'])) {
    $diaSeleccionado = $_POST['dia_semana'];
}

// Consulta SQL para obtener los programas que se emiten en un día específico y son retransmisión
// Solo ejecutamos la consulta si un día ha sido seleccionado
if (!empty($diaSeleccionado)) {
    $query = "
        SELECT DISTINCT p.nombre_programa
        FROM programa p
        JOIN horario h ON p.id_programa = h.id_programa
        WHERE h.dia_semana = :dia_semana AND h.es_retransmision = TRUE
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':dia_semana', $diaSeleccionado, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/sytlesConsultas.css">>
    <title>Consulta 10: Programas de Retransmisión</title>
</head>
<body>
    <h1>Programas de Retransmisión</h1>

    <!-- Formulario para seleccionar el día de la semana -->
    <form method="POST" action="">
        <label for="dia_semana">Selecciona un día de la semana:</label>
        <select name="dia_semana" id="dia_semana">
            <option value="" <?php echo ($diaSeleccionado == '') ? 'selected' : ''; ?>>Seleccione un día</option>
            <option value="1" <?php echo ($diaSeleccionado == '1') ? 'selected' : ''; ?>>Lunes</option>
            <option value="2" <?php echo ($diaSeleccionado == '2') ? 'selected' : ''; ?>>Martes</option>
            <option value="3" <?php echo ($diaSeleccionado == '3') ? 'selected' : ''; ?>>Miércoles</option>
            <option value="4" <?php echo ($diaSeleccionado == '4') ? 'selected' : ''; ?>>Jueves</option>
            <option value="5" <?php echo ($diaSeleccionado == '5') ? 'selected' : ''; ?>>Viernes</option>
            <option value="6" <?php echo ($diaSeleccionado == '6') ? 'selected' : ''; ?>>Sábado</option>
            <option value="7" <?php echo ($diaSeleccionado == '7') ? 'selected' : ''; ?>>Domingo</option>
        </select>
        <button type="submit">Ver Programas</button>
    </form>

    <!-- Mostrar Resultados solo si hay un día seleccionado -->
    <?php if (!empty($diaSeleccionado)): ?>
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
            <p>No se encontraron programas de retransmisión en el día seleccionado.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>