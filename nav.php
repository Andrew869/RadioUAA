<nav>
<?php
    function printMenu($opciones){
        echo "<ul>";
        foreach ($opciones as $key => $value) {
            // Si el valor es un arreglo, imprimimos la clave y luego llamamos a la función de nuevo para imprimir la sublista.
            if (is_array($value)) {
                echo '<li class="option">' .$key. '</li>';
                printMenu($value);
            }else
                echo '<li class="option"><a href="' .$value. '">' .$key. '</a></li>';
        }
        echo "</ul>";
    }

    $opciones = [
        "Inicio" => "index.php",
        "Nosotros" => [
            "Acerca de Radio UAA" => "#",
            "Preguntas Frecuentes" => "#",
            "Consejo Ciudadano" => "#"
        ],
        "Defensoria" => [
            "opcion1" => "#",
            "opcion2" => "#",
            "opcion3" => "#"
        ],
        "programacion" => "programacion.php",
        "Contenidos" => "#",
        "Contacto" => "#"
    ];
    

    printMenu($opciones);
?>
</nav>