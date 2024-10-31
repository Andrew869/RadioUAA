<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    include 'db_connect.php';
    
    if (isset($_FILES['sql_file']) && $_FILES['sql_file']['error'] == 0) {
        $sqlFile = $_FILES['sql_file']['tmp_name'];
        $sql = file_get_contents($sqlFile);

        $queries = preg_split('/;[\r\n]+/', $sql);
        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query)) {
                try {
                    SQL::$conn->exec($query);
                } catch (PDOException $e) {
                    echo "Error en la consulta: " . $e->getMessage() . "<br>";
                }
            }
        }
        echo "Importación completada.";
    } else {
        echo "Error al cargar el archivo.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar SQL</title>
</head>
<body>
    <h1>Importar Archivo SQL</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="sql_file">Selecciona un archivo SQL:</label>
        <input type="file" name="sql_file" id="sql_file" accept=".sql" required>
        <br><br>
        <input type="submit" value="Importar">
    </form>
</body>
</html>
