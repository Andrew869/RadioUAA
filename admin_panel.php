<?php
    session_start();
    date_default_timezone_set("America/Mexico_City");

    if(!isset($_SESSION['id_user'])){
        header('Location: admin_login.php');
        exit();
    }

    include "db_connect.php";

    $db_token = SQL::Select(SQL::USER, $_SESSION['id_user'], "session_token")->fetchColumn();

    if($_SESSION['session_token'] !== $db_token || !isset($_COOKIE['session_token'])){
        setcookie("session_token", "", time() - 3600);
        session_unset();
        session_destroy();
        
        header("Location: admin_login.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['rol'] === "Admin"){
        switch ($_POST['action']) {
            case SQL::CREATE:
                {
                    SQL::Create(SQL::USER, $_POST);
                }
                break;
            case SQL::UPDATE:
                {
                    $flag = 0;
                    foreach ($_POST as $key => $value) {
                        switch ($key) {
                            case "username":
                            case 'email':
                            case 'password_hash':
                            case 'nombre_completo':
                            case 'rol':
                            case 'cuenta_activa':
                                // $value = ($key === "password_hash" ? hash('sha256', $x) : $x);
                                $flag = 1;
                                SQL::Update(SQL::USER, $_POST['id_user'], $key, $value);
                                break;
                        }
                        if($flag) break;
                    }
                }
                break;
            case SQL::DELETE:
                {
                    SQL::Delete(SQL::USER, $_POST['id_user']);
                }
                break;
        }   
    }

    class Records extends RecursiveIteratorIterator{
        private $primary_key;

        function __construct($table_name){
            $stmt = SQL::$conn->prepare("SELECT id_user, username, email, password_hash, nombre_completo, rol, cuenta_activa, fecha_creacion, ultimo_acceso FROM ? WHERE id_user <> ?");
            $stmt->bindParam(':id', $_SESSION['id_user']);
            $stmt->execute();
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "metaData.php"; ?>
    <link rel="stylesheet" href="css/stylePanel.css">
</head>
<body>
<?php
    echo "Acceso permitido!<br>";
    echo 'IP Address - ' . $_SERVER['REMOTE_ADDR'] . "<br>";
    echo $_SESSION['session_token'] . "<br>";
    // echo date("d-m-Y h:i:sa")."<br>";

    echo "ID: " .$_SESSION['id_user']. "<br>";
    echo "Username: " .$_SESSION['username']. "<br>";
    echo "Email: " .$_SESSION['email']. "<br>";
    echo "Rol: " .$_SESSION['rol']. "<br>";
    echo "Fecha creacion " . $_SESSION['fecha_creacion'] . "<br>";
    echo "Ultimo accesso: " . ($_SESSION['fecha_creacion'] === $_SESSION['ultimo_acceso'] ? "ahora" : date("d/m/Y h:i:sa" ,strtotime($_SESSION['ultimo_acceso']))) . "<br>";
    
    // echo var_dump($_SESSION['admin_ultimo_acceso']). "<br>";
    // echo date("Y/m/d - l - h:i:sa"). "<br>";
    // echo "MKtime " . date("Y/m/d", mktime(11, 14, 54, 8, 12, 2014)). "<br>";
    // echo "Unix Epoch " .strtotime($_SESSION['admin_ultimo_acceso']). "<br>";
    // echo time(). "<br>";

    // $d1=strtotime("december 25");
    // $d2=ceil(($d1-time())/60/60/24);
    // echo "There are " . $d2 ." days until Xmas <br>";
    if($_SESSION['rol'] === "Admin"){


        class TableRows extends RecursiveIteratorIterator {
            private $primary_key;
            private $fecha_creacion;
            private $db_row;

            function __construct($it) {
                parent::__construct($it, self::LEAVES_ONLY);
                echo "<table>";
                echo "
                    <tr>
                        <th>id_user</th>
                        <th>username</th>
                        <th>email</th>
                        <th>password</th>
                        <th>nombre_completo</th>
                        <th>rol</th>
                        <th>cuenta_activa</th> 
                        <th>fecha_creacion</th>
                        <th>ultimo_acceso</th>
                        <th></th>
                    </tr>
                ";
            }

            function current() {
                $this->db_row[parent::key()] = parent::current();
                $parameters = "'" . $this->primary_key . "',";
                $parameters .= "'" . parent::key() . "'," . "'" . (parent::key() === "password_hash" ? "" : parent::current()) . "'";
                switch (parent::key()) {
                    case 'id_user':
                        $this->primary_key = parent::current();
                        break;
                    case 'fecha_creacion':
                        $this->fecha_creacion = parent::current();
                        break;
                    case 'ultimo_acceso':
                        if($this->fecha_creacion === parent::current())
                            return "<td>nunca</td>";
                        break;
                }
                return "<td>" . (parent::key() === "password_hash"? "••••••••" : parent::current()) . (!(parent::key() === "id_user" || parent::key() === "fecha_creacion" || parent::key() === "ultimo_acceso")? '<div><a href="javascript:showUpdateForm(' .$parameters. ')">editar</a></div>' : "") . "</td>";
            }
        
            function beginChildren() {
                echo "<tr>";
            }
        
            function endChildren() {
                // echo '<td><a href="javascript:edit(' . $this->primary_key . ')">editar</a></td></tr>' . "\n";
                // echo '<td><button onclick="showForm(['.$record.'])">editar</button></td></tr>' . "\n";
                // $this->db_row = array();
                echo '<td><button onclick="deleteRecord('.$this->primary_key.')">eliminar</button></td></tr>';
            }

            function endIteration(){
                echo "</table>";
            }
        } 

        $stmt = SQL::$conn->prepare("SELECT id_user, username, email, password_hash, nombre_completo, rol, cuenta_activa, fecha_creacion, ultimo_acceso FROM user WHERE id_user <> :id");
        $stmt->bindParam(':id', $_SESSION['id_user']);
        $stmt->execute();

        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
            echo $v;
        }
?>
    <button onclick="showFullForm()">Crear nuevo admin</button>

    <form id="rec_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <fieldset>
            <legend id="rec_legend"></legend>
            <div id="rec_id_user_container">
                <label for="rec_id_user">id_user</label>
                <input id="rec_id_user" type="text" id="id_user" name="id_user" value="" readonly>
            </div>
            <div id="rec_username_container">
                <label for="rec_username">Username</label>
                <input id="rec_username" type="text" id="username" name="username" autocomplete="off" value="">
            </div>
            <div id="rec_email_container">    
                <label for="rec_email">Email</label>
                <input id="rec_email" type="text" id="email" name="email" value="">
            </div>
            <div id="rec_password_container">    
                <label for="rec_password">Password</label>
                <input id="rec_password" type="password" name="password_hash" autocomplete="off">
                <!-- <label for="rec_password_2">Password</label>
                <input id="rec_password_2" type="password" name="password" id="password"> -->
            </div>
            <div id="rec_nombre_container">
                <label for="rec_nombre">Nombre completo</label>
                <input id="rec_nombre" type="text" id="nombre_completo" name="nombre_completo" value="">
            </div>
            <div id="rec_rol_container">
                <label for="rol">Rol</label>
                <select id="rec_rol" name="rol" id="rol" required>
                    <option id="rec_rol0" value="">Seleccione un rol</option>
                    <option id="rec_rol1" value="Admin">Admin</option>
                    <option id="rec_rol2" value="Editor">Editor</option>
                    <option id="rec_rol3" value="Moderador">Moderador</option>
                </select>
            </div>
            <div id="rec_cuenta_activa_container">
                <label>Cuenta activa</label>
                <input id="rec_true" type="radio" name="cuenta_activa" id="true" value="1">
                <label for="true">si</label>
                <input id="rec_false" type="radio" name="cuenta_activa" id="false" value="0">
                <label for="false">no</label>
            </div>
            <button id="rec_submit" type="submit" name="action" value="<?php SQL::CREATE; ?>">
                Enviar formulario
            </button>
            <!-- <input id="rec_submit" type="submit" name="action" value="<?php SQL::CREATE; ?>"> -->
        </fieldset>
    </form>
    <?php 
    }
    ?>
    

    <!-- <form action="upload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form> -->
    <div>
        <a href="admin_logout.php">cerrar sesion</a>
    </div>
    <footer>
        &copy; 2010-<?php echo date("Y");?>
    </footer>
    <script src="js/adminManager.js"></script>
</body>
</html>