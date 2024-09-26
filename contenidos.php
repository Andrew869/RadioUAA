<?php 
    include "db_connect.php";

    class Content extends RecursiveIteratorIterator {
        private $stmt;
        private $primary_key;

        function __construct($table_name) {
            $this->stmt = SQL::Select($table_name, SQL::ALL, SQL::ALL);
            $this->stmt->setFetchMode(PDO::FETCH_ASSOC);
            parent::__construct(new RecursiveArrayIterator($this->stmt->fetchAll()), self::LEAVES_ONLY);
            echo "<div>";
        }

        function current(): mixed {
            switch (parent::key()) {
                case 'id_programa':
                    {
                        $this->primary_key = parent::current();
                        return "";
                    }
                    break;
                case 'nombre_programa':
                    {
                        return '<a href="'. htmlspecialchars($_SERVER["PHP_SELF"]) . "?programa=". $this->primary_key .'" style="display:block;" >' . parent::current() . '</a>';
                    }
                    break;
                case 'url_imagen':
                    {
                        return '<img src="'.parent::current().'" style="display: block;" alt="imagen_programa" width="50" height="50">';
                    }
                    break;
                default:
                    {
                        return parent::current() . "<br>";
                    }
                    break;
            }
        }

        function beginChildren(): void {
            echo "<div>";
        }
    
        function endChildren(): void{
            echo "</div>";
            echo "<br>";
        }

        function endIteration(): void{
            echo "</div>";
        }
    }

    function ShowPrograms(){
        foreach (new Content(SQL::PROGRAMA) as $key => $value) {
            echo $value;
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "metaData.php" ?>
</head>
<body>
<?php
    $length;
    if($length = count(($_GET))){
        if($length > 1){
            ShowPrograms();
        }
        else{
            foreach ($_GET as $key => $value) {
                switch ($key) {
                    case SQL::PRESENTADOR:
                        $presentador = SQL::Select(SQL::PRESENTADOR, 'id_presentador', $value)->fetch(PDO::FETCH_ASSOC);
                        echo $presentador['nombre_presentador'] . "<br>";
                        echo $presentador['biografia'] . "<br>";
                        echo '<img src="'.$presentador['url_foto'].'" style="display: block;" alt="imagen_programa" width="50" height="50">';
                        break;
                    case SQL::PROGRAMA:
                        {
                            // echo "programa";
                            $programa = SQL::Select(SQL::PROGRAMA, "id_programa", $value)->fetch(PDO::FETCH_ASSOC);
                            echo $programa['nombre_programa'] . "<br>";
                            echo '<img src="'.$programa['url_imagen'].'" style="display: block;" alt="imagen_programa" width="50" height="50">';
                            echo $programa['descripcion'] . "<br>";
                            echo "<br>";
                            
                            echo "Horarios: <br>";
                            $horarios = SQL::Select(SQL::HORARIO, "id_programa", $value)->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($horarios as $horario) {
                                echo $horario['dia_semana'] . ($horario['es_retransmision'] ? " (Retrasmision) " : "" ) . "<br>";
                                echo "De " . $horario['hora_inicio'] . " a " . $horario['hora_fin'] . "<br>";
                                echo "<br>";
                            }
                            echo "<br>";
                            
                            echo "presentado por: <br>";
                            $presentadores = SQL::Select(SQL::PROGRAMA_PRESENTADOR, "id_programa", $value, "id_presentador")->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($presentadores as $presentador) {
                                echo '<a href="'. htmlspecialchars($_SERVER["PHP_SELF"]) . "?presentador=". $presentador["id_presentador"] .'">' . SQL::Select(SQL::PRESENTADOR, "id_presentador", $presentador["id_presentador"], "nombre_presentador")->fetchColumn() . '</a> <br>';
                            }
                            echo "<br>";
                            echo "Generos: <br>";
                            $generos = SQL::Select(SQL::PROGRAMA_GENERO, 'id_programa', $value, "id_genero")->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($generos as $genero) {
                                echo SQL::Select(SQL::GENERO, "id_genero", $genero["id_genero"], "nombre_genero")->fetchColumn() . "<br>";
                            }
                        }
                        break;   
                    default:
                        ShowPrograms();
                        break;
                }
            }
        } 
    }
    else{
        ShowPrograms();
    }
    // echo "EOP";
    ?>
    <!-- <form action="<?php //$_SERVER["PHP_SELF"] ?>">
        <input type="color" name="color" id="">
        <input type="submit" value="asd">
    </form> -->
</body>
</html>