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
        echo "<button class='modalBtn createBtn' contentName=\"$table_name\">Crear $table_name</button>";
    }

    function ShowField($table_name, $primary_key, $fieldName, $fieldTitle, $type, $current_content) : void{
        $value_field = '';
        $onclick = '';
        switch ($type) {
            case SQL::TEXT:
            case SQL::ENUM:
            case 'textarea':
                $value_field.= $current_content[$fieldName];       
                break;
            case SQL::PASSWORD:
                $value_field .= "••••••••";
                break;
            case SQL::FILE:
                $value_field .= "<img src='$current_content[$fieldName]'>";
                break;
            case SQL::BOOLEAN:
                $value_field .= ($current_content[$fieldName] ? "Sí" : "No");
                break;
        }

        $fieldsInfo = [
            'programa' => [
                'nombre_programa' => 'Nombre del programa',
                'url_imagen' => 'Imagen del programa',
                'descripcion' => 'Descripcion',
                'horario' => 'Horarios',
                'presentador' => 'Presentadores',
                'genero' => 'Generos',
            ],
            'horario' => [
                'horario' => 'Horarios',
            ],
            'presentador' => [
                'nombre_presentador' => 'Nombre presentador',
                'url_foto' => 'foto del presentador',
                'biografia' => 'Biografia',
            ],
            'genero' => [
                'nombre_genero' => 'Nombre del genero',
            ],
            'user' => [
                'username' => 'Nombre de usuario',
                'email' => 'correo de usuario',
                'password' => 'contraseña',
                'nombre_completo' => 'Nombre completo',
                'rol' => 'Rol del usuario',
                'cuenta_activa' => 'Cuenta Activa',
            ]
        ];

        echo "<div class='contentField' contentName='$table_name' pk='$primary_key' fieldName='$fieldName' inputType='$type'>";
        echo "<div><div class='fieldTitle'>$fieldTitle</div><div class='currentValue'>$value_field</div></div>";
        echo "<button class='updateBtn'>Editar</button><br>";
        echo "</div>";
    }

    function ShowSchedules($primary_key){
        $horarios = SQL::Select(SQL::HORARIO, ["id_programa" => $primary_key], [], "dia_semana", SQL::ASCENDANT)->fetchAll(PDO::FETCH_ASSOC);
        $groups = [];

        $btn_element = "<button class='updateBtn'>Editar</button><br>";
        $rangoHorario = '';
        $currentValuesElement = "<div class='currentValue' style='display: none;'>args</div>";
        $args= '';

        foreach ($horarios as $horario) {
            $inicio = ToMinutes($horario['hora_inicio']);
            $fin = ToMinutes($horario['hora_fin']);

            $groups["$inicio,$fin"][] = $horario;
        }

        foreach ($groups as $key => $group) {
            echo "<div class='contentField' contentName='horario' pk='$primary_key' fieldName='Horarios' inputType='schedules'>";
            $days = [];
            $retra = null;
            foreach ($group as $horario) {
                $days[] = $horario['dia_semana'];
                if(!isset($retra)) $retra = $horario['es_retransmision'];
                echo $horario['dia_semana'] . ($horario['es_retransmision'] ? " (Retrasmision) " : "" ) . "<br>";
                $rangoHorario = "De " . $horario['hora_inicio'] . " a " . $horario['hora_fin'] . "<br>";
                echo $rangoHorario;
            }
            $jsonDays = json_encode($days, JSON_UNESCAPED_UNICODE);
            // $jsonDays = str_replace('"', "'", $jsonDays);
            // $jsonDays = addslashes($jsonDays);
            $args = "[$jsonDays,[$key],$retra]";
            $currentValuesElement = str_replace("args" , $args, $currentValuesElement);
            $fieldNameElement = "<div class='fieldTitle' style='display: nonde;'>Horario</div>";
            echo $fieldNameElement;
            echo $currentValuesElement;
            echo $btn_element;
            echo "</div>";
        }

        if(!count($groups)){
            echo "<button id='$primary_key' class='modalBtn createBtn' contentName=\"horario\">Añadir horarios</button>";
        }
    }

    function ShowList($table_name, $primary_key){
        $fieldTitle = null;
        $table_name_element = null;
        $pk_element = null;
        $value_element = null;
        $output_element = '';
        
        $args= '';
        
        switch ($table_name) {
            case SQL::PROGRAMA_PRESENTADOR:
                $fieldTitle = 'Presentadores';
                $table_name_element = SQL::PRESENTADOR;
                $pk_element = 'id_presentador';
                $value_element = 'nombre_presentador';
                break;
            case SQL::PROGRAMA_GENERO:
                $fieldTitle = 'Generos';
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

        $btn_element = "<button class='updateBtn'>Editar</button><br>";
        $btn_element = str_replace("args" , $args, $btn_element);

        echo "<div class='contentField' contentName='$table_name' pk='$primary_key' fieldName='$table_name_element' inputType='list'>";
        echo "<div class='fieldTitle'>$fieldTitle</div>";
        echo "<ul>";
        foreach ($selected as $element) {
            $output_element = SQL::Select($table_name_element, [$pk_element => $element], [$value_element])->fetchColumn() . "<br>";
            if($table_name_element === SQL::PRESENTADOR){
                $aTag = '<a href="' . htmlspecialchars(pathinfo($_SERVER["PHP_SELF"], PATHINFO_FILENAME)) . "?presentador=" . $element . '">element</a>';
                $output_element = str_replace("element", $output_element, $aTag);
            }
            echo "<li>$output_element</li>";
        }
        echo "</ul>";
        echo "<div class='currentValue' style='display: none;'>$jsonSelected</div>";
        echo $btn_element;
        echo "</div>";
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
                            ShowField($key, $value, 'nombre_programa', 'Nombre del programa', SQL::TEXT, $programa);
                            ShowField($key, $value, 'url_imagen', 'Imagen del programa', SQL::FILE, $programa);
                            ShowField($key, $value, 'descripcion', 'Descripcion', 'textarea', $programa);
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
                            
                            // echo "presentado por: <br>";
                            ShowList(SQL::PROGRAMA_PRESENTADOR, $value);
                            // $presentadores = SQL::Select(SQL::PROGRAMA_PRESENTADOR, ["id_programa" => $value], ["id_presentador"])->fetchAll(PDO::FETCH_ASSOC);
                            // foreach ($presentadores as $presentador) {
                            //     echo '<a href="'. htmlspecialchars(pathinfo($_SERVER["PHP_SELF"], PATHINFO_FILENAME)) . "?presentador=". $presentador["id_presentador"] .'">' . SQL::Select(SQL::PRESENTADOR, ["id_presentador" => $presentador["id_presentador"]], ["nombre_presentador"])->fetchColumn() . '</a> <br>';
                            // }
                            // echo "<br>";
                            // echo "Generos: <br>";
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
                        ShowField($key, $value, 'nombre_presentador', 'Nombre presentador', SQL::TEXT, $presentador);
                        ShowField($key, $value, 'biografia', 'Biografia', SQL::TEXT, $presentador);
                        ShowField($key, $value, 'url_foto', 'foto del presentador', SQL::FILE, $presentador);
                        break;
                    case SQL::GENERO:
                        $genero = SQL::Select(SQL::GENERO, ['id_genero' => $value])->fetch(PDO::FETCH_ASSOC);
                        if(!$genero){
                            Display404();
                            break;
                        }
                        ShowField($key, $value, 'nombre_genero', 'Nombre del genero', SQL::TEXT, $genero);
                        break;
                    case SQL::USER:
                        $user = SQL::Select(SQL::USER, ['id_user' => $value])->fetch(PDO::FETCH_ASSOC);
                        if(!$user){
                            Display404();
                            break;
                        }
                        ShowField($key, $value, 'username', 'Nombre de usuario', SQL::TEXT, $user);
                        ShowField($key, $value, 'email', 'correo de usuario', SQL::TEXT, $user);
                        ShowField($key, $value, 'password_hash', 'contraseña', SQL::PASSWORD, $user);
                        ShowField($key, $value, 'nombre_completo', 'Nombre completo', SQL::TEXT, $user);
                        ShowField($key, $value, 'rol', 'Rol del usuario', SQL::ENUM, $user);
                        ShowField($key, $value, 'cuenta_activa', 'Cuenta Activa', SQL::BOOLEAN, $user);
                        break;
                    default:
                        $flag = 1;
                        break;
                }
            }
            echo "<button class='modalBtn deleteBtn' contentName='$content' pk='$pk' >Eliminar</button>";
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
        // include "createForms.php";
        ?>
        <script src="../js/contentManager.js"></script>
        <!-- <script src="../js/createManager.js"></script> -->
        <!-- <button onclick="AddContent('programa')">crear</button> -->
        <div id="modals_container">
        </div>
        <script type="module" src="../js/modalsManager.js"></script>
    </main>
</body>

</html>