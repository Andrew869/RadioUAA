<?php
    class SQL{
        public static $conn = NULL;
        public static $stmt = NULL;
        
        public static $servername = "localhost";
        public static $username = "root";
        public static $password = "";
        public static $dbname='radio_db';

        const NULL = "null";
        const ALL = "*";
        const NONE = "";
        const ASCENDANT = "ASC";
        const DESCENDANT = "DESC";

        const SELECT = "0";
        const CREATE = "1";
        const UPDATE = "2";
        const DELETE = "3";

        const GENERO = "genero";
        const HORARIO = "horario";
        const PRESENTADOR = "presentador";
        const PROGRAMA = "programa";
        const USER = "user";
        const PROGRAMA_PRESENTADOR = "programa_presentador";
        const PROGRAMA_GENERO = "programa_genero";


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

        public static function GetFields($table_name): array{
            $field_names = [];
            $sql = "SHOW COLUMNS FROM $table_name";
            self::$stmt = self::$conn->query($sql);
            while($row = self::$stmt->fetch(PDO::FETCH_ASSOC)){
                $field_names[] = $row['Field'];
            }
            return $field_names;
        }

        public static function Select($table_name, $wheres = [], $fields = [], $order_by = self::NONE, $order_type = self::ASCENDANT){
            $length = count($fields);
            $tmp = ($length > 0 ? ' ' : " * ");
            for ($i = 0; $i < $length; $i++) { 
                if($i < $length-1)
                    $tmp .= $fields[$i] . ', ';
                else 
                    $tmp .= $fields[$i] . ' ';
            }
            // $id = "id_" . $table_name;
            // $where = (count($keys)) ? " WHERE $key_name = '$key' " : "";
            $where = "";
            if(count($wheres)){
                $where = " WHERE";
                foreach ($wheres as $key => $value) {
                    $where .= " $key = '$value'";
                    if(array_key_last($wheres) !== $key){
                        $where .= " AND";
                    }
                }
            }
            $order = ($order_by === self::NONE) ? "" : " ORDER BY $order_by $order_type";
            $sql = 'SELECT' . $tmp . 'FROM ' . $table_name . $where . $order;
            // echo $sql . "<br>";
            self::$stmt = self::$conn->prepare($sql);
            self::$stmt->execute();
            return self::$stmt;
        }

        public static function Create($table_name, $record) : int{
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
                case self::PROGRAMA_PRESENTADOR:
                    $sql .= self::PROGRAMA_PRESENTADOR . " (id_programa, id_presentador)";
                    break;
                case self::PROGRAMA_GENERO:
                    $sql .= self::PROGRAMA_GENERO . " (id_programa, id_genero)";
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
            return self::$conn->lastInsertId();
        }

        public static function Update($table_name, $primary_key, $fields){
            $text_fields = "";
            $lastKey = array_key_last($fields);
            foreach ($fields as $key => $value) {
                if($key === "password_hash") $value = hash('sha256', $value);
                if($value !== self::NULL) $value = "'$value'";
                $text_fields .= "$key = $value" . ($key === $lastKey ? "" : ", " );
            }
            $id = "id_" . $table_name;
            $sql = "UPDATE $table_name SET $text_fields WHERE $id = '$primary_key'";
            self::$stmt = self::$conn->prepare($sql);
            self::$conn->exec($sql);
        }

        public static function GetPrimaryKeyName($table_name) : string{
            $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = '$table_name' AND CONSTRAINT_NAME = 'PRIMARY' AND TABLE_SCHEMA = 'radio_db'";
            self::$stmt = self::$conn->query($sql);
            return self::$stmt->fetchColumn();
        }

        public static function GetCurrentIdIndex($table_name, $id_name) : int{
            $sql = "SELECT MAX($id_name) AS max_id FROM $table_name";
            self::$stmt = self::$conn->query($sql);
            // return (int)self::$stmt->fetch(PDO::FETCH_ASSOC)['max_id'];
            return (int)self::$stmt->fetchColumn();
        }

        public static function GetEnumValues($table_name, $id_name) : array{
            $sql = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$id_name' AND TABLE_SCHEMA = 'radio_db'";
            self::$stmt = self::$conn->query($sql);
            $result = self::$stmt->fetch(PDO::FETCH_ASSOC);
                
            // Extraer los valores del ENUM
            $enumList = str_replace("enum('", "", $result['COLUMN_TYPE']);
            $enumList = str_replace("')", "", $enumList);
            $enumValues = explode("','", $enumList);
            
            return $enumValues;
        }

        public static function Delete($table_name, $primary_key){
            // $id = "id_" . $table_name;
            if($table_name === self::PROGRAMA){
                self::Delete(self::HORARIO, $primary_key);
                self::Delete(self::PROGRAMA_PRESENTADOR, $primary_key);
                self::Delete(self::PROGRAMA_GENERO, $primary_key);
                // Borrar imagen
                $image_path = self::Select(self::PROGRAMA, self::GetPrimaryKeyName(self::PROGRAMA), $primary_key, ["url_imagen"])->fetchColumn();
                if(file_exists($image_path)) unlink($image_path);
            } 
            $id_name = self::GetPrimaryKeyName(($table_name === self::HORARIO ? SQL::PROGRAMA : $table_name));
            $sql = "DELETE FROM $table_name WHERE $id_name = '$primary_key'";
            echo $sql . "<br>";
            self::$stmt = self::$conn->prepare($sql);
            self::$conn->exec($sql);
            
            // if(self::PROGRAMA_PRESENTADOR)
            $next_id = self::GetCurrentIdIndex($table_name, $id_name) + 1;
            $sql = "ALTER TABLE $table_name AUTO_INCREMENT = $next_id";
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