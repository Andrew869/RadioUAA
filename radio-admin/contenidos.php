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
            SQL::PROGRAMA => [["id_programa", "nombre_programa", "descripcion"], [self::TEXT, self::TEXT, self::TEXT], ["id", "nombre", "descripción"]],
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
                            echo $programa['nombre_programa'] . "<br>";
                            echo '<img src="'.$programa['url_imagen'].'" style="display: block;" alt="imagen_programa" width="50" height="50">';
                            echo $programa['descripcion'] . "<br>";
                            echo "<br>";
                            
                            echo "Horarios: <br>";
                            $horarios = SQL::Select(SQL::HORARIO, ["id_programa" => $value], [], "dia_semana", SQL::ASCENDANT)->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($horarios as $horario) {
                                echo $horario['dia_semana'] . ($horario['es_retransmision'] ? " (Retrasmision) " : "" ) . "<br>";
                                echo "De " . $horario['hora_inicio'] . " a " . $horario['hora_fin'] . "<br>";
                                echo "<br>";
                            }
                            echo "<br>";
                            
                            echo "presentado por: <br>";
                            $presentadores = SQL::Select(SQL::PROGRAMA_PRESENTADOR, ["id_programa" => $value], ["id_presentador"])->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($presentadores as $presentador) {
                                echo '<a href="'. htmlspecialchars(pathinfo($_SERVER["PHP_SELF"], PATHINFO_FILENAME)) . "?presentador=". $presentador["id_presentador"] .'">' . SQL::Select(SQL::PRESENTADOR, ["id_presentador" => $presentador["id_presentador"]], ["nombre_presentador"])->fetchColumn() . '</a> <br>';
                            }
                            echo "<br>";
                            echo "Generos: <br>";
                            $generos = SQL::Select(SQL::PROGRAMA_GENERO, ['id_programa' => $value], ["id_genero"])->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($generos as $genero) {
                                echo SQL::Select(SQL::GENERO, ["id_genero" => $genero["id_genero"]], ["nombre_genero"])->fetchColumn() . "<br>";
                            }
                        }
                        break;
                    case SQL::PRESENTADOR:
                        $presentador = SQL::Select(SQL::PRESENTADOR, ['id_presentador' => $value])->fetch(PDO::FETCH_ASSOC);
                        if(!$presentador){
                            Display404();
                            break;
                        }
                        echo $presentador['nombre_presentador'] . "<button id='UpdateBtn' class='modalBtn'>Editar</button><br>";
                        echo $presentador['biografia'] . "<br>";
                        echo '<img src="'.$presentador['url_foto'].'" style="display: block;" alt="imagen_programa" width="50" height="50">';
                        break;
                    case SQL::GENERO:
                        $genero = SQL::Select(SQL::GENERO, ['id_genero' => $value])->fetch(PDO::FETCH_ASSOC);
                        if(!$genero){
                            Display404();
                            break;
                        }
                        echo $genero['nombre_genero'] . "<br>";
                        break;
                    case SQL::USER:
                        $user = SQL::Select(SQL::USER, ['id_user' => $value])->fetch(PDO::FETCH_ASSOC);
                        if(!$user){
                            Display404();
                            break;
                        }
                        echo $user['username'] . "<br>";
                        echo $user['email'] . "<br>";
                        echo $user['password_hash'] . "<br>";
                        echo $user['nombre_completo'] . "<br>";
                        echo $user['rol'] . "<br>";
                        echo $user['cuenta_activa'] . "<br>";
                        break;
                    default:
                        $flag = 1;
                        break;
                }
            }
            ?>
            <button id='deleteBtn' class="modalBtn">Eliminar</button>
            <div id="deleteModal" class="modal">
                <!-- <span onclick="document.getElementById('deleteModal').style.display='none'" class="close" title="Close Modal">&times;</span> -->
                <span class="close">&times;</span>
                <div class="modal-content">
                    <div class="container">
                        <h1>Delete Content</h1>
                        <p>Are you sure you want to delete this content?</p>

                        <div class="clearfix">
                            <button type="button" id="cancelBtn" class="modalBtn">Cancel</button>
                            <button type="button" id="confirmBtn" class="modalBtn" <?php echo "content='$content' pk='$pk'" ?>>Delete</button>
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
            <button class="tablinks" onclick="ShowContent(event, 'comentario')">Comentarios</button>
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
    
        <div id="comentario" class="tabcontent">
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
        <?php
        }
        ?>

    </main>
    <script src="../js/contentManager.js"></script>
</body>

</html>