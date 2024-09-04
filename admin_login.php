<?php
    session_start();
    date_default_timezone_set("America/Mexico_City");

    if(isset($_SESSION['admin_id'])){
        header('Location: admin_panel.php');
        exit();
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    $username_input = $password_input = "";
    $userErr = $passwdErr = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST["username"])) {
            $userErr = "Se requiere nombre de usuario!";
        } else {
            $username_input = test_input($_POST["username"]);
            if (!preg_match("/^[a-zA-Z0-9]*$/", $username_input)) {
                $userErr = "Solo letras y números permitidos!";
            }
        }
        
        if (empty($_POST["password"])) {
            $passwdErr = "Se requiere contraseña!";
        } else {
            $password_input = test_input($_POST["password"]);
        }

        include "db_connect.php";

        // hacemos la peticion a la base de datos (Limit 1 indica cuantos resultados esperas)
        $sql = 'SELECT id_admin, username, email, password_hash, rol, ultimo_acceso FROM admins WHERE username = :username LIMIT 1';
        
        $stmt = $conn->prepare($sql);
        // agrega el valor de $username al parametro :username que se encuentra en el codigo sql
        $stmt->bindParam(':username', $username_input);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && hash_equals($user['password_hash'], hash('sha256', $password_input))) {
            // La contraseña es correcta
            $_SESSION['admin_id'] = $user['id_admin'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_email'] = $user['email'];
            $_SESSION['admin_rol'] = $user['rol'];
            $_SESSION['admin_ultimo_acceso'] = $user['ultimo_acceso'];

            // modifica el ultimo acceso
            $sql = 'UPDATE admins SET ultimo_acceso = :ultimo_acceso WHERE username = :username LIMIT 1';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':ultimo_acceso', date("Y-m-d H:i:s"));
            $stmt->bindParam(':username', $username_input);
            $stmt->execute();

            // Redirigir al panel de administración
            header('Location: admin_panel.php');
            exit();
        } else {
            // La contraseña o el usuario es incorrecto
            echo 'Nombre de usuario o contraseña incorrectos';
        }
        $conn = null;
    }

?>
<!DOCTYPE HTML>
<html>
    <head>
        <?php include "metaData.php"; ?>
    </head>
<body>
    <?php
        include "formulario.php";
    ?>
</body>
</html>