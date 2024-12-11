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
    <div class="texto-transparencia">
        <h1>Transparencia</h1>

        <p>Si deseas información tenemos la siguientes opciones:</p>

        <p><b>Opción 1:</b></p>

        <div class="transparencia-documentos">
            
                <li>1. Ingresa a la página: <a href="https://www.uaa.mx/informacionpublica/">https://www.uaa.mx/informacionpublica/</a></li>
                <li>2. Una vez ahí, selecciona <strong>Sistema SISAI Infomex</strong> la cual te enviará a la plataforma:
                    <a href="http://207.248.118.52/InfomexAguascalientes/">http://207.248.118.52/InfomexAguascalientes/</a>
                </li>
                <li>3. Sigue las instrucciones que se indican.</li>
        </div>

        <p><b>Opción 2:</b></p>

        <p>Envía una solicitud por correo a: <u>transparecia@edu.com.mx</u></p>

        <p><b>Opción 3:</b></p>
        <p>Acude a la Oficina de Transparencia y mediante un oficio de formato libre, presenta solicitud de información que requieras. Esta será registrada en el portal para el seguimiento conforme a la Ley Federal de Transparencia y Acceso a la Información.</p>
        <p>La Oficina de Transparencia de la Universidad Autónoma de Aguascalientes se ubica en Av. Universidad #940 Col. Ciudad Universitaria, Edificio Académico Administrativo Piso 11, CP: 20100, Aguascalientes, Aguascalientes, en horario de oficina; Tel: (449) 910 7400 EXT. 9262</p>
  
        <div class="links-transparencia">
            
            <div class="texto-transparencia">
                <h2>Normatividad</h2>
            <a href="resources/docs/Anexo-I-Ley-Organica-UAA.pdf">
                <div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/pdf.svg", ["20px", "20px", "black"]) ?></div>
                        Anexo I – Ley Orgánica UAA.        
            </a>
            
            <a href="/resources/docs/Anexo-II-Comite-transparencia.pdf">
                <div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/pdf.svg", ["20px", "20px", "black"]) ?></div>
                        Anexo II – Comité transparencia.       
            </a>
            </div>


            <div class="texto-transparencia">
                <h2>Informacion Financiera</h2>

            <a href="resources/docs/Presupuesto-2018.pdf">
                <div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/pdf.svg", ["20px", "20px", "black"]) ?></div>
                        Presupuesto 2018 con salarios.        
            </a>
            </div>

            
        </div>
    </div>
</div>