<?php
    class SQL{
        public static $conn = NULL;
        public static $stmt = NULL;
        
        public static $servername = "localhost";
        public static $username = "root";
        public static $password = "";
        public static $dbname='radio_dbv2';

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

        const TEXT = "text";
        const PASSWORD = "password";
        const IMAGE = "image";
        const FILE = "file";
        const DATE = "date";
        const TIME = "time";
        const BOOLEAN = "boolean";
        const ENUM = "enum";
        const LIST = "list";

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
            $blackList = [
                self::USER => [7,8,9]
            ];

            $field_names = [];
            $sql = "SHOW COLUMNS FROM $table_name";
            self::$stmt = self::$conn->query($sql);
            while($row = self::$stmt->fetch(PDO::FETCH_ASSOC)){
                $field_names[] = $row['Field'];
            }
            if(isset($blackList[$table_name]))
                foreach ($blackList[$table_name] as $value) {
                    unset($field_names[$value]);
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

        public static function GetFieldType($table_name, $field){
            // $sql = "SELECT COLUMN_NAME, DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$field'";
            $sql = "SELECT DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$field'";
            self::$stmt = self::$conn->query($sql);
            return self::$stmt->fetchColumn();
        }

        public static function FormatValue($table_name, $fieldName, $value) : string{
            switch (self::GetFieldType($table_name, $fieldName)) {
                case 'varchar':
                case 'char':
                case 'text':
                case 'date':
                case 'time':
                case 'datetime':
                case 'timestamp':
                case 'enum':
                case 'json':
                case 'uuid':
                    $value = '\'' . $value . '\'';
                    // $record[$i] = '\'' . $record[$i] . '\'';
                    break;
            }
            return $value;
        }

        public static function Create($table_name, $record) : array{
            $fields = self::GetFields($table_name);
            if($table_name !== SQL::PROGRAMA_PRESENTADOR && $table_name !== SQL::PROGRAMA_GENERO){
                array_shift($fields);
            }

            $length = count($record);
            $name = $record[0];
            for ($i = 0; $i < $length; $i++) {
                $record[$i] = self::FormatValue($table_name, $fields[$i], $record[$i]);
            }

            $sql = "INSERT INTO $table_name ";
            $str_fields = '(';
            for ($i = 0; $i < $length; $i++) { 
                if($i < $length-1)
                    $str_fields .= $fields[$i] . ', ';
                else 
                    $str_fields .= $fields[$i] . ')';
            }
            $sql .= $str_fields;

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

            $contentValues = [
                "id" => self::$conn->lastInsertId(),
                "name" => $name
            ];

            // return self::$conn->lastInsertId();
            return $contentValues;
        }

        public static function Update($table_name, $primary_key, $fields){
            $text_fields = "";
            $lastKey = array_key_last($fields);
            foreach ($fields as $key => $value) {
                if($key === "password_hash") $value = hash('sha256', $value);
                if($value !== self::NULL) $value = self::FormatValue($table_name, $key, $value);
                $text_fields .= "$key = $value" . ($key === $lastKey ? "" : ", " );
            }
            // $id = "id_" . $table_name;
            $id = self::GetPrimaryKeyName($table_name);
            $sql = "UPDATE $table_name SET $text_fields WHERE $id = '$primary_key'";

            try {
                self::$stmt = self::$conn->prepare($sql);
                self::$conn->exec($sql);
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage() . $sql;
                exit();
            }

        }

        public static function GetPrimaryKeyName($table_name) : string{
            $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = '$table_name' AND CONSTRAINT_NAME = 'PRIMARY' AND TABLE_SCHEMA = '" . self::$dbname . "'";
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
            $sql = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$id_name' AND TABLE_SCHEMA '" . self::$dbname . "'";
            self::$stmt = self::$conn->query($sql);
            $result = self::$stmt->fetch(PDO::FETCH_ASSOC);
                
            // Extraer los valores del ENUM
            $enumList = str_replace("enum('", "", $result['COLUMN_TYPE']);
            $enumList = str_replace("')", "", $enumList);
            $enumValues = explode("','", $enumList);
            
            return $enumValues;
        }

        public static function Delete($table_name, $wheres = []){
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

            $id_name = self::GetPrimaryKeyName(($table_name === self::HORARIO ? SQL::PROGRAMA : $table_name));
            // $sql = "DELETE FROM $table_name WHERE $id_name = '$primary_key'";
            $sql = "DELETE FROM $table_name" . $where;
            // return;
            self::$stmt = self::$conn->prepare($sql);
            self::$conn->exec($sql);
            
            // if(self::PROGRAMA_PRESENTADOR)
            $next_id = self::GetCurrentIdIndex($table_name, $id_name) + 1;
            $sql = "ALTER TABLE $table_name AUTO_INCREMENT = $next_id";
            $stmt = self::$conn->exec($sql);
        }
    }
    
    SQL::Connect();

    function ToMinutes($time) {
        // Convierte el formato HH:MM en minutos totales desde la medianoche
        list($hours, $minutes) = explode(':', $time);
        return ($hours * 60) + $minutes;
    }
?>