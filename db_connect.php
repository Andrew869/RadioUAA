<?php
    class SQL{
        public static $conn = NULL;
        public static $stmt = NULL;
        
        public static $servername = "localhost";
        public static $username = "root";
        public static $password = "";
        public static $dbname='radio_db';

        CONST NULL = "null";

        const SELECT = "0";
        const CREATE = "1";
        const UPDATE = "2";
        const DELETE = "3";

        const GENERO = "genero";
        const HORARIO = "horario";
        const PRESENTADOR = "presentador";
        const PROGRAMA = "programa";
        const USER = "user";

        function __construct($asf){
            echo "hello world $asf" . "<br>";
        }

        function __destruct(){
            echo "bye world :'(";
        }

        public static function Connect(){
            $dsn = 'mysql:host=' . self::$servername . ';dbname=' . self::$dbname . ';charset=utf8mb4';
            try {
                self::$conn = new PDO($dsn, self::$username, self::$password);
                // set the PDO error mode to exception
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo "Connected successfully";
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                exit();
            }
        }

        public static function Select($table_name, $primary_key, ...$fields){
            $length = count($fields);
            $tmp = ($length > 0 ? ' ' : " * ");
            for ($i = 0; $i < $length; $i++) { 
                if($i < $length-1)
                    $tmp .= $fields[$i] . ', ';
                else 
                    $tmp .= $fields[$i] . ' ';
            }
            $id = "id_" . $table_name;
            $sql = 'SELECT' . $tmp . 'FROM ' . $table_name . ' WHERE ' . $id . ' = ?';
            // echo $sql . "<br>";
            self::$stmt = self::$conn->prepare($sql);
            self::$stmt->execute([$primary_key]);
            return self::$stmt;
        }

        public static function Create($table_name, $post){
            array_pop($post);
            $record = array_values($post);
            $length = count($record);
            
            foreach ($record as $key => $value) {
                $record[$key] = '\'' . $value . '\'';
            }
            
            $sql = "INSERT INTO ";
            switch ($table_name) {
                case self::GENERO:
                    $sql .= self::GENERO . " (nombre_genero)";
                    break;
                case self::HORARIO:
                    $sql .= self::HORARIO . " (id_programa, dia_semana, hora_inicio, hora_fin, es_retransmision)";
                    break;
                case self::PRESENTADOR:
                    $sql .= self::PRESENTADOR . " (nombre_presentador, biografia, url_foto)";
                    break;
                case self::PROGRAMA:
                    $sql .= self::PROGRAMA . " (nombre_programa, url_imagen, descripcion)";
                    break;
                case self::USER:
                    $sql .= self::USER . " (username, email, password_hash, nombre_completo, rol, cuenta_activa)";
                    $record[2] = 'SHA2(' . $record[2] . ', 256)';
                    break;
            }
            
            $sql_values = "VALUES (";
            for ($i=0; $i < $length; $i++) { 
                if($i < $length-1)
                    $sql_values .= $record[$i] . ', ';
                else 
                    $sql_values .= $record[$i] . ')';
            }
            $sql .= $sql_values;
            // echo $sql;
            self::$conn->exec($sql);
        }

        public static function Update($table_name, $primary_key, $key, $value){
            if($key === "password_hash") $value = hash('sha256', $value);
            if($value !== self::NULL) $value = "'$value'";
            // echo $value;
            $id = "id_" . $table_name;
            $sql = "UPDATE $table_name SET $key = $value WHERE $id = '$primary_key'";
            // echo $sql . "<br>";
            self::$stmt = self::$conn->prepare($sql);
            self::$conn->exec($sql);
        }

        public static function Delete($table_name, $primary_key){
            $id = "id_" . $table_name;
            $sql = "DELETE FROM $table_name WHERE $id = '$primary_key'";
            echo $sql . "<br>";
            self::$stmt = self::$conn->prepare($sql);
            self::$conn->exec($sql);

            $sql = "SELECT MAX(id_user) AS max_id FROM user";
            self::$stmt = self::$conn->query($sql);
            // accedemos a la key max_id del arreglo que arroja la funcion fetch(), despues lo convertimos a entero y por ultimo le sumamos 1
            $max_id = (int)self::$stmt->fetch(PDO::FETCH_ASSOC)['max_id'] + 1;
            $sql = "ALTER TABLE user AUTO_INCREMENT = " . $max_id;
            $stmt = self::$conn->exec($sql);
        }
    }
    // $clase = new SQL("asd");
    SQL::Connect();
    // SQL::Update(SQL::GENERO, "1", "password_hash", "Admin123");
    // $asd = SQL::Select("user","1")->fetch(PDO::FETCH_ASSOC);
    // foreach ($asd as $key => $value) {
    //     echo "$key -> $value" . "<br>";
    // }
    // $clase = null;
    // SQL::Create(SQL::GENERO, ["nom" => "Kids", "asd"=>"asd"])
?>