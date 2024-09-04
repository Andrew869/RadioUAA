<?php
    date_default_timezone_set("America/Mexico_City");
    session_start();

    if(!isset($_SESSION['admin_id'])){
        header('Location: admin_login.php');
        exit();
    }

    include "db_connect.php";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "metaData.php"; ?>
</head>
<body>
<?php
    echo "Acceso permitido!<br>";

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
    if($_SESSION['admin_id'] === 1){
        echo "<table style='border: solid 1px black;'>";
        echo "
        <tr>
            <th>id_admin</th>
            <th>username</th>
            <th>email</th>
            <th>nombre_completo</th>
            <th>rol</th>
            <th>fecha_creacion</th>
            <th>ultimo_acceso</th>
        </tr>";
    
        class TableRows extends RecursiveIteratorIterator {
            function __construct($it) {
                parent::__construct($it, self::LEAVES_ONLY);
            }
        
            function current() {
                return "<td style='border: 1px solid black;'>" . parent::current(). "</td>";
            }
        
            function beginChildren() {
                echo "<tr>";
            }
        
            function endChildren() {
                echo "</tr>" . "\n";
            }
        } 

        $stmt = $conn->prepare("SELECT id_admin, username, email, nombre_completo, rol, fecha_creacion, ultimo_acceso FROM admins WHERE id_admin <> :id");
        $stmt->bindParam(':id', $_SESSION['admin_id']);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
            echo $v;
        }
        echo "</table>";
    }
?>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>

    <a href="admin_logout.php">cerrar sesion</a>
    <footer>
        &copy; 2010-<?php echo date("Y");?>
    </footer>
</body>
</html>