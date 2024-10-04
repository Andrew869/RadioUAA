<?php
    date_default_timezone_set("America/Mexico_City");
    $until = strtotime("december 2");
    $remaining = abs(ceil(($until-time())/60/60/24));
    $percentage = $remaining * 100 / 90;
    echo '<code class="days-left">Days Left: <span class="'
    .(($percentage >= 66)? "text-success" : (($percentage >= 33)? "text-warning" : "text-danger")).
    '">' . $remaining ."</span></code>";
?>
<nav>
    <input type="checkbox" name="" id="check">
    <label for="check" class="checkbtn">
    <i class="fa-solid fa-bars"></i>
    </label>
    <a href="" class="enlace"><img src="img/logo_radio_uaa.png" alt="" class="logo"></a>
    <ul class ="nav-links">
        <li><a href="">inicio</a></li>
        <li><a href="">nosotros</a></li>
        <li><a href="">defensoria</a></li>
        <li><a href="">programacion</a></li>
        <li><a href="contenidos">contenidos</a></li>
        <li><a href="">contacto</a></li>
    </ul>
    <label for="toggle" id="label_toggle"><i class="fa-solid fa-moon"></i></label>
    <input type="checkbox" id="toggle">
</nav>