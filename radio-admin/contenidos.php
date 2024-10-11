<?php
    session_start();
    date_default_timezone_set("America/Mexico_City");

    if(!isset($_SESSION['id_user'])){
        header('Location: login');
        exit();
    }

    include "../db_connect.php";

    $db_token = SQL::Select(SQL::USER, ["id_user" => $_SESSION['id_user']], ["session_token"])->fetchColumn();

    if($_SESSION['session_token'] !== $db_token){
        setcookie("session_token", "", time() - 3600);
        session_unset();
        session_destroy();
        
        header("Location: login");
        exit();
    }else if(!isset($_COOKIE['session_token'])){
        header("Location: logout");
        exit();
    }

    function Display404() : void{
        echo "404: pagina no encontrada";
    }

    function createCreateBtn($table_name){
        // echo "<button class='modalBtn createBtn' onclick=\"AddContent('$table_name')\">Crear $table_name</button>";
        echo "<button id=\"createBtn\" class='modalBtn' content_name=\"$table_name\">Crear $table_name</button>";
    }

    function ShowField($table_name, $primary_key, $current_content, $key, $type) : void{
        $value_field = '';
        $onclick = '';
        switch ($type) {
            case SQL::TEXT:
            case SQL::ENUM:
                $value_field.= $current_content[$key];       
                break;
            case SQL::PASSWORD:
                $value_field .= "••••••••";
                break;
            case SQL::IMAGE:
                $value_field .= "<img src='$current_content[$key]'>";
                break;
            case SQL::BOOLEAN:
                $value_field .= ($current_content[$key] ? "Sí" : "No");
                break;
        }
        echo $value_field;
        echo "<button class='updateBtn' onclick=\"showUpdateForm('$table_name', '$primary_key', '$key', '" . addslashes($current_content[$key]) . "', '$type')\">Editar</button><br>";
    }

    function ShowSchedules($primary_key){
        $horarios = SQL::Select(SQL::HORARIO, ["id_programa" => $primary_key], [], "dia_semana", SQL::ASCENDANT)->fetchAll(PDO::FETCH_ASSOC);
        $groups = [];

        $btn_element = "<button class=\"updateBtn\" onclick=\"showUpdateSchedules(args)\">Editar</button><br>";
        $args= '';

        foreach ($horarios as $horario) {
            $inicio = ToMinutes($horario['hora_inicio']);
            $fin = ToMinutes($horario['hora_fin']);

            $groups["$inicio,$fin"][] = $horario;
        }

        foreach ($groups as $key => $group) {
            $days = [];
            $retra = null;
            foreach ($group as $horario) {
                $days[] = $horario['dia_semana'];
                if(!isset($retra)) $retra = $horario['es_retransmision'];
                echo $horario['dia_semana'] . ($horario['es_retransmision'] ? " (Retrasmision) " : "" ) . "<br>";
                echo "De " . $horario['hora_inicio'] . " a " . $horario['hora_fin'] . "<br>";
            }
            $jsonDays = json_encode($days, JSON_UNESCAPED_UNICODE);
            $jsonDays = str_replace('"', "'", $jsonDays);
            $jsonDays = addslashes($jsonDays);
            $args = "'$primary_key','$jsonDays','$key','$retra'";
            $final_element = str_replace("args" , $args, $btn_element);
            echo $final_element;
            echo "<br>";
        }
    }

    function ShowList($table_name, $primary_key){
        $table_name_element = null;
        $pk_element = null;
        $value_element = null;
        $output_element = '';
        $btn_element = "<button class=\"updateBtn\" onclick=\"ShowUpdateList(args)\">Editar</button><br>";
        $args= '';
        
        switch ($table_name) {
            case SQL::PROGRAMA_PRESENTADOR:
                $table_name_element = SQL::PRESENTADOR;
                $pk_element = 'id_presentador';
                $value_element = 'nombre_presentador';
                break;
            case SQL::PROGRAMA_GENERO:
                $table_name_element = SQL::GENERO;
                $pk_element = 'id_genero';
                $value_element = 'nombre_genero';
                break;
        }
        $selected = SQL::Select($table_name, ['id_programa' => $primary_key], [$pk_element])->fetchAll(PDO::FETCH_COLUMN);
        $available = SQL::Select($table_name_element, [], [$pk_element, $value_element])->fetchAll(PDO::FETCH_ASSOC);
        $jsonSelected = json_encode($selected);
        $jsonAvailable = json_encode($available, JSON_UNESCAPED_UNICODE);
        $jsonAvailable = addslashes($jsonAvailable);
        $jsonAvailable = str_replace('"', "'", $jsonAvailable);
        $args = "'$primary_key','$table_name', '$jsonSelected', '$jsonAvailable'";
        $btn_element = str_replace("args" , $args, $btn_element);
        foreach ($selected as $element) {
            $output_element = SQL::Select($table_name_element, [$pk_element => $element], [$value_element])->fetchColumn() . "<br>";
            if($table_name_element === SQL::PRESENTADOR){
                $aTag = '<a href="' . htmlspecialchars(pathinfo($_SERVER["PHP_SELF"], PATHINFO_FILENAME)) . "?presentador=" . $element . '">element</a>';
                $output_element = str_replace("element", $output_element, $aTag);
            }
            echo $output_element;
        }
        echo $btn_element;
    }

    class TableRows extends RecursiveIteratorIterator {
        const TEXT = 0;
        const PASSWORD = 1;
        const IMAGE = 3;
        const DATE = 4;
        const TIME = 5;
        const BOOLEAN = 6;

        private $current_index;
        private $table_name;
        private $primary_key;
        private $stmt;
        private $pk_name;

        private const fiels = [
            SQL::PROGRAMA => [["id_programa", "nombre_programa"], [self::TEXT, self::TEXT], ["id", "nombre"]],
            SQL::PRESENTADOR => [["id_presentador", "nombre_presentador", "biografia"], [self::TEXT, self::TEXT, self::TEXT], ["id", "nombre", "biografia"]],
            SQL::GENERO => [["id_genero", "nombre_genero"], [self::TEXT, self::TEXT], ["id", "genero"]],
            SQL::USER => [["id_user", "username" ,"rol"], [self::TEXT, self::TEXT, self::TEXT], ["id", "username", "rol"]]
        ];

        function __construct($table_name) {
            $this->table_name = $table_name;
            $this->current_index = 0;
            // $this->stmt = SQL::Select($table_name, SQL::ALL, SQL::ALL, "id_user", "username", "email", "password_hash", "nombre_completo", "rol", "cuenta_activa", "fecha_creacion", "ultimo_acceso");
            $this->pk_name = SQL::GetPrimaryKeyName($table_name);
            $this->stmt = SQL::Select($table_name, [], self::fiels[$table_name][0]);
            $this->stmt->setFetchMode(PDO::FETCH_ASSOC); // set the resulting array to associative
            parent::__construct(new RecursiveArrayIterator($this->stmt->fetchAll()), self::LEAVES_ONLY);
            echo createCreateBtn($table_name);
            echo "<table>";
            foreach (self::fiels[$table_name][2] as $value) {
                echo "<th>" . $value . "</th>";
            }
            echo "</tr>";
        }

        function current(): mixed {
            // $this->db_row[parent::key()] = parent::current();
            // self::fiels[$table_name][1][i]
            // $this->current_field = $this->field_properties[$this->table_name][$this->current_index];
            $cell_content = "<td";
            if($this->pk_name === parent::key()){
                $this->primary_key = parent::current();
                $cell_content .= " class='pk'";
            }
            $cell_content .= ">";

            // if($this->current_field[1]){
                // $cell_content .= "<td>";
                switch (self::fiels[$this->table_name][1][$this->current_index]) {
                    case self::TEXT:
                        $cell_content .= parent::current();
                        break;
                    case self::PASSWORD:
                        $cell_content .= "••••••••";
                        break;
                    case self::IMAGE:
                        $cell_content .= "*Show Image*";
                        break;
                    case self::DATE:
                        $cell_content .= date("Y-m-d H:i:s", strtotime(parent::current()));
                        break;
                    case self::TIME:
                        $cell_content .= date("h:i:sa", strtotime(parent::current()));
                        break;
                    case self::BOOLEAN:
                        $cell_content .= (parent::current() ? "Sí" : "No");
                        break;
                }
                
                $parameters = "'" . $this->primary_key . "',";
                $parameters .= "'" . parent::key() . "'," . "'" . (parent::key() === "password_hash" ? "" : parent::current()) . "'";
                $cell_content .= "</td>";
            $this->current_index++;
            return $cell_content;
        }
    
        function beginChildren(): void {
            echo "<tr class='values'>";
        }
    
        function endChildren(): void{
            $this->current_index = 0;
            // $this->current_field = $this->field_properties[$this->table_name][$this->current_index];
            // echo '<td><button onclick="deleteRecord('.$this->primary_key.')">eliminar</button></td></tr>';
            echo "</tr>";
        }

        function endIteration(): void{
            echo "</table>";
        }
    }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radio Admin</title>
    <link rel="stylesheet" href="../css/styleContent.css">
    <script type="module" src="../js/utilities.js"></script>
</head>

<body>
    <header>
        <?php
        include "nav_header.php";
        ?>
    </header>
    <main>
    <?php
        $flag = 1;
        $content = $pk = '';
        if(count(($_GET)) === 1){
            $flag = 0;
            foreach ($_GET as $key => $value) {
                $content = $key;
                $pk = $value;
                switch ($key) {
                    case SQL::PROGRAMA:
                        {
                            $programa = SQL::Select(SQL::PROGRAMA, ["id_programa" => $value])->fetch(PDO::FETCH_ASSOC);
                            if(!$programa){
                                Display404();
                                break;
                            }
                            ShowField($key, $value, $programa, 'nombre_programa', SQL::TEXT);
                            ShowField($key, $value, $programa, 'url_imagen', SQL::IMAGE);
                            ShowField($key, $value, $programa, 'descripcion', SQL::TEXT);
                            echo "<br>";
                            
                            echo "Horarios: <br>";
                            ShowSchedules($value);

                            // foreach ($horarios as $horario) {
                            //     $tmp[$horario['hora_inicio']] = $horario;
                            //     echo $horario['dia_semana'] . ($horario['es_retransmision'] ? " (Retrasmision) " : "" ) . "<br>";
                            //     echo "De " . $horario['hora_inicio'] . " a " . $horario['hora_fin'] . "<br>";
                            //     echo "<br>";
                            // }
                            // echo "<br>";
                            
                            echo "presentado por: <br>";
                            ShowList(SQL::PROGRAMA_PRESENTADOR, $value);
                            // $presentadores = SQL::Select(SQL::PROGRAMA_PRESENTADOR, ["id_programa" => $value], ["id_presentador"])->fetchAll(PDO::FETCH_ASSOC);
                            // foreach ($presentadores as $presentador) {
                            //     echo '<a href="'. htmlspecialchars(pathinfo($_SERVER["PHP_SELF"], PATHINFO_FILENAME)) . "?presentador=". $presentador["id_presentador"] .'">' . SQL::Select(SQL::PRESENTADOR, ["id_presentador" => $presentador["id_presentador"]], ["nombre_presentador"])->fetchColumn() . '</a> <br>';
                            // }
                            echo "<br>";
                            echo "Generos: <br>";
                            ShowList(SQL::PROGRAMA_GENERO, $value);
                            // $generos = SQL::Select(SQL::PROGRAMA_GENERO, ['id_programa' => $value], ["id_genero"])->fetchAll(PDO::FETCH_ASSOC);
                            // foreach ($generos as $genero) {
                            //     echo SQL::Select(SQL::GENERO, ["id_genero" => $genero["id_genero"]], ["nombre_genero"])->fetchColumn() . "<br>";
                            // }
                        }
                        break;
                    case SQL::PRESENTADOR:
                        $presentador = SQL::Select(SQL::PRESENTADOR, ['id_presentador' => $value])->fetch(PDO::FETCH_ASSOC);
                        if(!$presentador){
                            Display404();
                            break;
                        }
                        ShowField($key, $value, $presentador, 'nombre_presentador', SQL::TEXT);
                        ShowField($key, $value, $presentador, 'biografia', SQL::TEXT);
                        ShowField($key, $value, $presentador, 'url_foto', SQL::IMAGE);
                        break;
                    case SQL::GENERO:
                        $genero = SQL::Select(SQL::GENERO, ['id_genero' => $value])->fetch(PDO::FETCH_ASSOC);
                        if(!$genero){
                            Display404();
                            break;
                        }
                        ShowField($key, $value, $genero, 'nombre_genero', SQL::TEXT);
                        break;
                    case SQL::USER:
                        $user = SQL::Select(SQL::USER, ['id_user' => $value])->fetch(PDO::FETCH_ASSOC);
                        if(!$user){
                            Display404();
                            break;
                        }
                        ShowField($key, $value, $user, 'username', SQL::TEXT);
                        ShowField($key, $value, $user, 'email', SQL::TEXT);
                        ShowField($key, $value, $user, 'password_hash', SQL::PASSWORD);
                        ShowField($key, $value, $user, 'nombre_completo', SQL::TEXT);
                        ShowField($key, $value, $user, 'rol', SQL::ENUM);
                        ShowField($key, $value, $user, 'cuenta_activa', SQL::BOOLEAN);
                        break;
                    default:
                        $flag = 1;
                        break;
                }
            }
            ?>
            <div id="updateModal" class="modal">
                <span class="close">&times;</span>
                <div class="modal-content">
                    <div class="container">
                        <div id="text" class="inputModal">
                            <label for="">text</label>
                            <input type="text" name="" id="">
                        </div>
                        <div id="password" class="inputModal">
                            <label for="">password</label>
                            <input type="password" name="" id="">
                        </div>
                        <div id="image" class="inputModal">
                            <div id="input_file">
                                <label for=""></label>
                                <div class="drop-zone" id="drop-zone" for="fileInput">
                                    <!-- Arrastra y suelta tu archivo aquí o haz clic para seleccionar -->
                                    TODO: ARREGLAR ARRASTRADO DE ARCHIVO!!!
                                </div>
                                <input type="file" name="fileToUpload" id="fileInput" accept="image/*" style="display:none;">
                                <div id="feedback_file"></div>
                            </div>
                        </div>
                        <div id="enum" class="inputModal">
                            <label for=""></label>
                            <select id="enumContent" name="">
                            </select>
                        </div>
                        <div id="boolean" class="inputModal">
                            <label></label>
                            <input id="true" type="radio" class="radio" name="opction" value="1">
                            <label for="true">si</label>
                            <input id="false" type="radio" class="radio" name="opction" value="0">
                            <label for="false">no</label>
                            <input type="text" id="radioMaster" name="">
                        </div>
                        <div id="schedules" class="inputModal">
                            <div class="days_container">
                                <ul class="days_list">
                                    <?php 
                                        // foreach (SQL::GetEnumValues(SQL::HORARIO, "dia_semana") as $dia) {
                                        //     echo '<li dia_semana="' . $dia . '">' . $dia . '</li>';
                                        // }
                                    ?>
                                </ul>
                                <input type="hidden" name="horarios[0][dias]" class="diasSelectedInput" field_name="dias">
                            </div>
                            <label for="">Hora inicio</label>
                            <input type="time" name="horarios[0][hora_inicio]" field_name="hora_inicio">
                            <label for="">Hora final</label>
                            <input type="time" name="horarios[0][hora_fin]" field_name="hora_fin">
                            <label for="">Es retrasmision</label>
                            <input type="checkbox">
                            <!-- <input type="checkbox" name="horarios[0][es_retransmision]" field_name="es_retransmision" value="0" class="chk" checked hidden> -->
                            <div class="txtHint"></div>
                        </div>
                        <div id="list" class="inputModal">
                            <div>
                                <h3>Seleccionados</h3>
                                <ul id="optionsSelected" class="options">

                                </ul>
                            </div>
                            <div>
                                <h3>Disponibles</h3>
                                <ul id="optionsAvailable" class="options">
                                    <?php
                                        // $presentadores = SQL::Select(SQL::PRESENTADOR, [], ["id_presentador", "nombre_presentador"])->fetchAll(PDO::FETCH_ASSOC);
                                        // foreach ($presentadores as $presentador) {
                                        //     echo '<li id_presentador="1">Juan Pérez</li>';
                                        // }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix">
                            <button type="button" id="cancelBtn" class="modalBtn">Cancel</button>
                            <button type="button" id="confirmBtn" class="modalBtn">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>

            <button id='deleteBtn' class="modalBtn" <?php echo "onclick=\"ShowConfirmationModal('$content','$pk')\"" ?>>Eliminar</button>
            <div id="deleteModal" class="modal">
                <!-- <span onclick="document.getElementById('deleteModal').style.display='none'" class="close" title="Close Modal">&times;</span> -->
                <span class="close">&times;</span>
                <div class="modal-content">
                    <div class="container">
                        <h1>Delete Content</h1>
                        <p>Are you sure you want to delete this content?</p>

                        <div class="clearfix">
                            <button type="button" id="cancelBtn" class="modalBtn">Cancel</button>
                            <button type="button" id="confirmBtn" class="modalBtn">Delete</button>
                        </div>    
                    </div>
                </div>
            </div>
            <!-- <div id="deleteModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <p>Some text in the Modal..</p>
                </div>
            </div> -->

            <?php
        }
        if($flag){
    ?>
        
        <div class="tab">
            <button id="defaultOpen" class="tablinks" onclick="ShowContent(event, 'programa')">Programas</button>
            <button class="tablinks" onclick="ShowContent(event, 'presentador')">Presentadores</button>
            <button class="tablinks" onclick="ShowContent(event, 'genero')">Generos</button>
            <button class="tablinks" onclick="ShowContent(event, 'user')">Usuarios</button>
        </div>

        <!-- Tab content -->
        <div id="programa" class="tabcontent">
        <?php
            foreach(new TableRows(SQL::PROGRAMA) as $k => $v) {
                echo $v;
            }
        ?>
        </div>
        
        <div id="presentador" class="tabcontent">
        <?php
            foreach(new TableRows(SQL::PRESENTADOR) as $k => $v) {
                echo $v;
            }
        ?>
        </div>

        <div id="genero" class="tabcontent">
        <?php
            foreach(new TableRows(SQL::GENERO) as $k => $v) {
                echo $v;
            }
        ?>
        </div>

        <div id="user" class="tabcontent">
        <?php
            foreach(new TableRows(SQL::USER) as $k => $v) {
                echo $v;
            }
        ?>
        </div>
        <script src="../js/tabsManager.js"></script>
        <?php
        }
        include "createForms.php";
        ?>
        <script src="../js/contentManager.js"></script>
        <!-- <script src="../js/createManager.js"></script> -->
        <button onclick="AddContent('programa')">crear</button>
        <div id="modals_container">
            <div class="modal">
                <span class="close">&times;</span>
                <div class="modal-content">
                    <div class="container">
                        <div class="btns_container">
                            <button type="button" id="cancelBtn" class="modalBtn">Cancel</button>
                            <button type="button" id="confirmBtn" class="modalBtn" onclick="CreateModal()" >Crear</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="module" src="../js/modalsManager.js"></script>
    </main>
</body>

</html>