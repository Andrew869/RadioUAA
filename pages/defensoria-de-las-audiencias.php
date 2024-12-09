<?php
    $jsInitPath = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $initPath = '';
        $jsInitPath = $_POST['initPath'];
    }

    include_once $jsInitPath . 'php/db_connect.php';
    include_once $jsInitPath . 'php/utilities.php';
?>
<div class="page-content">
<div class="contenido-defensoria-fondo">
    <h1>Defensoría de las Audiencias</h1>

    <img src="/resources/img/defensoria.png" alt="">
</div>
<div class="texto-defensoria">

<h2><div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/gallo-min.svg", ["30px", "30px", "black"]) ?></div>¿Qué es la defensoría de las audiencias?</h2>
<p>
    La defensoría de las audiencias es la vía de comunicación entre nuestra audiencia y el medio,
    por la cual puedas expresar tus comentarios sobre la programación y los contenidos que ofrece Radio
    Universidad, con el objetivo de motivar la participación ciudadana en
    base a los derechos de las audiencias.
</p>
<h2><div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/gallo-min.svg", ["30px", "30px", "black"]) ?></div>¿Cuáles son los derechos de la audiencia?</h2>
<p>
    Puedes revisar los derechos de la audiencia <a class="new-boton internal-link" href="/derechos-de-la-audiencia">Aquí</a>.
</p>

<h2><div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/gallo-min.svg", ["30px", "30px", "black"]) ?></div>¿Quién es el defensor?</h2>

</div>


<section class="contenedor-Lic">
    <div class="texto-defensoria">
        <p>
            A continuación, les presentamos a quien funge actualmente como Defensor de las Audiencias de Radio
            Universidad Autónoma de Aguascalientes.
        </p>
        <p>
            La Dra. Sandra Yesenia Pinzón Castro, rectora de la Universidad Autónoma de Aguascalientes,
            participó en la firma que formalizó el nombramiento del Lic. Heriberto Béjar Méndez como nuevo
            Defensor de las Audiencias.
        </p>
        <p>
            Esta figura, derecho contenido en la Ley Federal de Telecomunicaciones y Radiodifusión desde el 2014,
            se constituye como pieza clave en la preservación, protección y defensa de los derechos de las
            audiencias, por lo que su participación es el principal garante de la funcionalidad de esta figura.
        </p>
        <p>
            La Defensoría de las Audiencias es un espacio de diálogo entre los radioescuchas y Radio UAA con
            el propósito de motivar la participación ciudadana frente a la programación ofrecida por la emisora
            universitaria y para atender las demandas y opiniones que se deriven al respecto. La Dra. Pinzón
            confió en que, con este nombramiento, se procure una atención y una escucha eficiente con la
            audiencia de Radio Universidad, a fin de mejorar los canales de diálogo y ofrecer una programación
            que contribuya al desarrollo de Aguascalientes.
        </p>
    </div>

    
    <div class="defensoria-container">
        <img src="resources/img/licHeriberto.jpeg" alt="">
        <div>Lic. Heriberto Béjar Méndez</div>
    </div>

</section>


<div class="texto-defensoria">

<h2><div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/gallo-min.svg", ["30px", "30px", "black"]) ?></div>Quejas y sugerencias:</h2>
<p>El propósito de Radio Universidad es mantener una comunicación constante y cercana con su audiencia. 
    Por ello, le invitamos a compartir sus comentarios y sugerencias sobre nuestros contenidos, contribuyendo 
    así a mejorar y fortalecer nuestra labor en beneficio de la comunidad.
</p>
<h2><div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/gallo-min.svg", ["30px", "30px", "black"]) ?></div>Pasos para enviar una queja o sugerencia:</h2>
<p>Tiene la posibilidad de expresar sus comentarios, sugerencias o aclaraciones en caso de considerar que se ha 
    visto afectado algún derecho que le corresponde como audiencia. Este espacio está destinado a garantizar la 
    transparencia, atender sus inquietudes y promover una comunicación efectiva entre los usuarios y la organización, y 
    este será publicado en la siguiente página: <a href="/quejas-sugerencias" class="new-boton internal-link">Realizar una queja o sugerencia</a>.
</p>

<h2><div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/gallo-min.svg", ["30px", "30px", "black"]) ?></div>Normatividad:</h2>
<p>Los contenidos, programación, así como su personal y colaboradores de Radio UAA están sujetos a la
    siguiente normatividad interna y externa:
</p>

</div>


<div class="links-defensoria">

<div class="archivo-documentos">
    <a href="resources/docs/Ley-Organica-UAA.pdf">
        <div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/pdf.svg", ["20px", "20px", "black"]) ?></div>
                Ley orgánica de la Universidad Autónoma de Aguascalientes.
    </a>

    <a href="resources/docs/Codigo-de-etica.pdf">
        <div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/pdf.svg", ["20px", "20px", "black"]) ?></div>
                Código de ética.
    </a>

    <a href="resources/docs/Politicas-de-la-Seccion-de-Radio-Universidad.pdf">
        <div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/pdf.svg", ["20px", "20px", "black"]) ?></div>
                Políticas de la Sección de Radio Universidad.
    </a>

    <a href="resources/docs/Ley-federal-de-telecomunicaciones.pdf">
        <div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/pdf.svg", ["20px", "20px", "black"]) ?></div>
                Ley federal de telecomunicaciones.
    </a>
</div>
</div>
</div>