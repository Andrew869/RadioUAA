<?php
    session_start();
    date_default_timezone_set("America/Mexico_City");

    if(!isset($_SESSION['admin_id'])){
        header('Location: admin_login.php');
        exit();
    }

    include "db_connect.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        switch ($_POST['action']) {
            case 'Crear':
                {
                    $stmt = $conn->prepare("INSERT INTO admins (username, email, password_hash, nombre_completo, rol, activo)
                    VALUES (:username, :email, SHA2(:password_hash, 256), :nombre_completo, :rol, :activo)");
                    $stmt->bindParam(':username', $_POST['username']);
                    $stmt->bindParam(':email', $_POST['email']);
                    $stmt->bindParam(':password_hash', $_POST['password']);
                    $stmt->bindParam(':nombre_completo', $_POST['nombre_completo']);
                    $stmt->bindParam(':rol', $_POST['rol']);
                    // $stmt->bindParam(':ultimo_acceso', $unixEpoch);
                    $stmt->bindParam(':activo', $_POST['activo']);
                    $stmt->execute();
                }
                break;
            case 'Actualizar':
                {
                    $value = "";
                    foreach ($_POST as $key => $x) {
                        switch ($key) {
                            case 'username':
                                {
                                    $stmt = $conn->prepare('UPDATE admins SET username = :val WHERE id_admin = :id_admin');
                                    $value = $x;
                                }
                                    break;
                                case 'email':
                                {
                                    $stmt = $conn->prepare('UPDATE admins SET email = :val WHERE id_admin = :id_admin');
                                    $value = $x;
                                }
                                    break;
                            case 'password_hash':
                                {
                                    $stmt = $conn->prepare('UPDATE admins SET password_hash = :val WHERE id_admin = :id_admin');
                                    $value = $x;
                                }
                                    break;
                                case 'nombre_completo':
                                {
                                    $stmt = $conn->prepare('UPDATE admins SET nombre_completo = :val WHERE id_admin = :id_admin');    
                                    $value = $x;
                                }
                                    break;
                            case 'rol':
                                {
                                    $stmt = $conn->prepare('UPDATE admins SET rol = :val WHERE id_admin = :id_admin');
                                    $value = $x;
                                }
                                    break;
                            case 'activo':
                                {
                                    $stmt = $conn->prepare('UPDATE admins SET activo = :val WHERE id_admin = :id_admin');
                                    $value = $x;
                                }
                                    break;
                                // {
                                //     $field = $key;
                                //     $value = $x;
                                // }
                        }
                    }
                    // $stmt->bindParam(':field', $field);
                    $stmt->bindParam(":val", $value);
                    $stmt->bindParam(':id_admin', $_POST['id_admin']);
                    $stmt->execute();
                }
                break;
            case 'Eliminar':
                {
                    $stmt = $conn->prepare("DELETE FROM admins WHERE id_admin = :id_admin");
                    $stmt->bindParam(':id_admin', $_POST['id_admin']);
                    $stmt->execute();
                }
                break;
        }   
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "metaData.php"; ?>
</head>
<body>
<?php
    echo "Acceso permitido!<br>";
    // echo date("d-m-Y h:i:sa")."<br>";

    echo "ID: " .$_SESSION['admin_id']. "<br>";
    echo "Username: " .$_SESSION['admin_username']. "<br>";
    echo "Eamil: " .$_SESSION['admin_email']. "<br>";
    echo "Rol: " .$_SESSION['admin_rol']. "<br>";
    echo "Ultimo accesso: " .date("d/m/Y h:i:sa" ,strtotime($_SESSION['admin_ultimo_acceso'])). "<br>";
    
    // echo var_dump($_SESSION['admin_ultimo_acceso']). "<br>";
    // echo date("Y/m/d - l - h:i:sa"). "<br>";
    // echo "MKtime " . date("Y/m/d", mktime(11, 14, 54, 8, 12, 2014)). "<br>";
    // echo "Unix Epoch " .strtotime($_SESSION['admin_ultimo_acceso']). "<br>";
    // echo time(). "<br>";

    // $d1=strtotime("december 25");
    // $d2=ceil(($d1-time())/60/60/24);
    // echo "There are " . $d2 ." days until Xmas <br>";
    if($_SESSION['admin_rol'] === "SuperAdmin"){
        echo "<table>";
        echo "
        <tr>
            <th>id_admin</th>
            <th>username</th>
            <th>email</th>
            <th>nombre_completo</th>
            <th>rol</th>
            <th>fecha_creacion</th>
            <th>ultimo_acceso</th>
            <th>activo</th>
            <th></th>
        </tr>";
    
        class TableRows extends RecursiveIteratorIterator {
            private $primary_key;
            private $db_row;

            function __construct($it) {
                parent::__construct($it, self::LEAVES_ONLY);
            }

            function current() {
                if(parent::key() === "id_admin") $this->primary_key = parent::current();
                $this->db_row[parent::key()] = parent::current();
                $parameters = "'" . $this->primary_key . "',";
                $parameters .= "'" . parent::key() . "'," . "'" . parent::current() . "'";
                return "<td>" . parent::current(). (!(parent::key() === "id_admin" || parent::key() === "fecha_creacion" || parent::key() === "ultimo_acceso")? '<div><a href="javascript:showUpdateForm(' .$parameters. ')">editar</a></div>' : "") . "</td>";
            }
        
            function beginChildren() {
                echo "<tr>";
            }
        
            function endChildren() {
                $record = '';
                foreach($this->db_row as $key => $value){
                    if(!($key === "fecha_creacion" || $key === "ultimo_acceso")){
                        if($key === "activo")
                            $record .= "'$value'";
                        else
                            $record .= "'$value',";
                    }
                }
                // echo '<td><a href="javascript:edit(' . $this->primary_key . ')">editar</a></td></tr>' . "\n";
                // echo '<td><button onclick="showForm(['.$record.'])">editar</button></td></tr>' . "\n";
                // $this->db_row = array();
                echo '<td><button onclick="enviarDato('.$this->primary_key.')">eliminar</button></td></tr>' . "\n";
                // echo "</tr>" . "\n";
            }
        } 

        $stmt = $conn->prepare("SELECT id_admin, username, email, nombre_completo, rol, fecha_creacion, ultimo_acceso, activo FROM admins WHERE id_admin <> :id");
        $stmt->bindParam(':id', $_SESSION['admin_id']);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // echo var_dump($stmt->fetchAll());

        foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
            echo $v;
        }
        echo "</table>";
?>
    <button onclick="showForm()">Crear nuevo admin</button>

    <form id="rec_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <fieldset>
            <legend id="rec_legend"></legend>
            <div id="rec_id_admin_container">
                <label for="id_admin">id_admin</label>
                <input id="rec_id_admin" type="text" id="id_admin" name="id_admin" value="" readonly>
            </div>
            <div id="rec_username_container">
                <label for="username">Username</label>
                <input id="rec_username" type="text" id="username" name="username" value="">
            </div>
            <div id="rec_email_container">    
                <label for="email">Email</label>
                <input id="rec_email" type="text" id="email" name="email" value="">
            </div>
            <div id="rec_password_container">    
                <label for="password">Password</label>
                <input id="rec_password" type="password" name="password" id="password">
            </div>
            <div id="rec_nombre_container">
                <label for="nombre_completo">Nombre completo</label>
                <input id="rec_nombre" type="text" id="nombre_completo" name="nombre_completo" value="">
            </div>
            <div id="rec_rol_container">
                <label for="rol">Rol</label>
                <select id="rec_rol" name="rol" id="rol" required>
                    <option value="">Seleccione un rol</option>
                    <option id="rec_rol1" value="SuperAdmin">SuperAdmin</option>
                    <option id="rec_rol2" value="Editor">Editor</option>
                    <option id="rec_rol3" value="Moderador">Moderador</option>
                </select>
            </div>
            <div id="rec_activo_container">
                <label>Activo</label>
                <input id="rec_true" type="radio" name="activo" id="true" value="1">
                <label for="true">si</label>
                <input id="rec_false" type="radio" name="activo" id="false" value="0">
                <label for="false">no</label>
            </div>
            <input id="rec_sumbit" type="submit" name="action" value="Crear">
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