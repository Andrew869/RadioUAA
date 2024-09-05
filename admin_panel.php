<?php
    date_default_timezone_set("America/Mexico_City");
    session_start();

    if(!isset($_SESSION['admin_id'])){
        header('Location: admin_login.php');
        exit();
    }

    include "db_connect.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

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

            function __construct($it) {
                parent::__construct($it, self::LEAVES_ONLY);
            }

            function current() {
                if(parent::key() === "id_admin") $this->primary_key = parent::current();
                return "<td>" . (parent::key() === "id_admin" ? "P.K=" : "" ) . parent::current(). "</td>";
            }
        
            function beginChildren() {
                echo "<tr>";
            }
        
            function endChildren() {
                echo '<td><a href="javascript:edit(' . $this->primary_key . ')">editar</a></td></tr>' . "\n";
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
    <form id="creation_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <fieldset>
            <legend>Crear administrador</legend>
            <label for="username">Username</label>
            <input type="text" id="username" name="username">
            <label for="email">Email</label>
            <input type="text" id="email" name="email">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <label for="nombre_completo">Nombre completo</label>
            <input type="text" id="nombre_completo" name="nombre_completo">
            <label for="rol">Rol</label>
            <select name="rol" id="rol" required>
                <option value="">Seleccione un rol</option>
                <option value="SuperAdmin">SuperAdmin</option>
                <option value="Editor">Editor</option>
                <option value="Moderador">Moderador</option>
            </select>
            <label>Activo</label>
                <input type="radio" name="activo" id="true" value="1" checked>
                <label for="true">si</label>
                <input type="radio" name="activo" id="false" value="0">
                <label for="false">no</label>
            <input type="submit" value="Crear">
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