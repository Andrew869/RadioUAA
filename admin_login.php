<!DOCTYPE HTML>
<html>
    <head>
        <?php include "metaData.php"; ?>
    </head>
<body>
    <?php
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

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname='radio_db';
        
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";
        } catch(PDOException $e) {
            // echo "Connection failed: " . $e->getMessage();
        }

        // hacemos la peticion a la base de datos
        $sql = 'SELECT id_admin, username, email, password_hash, rol FROM admins WHERE username = :username LIMIT 1';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username_input);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && hash_equals($user['password_hash'], hash('sha256', $password_input))) {
            // La contraseña es correcta
            session_start();
            $_SESSION['admin_id'] = $user['id_admin'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_email'] = $user['email'];
            $_SESSION['admin_rol'] = $user['rol'];
        
            // Redirigir al panel de administración
            header('Location: admin_panel.php');
            exit();
        } else {
            // La contraseña o el usuario es incorrecto
            echo 'Nombre de usuario o contraseña incorrectos';
        }
    }

    include "formulario.php";
    ?>

</body>
</html>