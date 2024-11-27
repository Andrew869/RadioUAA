<?php
    $jsInitPath = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $initPath = '';
        $jsInitPath = $_POST['initPath'];
    }

    include_once $jsInitPath . 'php/db_connect.php';
    include_once $jsInitPath . 'php/utilities.php';
?>
<h1>POLÍTICA DE PRIVACIDAD</h1>
<div class="texto-politica">
<p>
    Por medio de nuestra política de privacidad le ponemos al tanto de las debidas condiciones de uso 
    en este sitio. La utilización de estos implica su aceptación plena y sin reservas a todas y cada 
    una de las disposiciones incluidas en este Aviso Legal, por lo que si usted no está de acuerdo con 
    cualquiera de las condiciones aquí establecidas, no deberá usar y/o acceder a este sitio. Reservamos
    el derecho a modificar esta Declaración de Privacidad en cualquier momento. Su uso continuo de 
    cualquier porción de este sitio tras la notificación o anuncio de tales modificaciones constituirá 
    su aceptación de tales cambios.
</p>

<h2><div class="icon"><div class="icon"><div class="icon"><div class="icon"><div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/gallo-min.svg", ["30px", "30px", "black"]) ?></div></div></div></div></div>Cookies</h2>

<p>
    Este sitio hace uso de cookies, el cual son pequeños ficheros de datos que se generan en su ordenador, 
    este envía información sin proporcionar referencias que permitan deducir datos personales de este. 
    Usted podrá configurar su navegador para que notifique y rechace la instalación de las cookies enviadas 
    por este sitio, sin que ello perjudique la posibilidad de acceder a los contenidos. Sin embargo, no nos 
    responsabilizamos de que la desactivación de los mismos impida el buen funcionamiento del sitio.
</p>

<h2><div class="icon"><div class="icon"><div class="icon"><div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/gallo-min.svg", ["30px", "30px", "black"]) ?></div></div></div></div>Marcas Web o Web Beacons</h2>

<p>
    Al igual que las cookies este sitio también puede contener web beacons, un archivo electrónico gráfico 
    que permite contabilizar a los usuarios que acceden al sitio o acceden a determinadas cookies del mismo, 
    de esta manera, podremos ofrecerle una experiencia aún más personalizada.
</p>

<h2><div class="icon"><div class="icon"><div class="icon"><div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/gallo-min.svg", ["30px", "30px", "black"]) ?></div></div></div></div>Política de protección de datos personales</h2>

<p>Para utilizar algunos de los servicios o acceder a determinados contenidos, deberá proporcionar previamente 
    ciertos datos de carácter personal, que solo serán utilizados para el propósito que fueron recopilados. 
    El tipo de la posible Información que se le sea solicitada incluye, de manera enunciativa más no limitativa, 
    su nombre, dirección de correo electrónico (e-mail), fecha de nacimiento, sexo, ocupación, país y ciudad de 
    origen e intereses personales, entre otros, no toda la Información solicitada al momento de participar en 
    el sitio es obligatoria de proporcionarse, salvo aquella que consideremos conveniente y que así se le haga 
    saber. Cómo principio general, este sitio no comparte ni revela información obtenida, excepto cuando haya 
    sido autorizada por usted, o en los siguientes casos: a) Cuando le sea requerido por una autoridad competente 
    y previo el cumplimiento del trámite legal correspondiente y b) Cuando a juicio de este sitio sea necesario 
    para hacer cumplir las condiciones de uso y demás términos de esta página, o para salvaguardar la integridad 
    de los demás usuarios o del sitio. Deberá estar consciente de que si usted voluntariamente revela información 
    personal en línea en un área pública, esa información puede ser recogida y usada por otros. Nosotros no 
    controlamos las acciones de nuestros visitantes y usuarios.
</p>

<h2><div class="icon"><div class="icon"><div class="icon"><div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/gallo-min.svg", ["30px", "30px", "black"]) ?></div></div></div></div>Conducta responsable</h2>

<p>
    Toda la información que facilite deberá ser veraz. A estos efectos, usted garantiza la autenticidad de todos 
    aquellos datos que comunique como consecuencia de la cumplimentación de los formularios necesarios para la 
    suscripción de los Servicios, acceso a contenidos o áreas restringidas del sitio. En todo caso usted será el 
    único responsable de las manifestaciones falsas o inexactas que realice y de los perjuicios que cause a este
    sitio o a terceros por la información que facilite. Usted se compromete a actuar en forma responsable en este 
    sitio y a tratar a otros visitantes con respeto.
</p>

<h2><div class="icon"><div class="icon"><div class="icon"><div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/gallo-min.svg", ["30px", "30px", "black"]) ?></div></div></div></div>Contacto</h2>

<p class="lista-op">
    Si tiene preguntas o cuestiones sobre esta Política, no dude en contactarse en cualquier momento a través del
    <a class="/internal-link" href="quejas-sugerencias">formulario de contacto</a>
</p>

</div>