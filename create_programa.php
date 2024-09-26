<?php
    include "db_connect.php";
    // SQL::Delete(SQL::PROGRAMA, 4);
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        if(isset($_FILES)){
            $next_id = SQL::GetCurrentIdIndex(SQL::PROGRAMA, SQL::GetPrimaryKeyName(SQL::PROGRAMA)) + 1;
            $target_dir = "resources/uploads/img/";
            $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
            $target_file = $target_dir . $_POST['submit'] . "_$next_id.$imageFileType";
            $uploadOk = 0;

            if (!file_exists($target_file)) { // Check if file already exists
                if ($_FILES["fileToUpload"]["size"] <= 500000) { // Check file size
                    if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ) { // Allow certain file formats
                        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                        if($check !== false) { // Check if image file is a actual image or fake image
                            if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                // echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                                $target_file = "resources/img/programa_default.jpg";
                            }
                        }
                    }
                }
            }
        }

        $id_programa = SQL::Create(SQL::PROGRAMA, [$_POST['nombre_programa'], $target_file, $_POST['descripcion']]);
        foreach (explode(',', $_POST['presentadores']) as $value) {
            SQL::Create(SQL::PROGRAMA_PRESENTADOR, [$id_programa, $value]);
        }
        foreach (explode(',', $_POST['generos']) as $value) {
            SQL::Create(SQL::PROGRAMA_GENERO, [$id_programa, $value]);
        }
    }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "metaData.php" ?>
    <link rel="stylesheet" href="css/styleForm.css">
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" onsubmit="GetSelectedOptions()" method="post" enctype="multipart/form-data" id="uploadForm">
        <fieldset>
            <legend>crear nuevo programa</legend>
            <div>
                <label for="nombre_programa">nombre del programa</label>
                <input type="text" name="nombre_programa" id="nombre_programa">
            </div>
            <div class="drop-zone" id="drop-zone">
                Arrastra y suelta tu archivo aquí o haz clic para seleccionar
            </div>
            <input type="file" name="fileToUpload" id="fileInput" accept="image/*" style="display:none;" required>
            <div>
                <label for="descripcion">descripcion</label>
                <textarea name="descripcion" id="descripcion"></textarea>
            </div>
            <div>
                <select id="rec_rol" name="dia_semana" id="dia_semana">
                    <option id="rec_rol0" value="">Seleccione un dia</option>
                    <option id="rec_rol1" value="Admin">Lunes</option>
                    <option id="rec_rol2" value="Editor">Martes</option>
                    <option id="rec_rol3" value="Moderador">Miercoles</option>
                    <option id="rec_rol3" value="Moderador">Jueves</option>
                    <option id="rec_rol3" value="Moderador">Viernes</option>
                    <option id="rec_rol3" value="Moderador">Sabado</option>
                    <option id="rec_rol3" value="Moderador">Domingo</option>
                </select>
                <input type="time" name="" id="">
                <input type="time" name="" id="">
            </div>
            <h3>Presentador(es)</h3>
            <div class="container">
                <div>
                    <h3>Presentadores seleccionados</h3>
                    <ul id="presentadoresSelected" class="presentadores">

                    </ul>
                </div>
                <div>
                    <h3>Presentadores disponibles</h3>
                    <ul id="presentadoresAvailable" class="presentadores">
                        <?php
                            $presentadores = SQL::Select(SQL::PRESENTADOR, SQL::ALL, SQL::ALL, "id_presentador", "nombre_presentador")->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($presentadores as $presentador) {
                                echo '<li id_presentador="' . $presentador["id_presentador"] . '">' . $presentador["nombre_presentador"] . '</li>';
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <!-- Input oculto para enviar las opciones seleccionadas al servidor -->
            <input type="hidden" name="presentadores" id="presentadoresSelectedInput">
            <h3>Genero(s)</h3>
            <div class="container">
                <div>
                    <h3>Generos seleccionados</h3>
                    <ul id="generosSelected" class="generos">

                    </ul>
                </div>
                <div>
                    <h3>Generos disponibles</h3>
                    <ul id="generosAvailable" class="generos">
                        <?php
                            $generos = SQL::Select(SQL::GENERO, SQL::ALL, SQL::ALL, "id_genero", "nombre_genero")->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($generos as $genero) {
                                echo '<li id_genero="' . $genero["id_genero"] . '">' . $genero["nombre_genero"] . '</li>';
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <!-- Input oculto para enviar las opciones seleccionadas al servidor -->
            <input type="hidden" name="generos" id="generosSelectedInput">
            <button type="submit" name="submit" value="<?php echo SQL::PROGRAMA; ?>">
                Enviar formulario
            </button>
        </fieldset>
    </form>
    <script src="js/formManager.js"></script>
</body>

</html>