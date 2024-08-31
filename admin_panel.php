<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "metaData.php"; ?>
</head>
<body>
<?php
    session_start();
    echo "Acceso permitido!<br>";

    echo "ID: " .$_SESSION['admin_id']. "<br>";
    echo "Username: " .$_SESSION['admin_username']. "<br>";
    echo "Eamil: " .$_SESSION['admin_email']. "<br>";
    echo "Rol: " .$_SESSION['admin_rol']. "<br>";
?>  
</body>
</html>