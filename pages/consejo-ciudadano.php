<?php
    $jsInitPath = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $initPath = '';
        $jsInitPath = $_POST['initPath'];
    }

    include_once $jsInitPath . 'php/db_connect.php';
    include_once $jsInitPath . 'php/utilities.php';
?>
<h1>Consejo Ciudadano</h1>
<div class="container-consejo">
    
    <div class="img-container">
            <img src="resources/img/consejo ciudadano.png" alt="Documentos Consejo" class="documentos-img">
    </div>
    
<div class="links-consejo">
    
    <div class="texto-consejo">
        <h2>Actas de sesion</h2>
    <a href="https://radio.uaa.mx/wp-content/uploads/2021/07/Ley-Organica-UAA.pdf" class="enlace-pdf">
        <div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/pdf.svg", ["20px", "20px", "black"]) ?></div>
        <!-- <img src="resources/img/svg/file pdf.svg" alt="PDF" class="icono-pdf"> -->
                    Consultar actas de sesión        
    </a>
    </div>

        <div class="texto-consejo">
            <h2>Actas de sesion</h2>
        <a href="https://radio.uaa.mx/wp-content/uploads/2021/07/Ley-Organica-UAA.pdf" class="enlace-pdf">
            <!-- <img src="resources/img/svg/file pdf.svg" alt="PDF" class="icono-pdf"> -->
            <div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/pdf.svg", ["20px", "20px", "black"]) ?></div>
                        Consultar informes anuales
        </a>
        </div>


        <div class="texto-consejo">
            <h2>Actas de sesion</h2>

        <a href="https://radio.uaa.mx/wp-content/uploads/2021/07/Ley-Organica-UAA.pdf" class="enlace-pdf">
            <div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/pdf.svg", ["20px", "20px", "black"]) ?></div>
                        Criterios de operación del consejo ciudadano        
        </a>

        <a href="https://radio.uaa.mx/wp-content/uploads/2021/07/Ley-Organica-UAA.pdf" class="enlace-pdf">
            <div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/pdf.svg", ["20px", "20px", "black"]) ?></div>
                        Criterios para asegurar independencia y una política editorial imparcial y objetiva        
        </a>

        <a href="https://radio.uaa.mx/wp-content/uploads/2021/07/Ley-Organica-UAA.pdf" class="enlace-pdf">
            <div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/pdf.svg", ["20px", "20px", "black"]) ?></div>
                        Reglas para la expresión de diversidades ideológicas, étnicas y culturales        
        </a>

        <a href="https://radio.uaa.mx/wp-content/uploads/2021/07/Ley-Organica-UAA.pdf" class="enlace-pdf">
            <div class="icon"><?php echo GetSVG($jsInitPath."resources/img/svg/pdf.svg", ["20px", "20px", "black"]) ?></div>
                        Mecanismos para garantizar la participación ciudadana a fin de atender las inquietudes y propuestas de las audiencias        
        </a>
        </div>

        
    </div>
    
    </div>
    
    <div class="texto-consejo">
        <h3>¿Qué es el consejo ciudadano?</h3>
    <p>
        El Consejo Ciudadano de Radio Universidad de Aguascalientes XHUAA 94.5 FM, es un órgano de consulta, análisis
        y participación ciudadana que coadyuvará con la radiodifusora universitaria en su funcionamiento, a efecto de
        lograr la independencia editorial y la expresión de diversidades ideológicas, étnicas y culturales.
    </p>
    <p>
        Sus integrantes contarán con la facultad de opinar y asesorar en las acciones, políticas, programas y proyectos
        que desarrolle la emisora de Radio. El Consejo Ciudadano estará conformado por un Presidente, un Secretario y un Vocal.
        Dichos cargos serán conferidos a sus integrantes por un periodo de un año. Los Consejeros formarán parte de este Órgano,
        por un lapso máximo de tres años, sin derecho a reelección y desempeñarán su cargo de manera honorífica.
    </p>
    </div>
    


    <div class="consejo-integrantes">
        <div class="integrante">
            <img src="resources/img/Foto1.png" alt="Imagen Presidente" class="integrante-img">
            <div>
                <h2>Lic. Mario Gerardo de Ávila - Presidente</h2>
                <p>
                    Egresado de la Licenciatura en Medio Masivo de Comunicación (1985-1990) por la Universidad Autónoma de Aguascalientes, donde inició su trayectoria en 1987 como colaborador de la Radio Universitaria.
                </p>
                <p>
                    Entre 1990 y 2010, trabajó como camarógrafo, operador de audio, guionista y productor en el Departamento de Videoproducción de la Dirección General de Difusión. Además, impulsó áreas de producción audiovisual en el INEGI.
                </p>
                <p>
                    Fue director de producción en el canal independiente CV+TV Canal 20 (2008-2010) y formó parte del equipo fundador del Canal de Televisión de la Universidad Autónoma de Aguascalientes, donde fue jefe de Televisión en dos periodos (2010-2012 y 2018-2020).
                </p>
                <p>
                    Tras 35 años de servicio, se retiró en 2020. Ha colaborado en libros, periódicos y revistas.
                </p>
            </div>
        </div>
    
        <div class="integrante">
            <img src="resources/img/Foto2.png" alt="Imagen Secretario" class="integrante-img">
            <div>
                <h2>Lic. Juan Carlos Vázquez - Secretario</h2>
                <p>Egresado de la licenciatura en Comunicación Medios Masivos por la UAA (1994-1999), con experiencia activa en medios locales desde 1999, incluyendo RyTA, Radiogrupo, CVMASTV, UAATV y Alberto Viveros Noticias.</p>

<p>Fue la primera voz al aire de la estación 92.7 FM de RyTA el 17 de noviembre de 2000 y recibió el Premio Ángel Fernández 2009 de FEMECRODE como mejor periodista deportivo con menos de diez años en funciones.</p>

<p>Participó como coconductor en la primera emisión de UAATV el 13 de septiembre de 2010 y en la transmisión inaugural del canal el 2 de diciembre del mismo año.</p>

<p>Desde hace nueve años, se especializa en el uso de herramientas digitales para generar contenidos informativos en diversas plataformas.</p>

            </div>
        </div>
    
        <div class="integrante">
            <img src="resources/img/Foto3.png" alt="Imagen Vocal" class="integrante-img">
            <div>
                <h2>Lic. Rebeca Aguilera - Vocal</h2>
                <p>
                    Licenciada en Comunicación e Información por la Benemérita Universidad Autónoma de Aguascalientes, con 15 años de experiencia en medios locales e internacionales. Actualmente, es reportera de información general en el periódico *El Sol del Centro*.
                </p>
                <p>
                    Comenzó su carrera a los 17 años en estaciones de Radio Universal y Radio Grupo, destacando en programas como *Lavando Ajeno* y en producciones de RyTA como *Destino Aguascalientes*, *Lotería Musical* y *Escuadrón Musical*, con alcance internacional en Mexicanal.
                </p>
                <p>
                    Es actriz y entre los diversos grupos en que ha participado resalta Callejuelas Teatro donde lleva 11 años de participación interpretando 13 de los 15 papeles femeninos a desempeñar en el concepto del grupo. En el ámbito periodístico, colaboró en *Periódico Picacho* y *El Heraldo de Aguascalientes*. Estudió una especialidad en Cine y Comunicación Audiovisual en la Universidad de Viña del Mar y trabajó como locutora en UCV radio en Chile.
                </p>
                <p>
                    Es coach de voz, creadora de los cursos *Soy Mi Voz* y *El Poder de mi Voz*, y capacitadora de candidatas de certámenes de belleza y figuras políticas. Además, dirige *Agencia RA Entertainment*, su propia marca de skincare *Ámate*, y la boutique *DiSueñArte*.
                </p>
           </div>
        </div>
    </div>
    