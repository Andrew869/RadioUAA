<?php
    $jsInitPath = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $initPath = '';
        $jsInitPath = $_POST['initPath'];
    }

    include_once $jsInitPath . 'php/db_connect.php';
    include_once $jsInitPath . 'php/utilities.php';
?>
<div class="titulo-contacto">
<h1>Contacto</h1>
</div>

<div class="contact-container">
    <div class="texto-contacto">

        <h2><div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/clock.svg", ["20px", "20px", "black"]) ?></div> Horario de Oficina</h2>
        <p>Lunes a viernes de 8:00 hrs a 15:30 hrs</p>

        <h2><div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/envelope.svg", ["20px", "20px", "black"]) ?></div> Correo Electrónico</h2>
        <a href="/quejas-sugerencias" class="new-boton internal-link">
        <div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/pdf.svg", ["20px", "20px", "black"]) ?></div>
            Comunica tus Quejas y Sugerencias Aquí.</a>
    
        <h2><div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/phone.svg", ["20px", "20px", "black"]) ?></div> Telefonos</h2>
        <p>449-9-10-74-55 <br>449-9-10-74-59</p>

        <h2><div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/location.svg", ["20px", "20px", "black"]) ?></div> Dirección</h2>
        <p>Av. Universidad #940, Ciudad Universitaria</p> 
        <p>C.P. 20100 Aguascalientes, Ags. México</p>
        <p><b>Edificio 14, Unidad «José Dávila Rodríguez»</b></p>

    </div>

    <!-- Add your image here -->
    <div class="imagen-container">
        <img src="resources/img/radiouaa.jpg" alt="" />
    </div>
</div>

<div class="map-container">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3701.489300716953!2d-102.31544110000002!3d21.915733299999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8429ef1d8785c705%3A0x8bc11629b865eeec!2sEdificio%2014%20Radio%20UAA!5e0!3m2!1ses-419!2smx!4v1728190559481!5m2!1ses-419!2smx"
        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
