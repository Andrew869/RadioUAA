<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname='my_database';

    $username_input = $_POST['username'];
    $password_input = $_POST['password'];

    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
        echo "$POST['user']";
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>