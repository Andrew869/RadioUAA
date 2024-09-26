<?php
    session_start();
    date_default_timezone_set("America/Mexico_City");

    if(isset($_SESSION['id_user'])){
        header('Location: admin_panel.php');
        exit();
    }

    function test_input($data, $is_password = FALSE) {
        if(!$is_password){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
        } 
        return $data;
    }
    
    $username_input = $password_input = "";
    $userErr = $passwdErr = $overallErr = "-";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST["username"])) {
            $userErr = "Se requiere nombre de usuario";
        } else {
            $username_input = test_input($_POST["username"]);
            if (!preg_match("/^[a-zA-Z0-9]*$/", $username_input)) {
                $userErr = "Solo letras y números permitidos!";
            }
        }
        
        if (empty($_POST["password"])) {
            $passwdErr = "Se requiere contraseña";
        } else {
            $password_input = test_input($_POST["password"], TRUE);
        }

        include "db_connect.php";
        
        $user = SQL::Select(SQL::USER, "username", $username_input)->fetch(PDO::FETCH_ASSOC);
        
        if(!$user)
            $overallErr = 'Nombre de usuario o contraseña incorrectos';
        else
            if (hash_equals($user['password_hash'], hash('sha256', $password_input))) {
                if($user['cuenta_activa']){
                    foreach ($user as $key => $value) {
                        $_SESSION[$key] = $value;
                    }
                    
                    $token = bin2hex(random_bytes(16));
                    $_SESSION['session_token'] = $token;
                    setcookie("session_token", $token, time() + 60 * (30) , "/", "", false, true);

                    SQL::Update(SQL::USER, $user['id_user'], ["ultimo_acceso" => date("Y-m-d H:i:s"), "session_token" => $token]); // modifica el ultimo acceso y añadiendo el token
                    
                    header('Location: admin_panel.php'); // Redirigir al panel de administración
                    exit();
                }
                else
                    $overallErr = 'Cuenta inactiva';
            } else {
                // La contraseña o el usuario es incorrecto
                $overallErr = 'Nombre de usuario o contraseña incorrectos';
            }
            SQL::$conn = null;
    }

?>
<!DOCTYPE HTML>
<html>
    <head>
        <?php include "metaData.php"; ?>
        <link rel="stylesheet" href="css/styleLogin.css">
    </head>
<body>
    <div class="login">
        <h2>Radio UAA</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="output_err" ><?php echo "$userErr";?></div>
            <div class="input_box">
                <!-- <label for="username">Username</label> -->
                <input type="text" id="username" name="username" placeholder="Username" value="<?php echo $username_input;?>" required>
            </div>
            <div class="output_err"><?php echo "$passwdErr";?></div>
            <div class="input_box">
                <!-- <label for="password">Password</label> -->
                <input type="password" id="password" name="password" placeholder="Password" required>
                <label for="toggle_pass" id="label_toggle"><svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path id="svg_path" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg></label>
                <input type="checkbox" id="toggle_pass" onclick="showPass()">
            </div>
            <div class="output_err"><?php echo "$overallErr";?></div>
            <div class="input_box">
                <input type="submit" name="submit" value="Login">  
            </div>
            <div class="forget_link">
                    <a href="#">Forget Password</a>
            </div>
        </form>
    </div>
    <script src="js/loginManager.js"></script>
	<script src="https://kit.fontawesome.com/9b86802e8e.js" crossorigin="anonymous"></script>
</body>
</html>