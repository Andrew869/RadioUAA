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

    $userErr = $passwdErr = "";
    $user = $passwd = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["user"])) {
            $userErr = "User is required";
        } else {
            $user = test_input($_POST["user"]);
            
            if (!preg_match("/^[a-zA-Z-]*$/", $user)) {
                $userErr = "Only letters allowed!";
            }
        }
        
        if (empty($_POST["passwd"])) {
            $passwdErr = "password is required!";
        } else {
            $passwd = test_input($_POST["passwd"]);
        }
    }

    include "formulario.php";

    echo "<h2>Your Input:</h2>";
    echo $user;
    echo "<br>";
    echo $passwd;
    echo "<br>";
    ?>

</body>
</html>