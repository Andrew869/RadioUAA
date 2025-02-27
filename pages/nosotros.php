<h1>Acerca de Radio UAA</h1>
<div class="parallax-container">
    <!-- Primer bloque -->
    <div class="parallax-item">
        <p class="parrafo1">
            1. Radio UAA nace el 13 de enero de 1978 con la premisa fundamental de ser un vínculo entre la Institución y la sociedad en general, de manera especial con la comunidad de nuestra Máxima Casa de Estudios, transmitiendo la cultura en sus diversas manifestaciones, el conocimiento, los valores y el quehacer universitario con plena responsabilidad social.
        </p>
        <p class="parrafo2">
            2. El 19 de junio del 2006 la emisora incursiona en la Frecuencia Modulada, transmitiendo en los 94.5 MHz, y a todo el mundo por Internet a través de la página radio.uaa.mx, así como en las aplicaciones TuneIn y Radio Garden las 24 horas, los 365 días del año y en el año 2023 se pone a disposición de todo público sus producciones en las plataformas de podcast más populares: Spotify, Apple Podcast, Google Podcast y Amazon Music.
        </p>
        <p class="parrafo3">
            3. Radio UAA cuenta con una variada programación musical para todos los gustos, ya sean propuestas dentro del Jazz, Rock, New Age, Reggae, Electrónica, así como música Tradicional de diversas partes del mundo.
        </p>
    </div>

    <!-- Segundo bloque -->
    <div class="parallax-item">
        <p class="parrafo1">
            4. Dos son los espacios informativos transmitidos a través de Radio UAA: “UAA Noticias” en colaboración con nuestro canal de Televisión Universitaria «UAA TV», así como la retransmisión del noticiario de Radio Educación «Pulso de la noche”, el cual complementa nuestra barra de información.
        </p>
    </p>
        <p class="parrafo2">
            5. En análisis y debate de temas de interés, destaca el programa “Prospectiva 94.5”, donde de la mano de los especialistas se analizan los temas en tendencia de forma imparcial y desde la visión académica de la UAA; en contenido histórico, “La Terca Memoria”, así como “Panorama Universitario”, espacio dedicado a difundir producciones radiofónicas de diferentes Radios Universitarias de México.
        </p>
        <p class="parrafo3">
            6. Dentro de la barra de difusión del quehacer en los Centros Académicos y Direcciones Generales contamos con producciones como “Hoy Filosofía”, “El Gis”, “ADN de la Salud”, “Altavoz”, “Hablemos de Trabajo Social” y “Proiectus”.
        </p>
    </div>

    <!-- Tercer bloque -->
    <div class="parallax-item">
        <p class="parrafo1">
            7. La Extensión Universitaria se difunde a través de nuestras nuevas producciones, como «Contra Rutina», programa del Departamento de Difusión Cultural donde la comunidad universitaria está al día de todas las actividades culturales de nuestra institución: Helikón, Museo de la Muerte, Polifonía Universitaria, Muestras de Cine, etc.
        </p>
        <p class="parrafo2">
            8. También destaca la participación de productores externos de otras instituciones de Educación Superior como el Instituto Tecnológico de Aguascalientes y la Universidad Pedagógica Nacional; así como de dependencias gubernamentales y municipales, entre ellas el IMAC e ICA quienes completan el vínculo entre la Universidad y Sociedad.
        </p>
        <p class="parrafo3">
            9. Finalmente, Radio UAA se integra a “La Red” de radiodifusoras y televisoras educativas y culturales de México, con la que colabora desde 2014 y en el año 2015 forma parte de los miembros fundadores de la RRUM (Red de Radiodifusoras Universitarias de México) participando así de manera activa en la difusión de la cultura y la transmisión del conocimiento.
        </p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    let lastScrollTop = 0; // Mantiene la posición anterior del scroll
    let ticking = false;  // Evita llamadas innecesarias durante el scroll

    // Divide cada texto en letras envueltas en spans para animación
    const textos = document.querySelectorAll('.parrafo1, .parrafo2, .parrafo3');
    textos.forEach(texto => {
        const letras = texto.textContent.split('');
        texto.innerHTML = letras
            .map((letra, i) => `<span style="--index: ${i}">${letra === ' ' ? '&nbsp;' : letra}</span>`)
            .join('');
    });

    // Función que ejecuta las animaciones cuando corresponde
    const onScroll = () => {
        const currentScrollTop = window.scrollY; // Obtén la posición actual del scroll
        const isScrollingDown = currentScrollTop > lastScrollTop; // Detecta si el scroll va hacia abajo
        lastScrollTop = currentScrollTop; // Actualiza la posición del scroll

        if (isScrollingDown) {
            textos.forEach(texto => {
                if (!texto.classList.contains('scrolled')) { // Solo verifica los que no están animados
                    const rect = texto.getBoundingClientRect(); // Obtén las dimensiones del texto
                    const isVisible = rect.top < window.innerHeight && rect.bottom > 0; // Verifica si está visible

                    if (isVisible) {
                        texto.classList.add('scrolled'); // Agrega la clase para animar
                    }
                }
            });
        }

        ticking = false; // Indica que la ejecución ha terminado
    };

    // Manejo del evento de scroll usando requestAnimationFrame
    document.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(onScroll); // Ejecuta en el próximo frame disponible
            ticking = true;
        }
    });
});


</script>


<!-- <div class="texto-titulo">
    <h1>ACERCA DE RADIO UAA</h1>
</div>

<section class="contenedor-img">
    <div class="texto-nosotros">
        <p>
            1. Radio UAA nace el 13 de enero de 1978 con la premisa fundamental de ser un vínculo entre la Institución y la sociedad 
            en general, de manera especial con la comunidad de nuestra Máxima Casa de Estudios, transmitiendo la cultura en sus diversas 
            manifestaciones, el conocimiento, los valores y el quehacer universitario con plena responsabilidad social.
        </p>
        <p>
            2. El 19 de junio del 2006 la emisora incursiona en la Frecuencia Modulada, transmitiendo en los 94.5 MHz, y a todo el mundo 
            por Internet a través de la página radio.uaa.mx, así como en las aplicaciones TuneIn y Radio Garden las 24 horas, los 365 días 
            del año y en el año 2023 se pone a disposición de todo público sus producciones en las plataformas de podcast más populares: 
            Spotify, Apple Podcast, Google Podcast y Amazon Music.
        </p>
        <p>
            3. Radio UAA cuenta con una variada programación musical para todos los gustos, ya sean propuestas dentro del Jazz, Rock, 
            New Age, Reggae, Electrónica, así como música Tradicional de diversas partes del mundo.
        </p>

    </div>

    <div class="nosotros-container">
        <img src="resources/img/licHeriberto.jpeg" alt="">
    </div>

</section> -->


<!-- <div class="texto-nosotros">
    <h1>ACERCA DE RADIO UAA</h1>

    <p>1. Radio UAA nace el 13 de enero de 1978 con la premisa fundamental de ser un vínculo entre la Institución y la sociedad en general, de manera especial con la comunidad de nuestra Máxima Casa de Estudios, transmitiendo la cultura en sus diversas manifestaciones, el conocimiento, los valores y el quehacer universitario con plena responsabilidad social.</p>

    <p>2. El 19 de junio del 2006 la emisora incursiona en la Frecuencia Modulada, transmitiendo en los 94.5 MHz, y a todo el mundo por Internet a través de la página radio.uaa.mx, así como en las aplicaciones TuneIn y Radio Garden las 24 horas, los 365 días del año y en el año 2023 se pone a disposición de todo público sus producciones en las plataformas de podcast más populares: Spotify, Apple Podcast, Google Podcast y Amazon Music.</p>

    <p>3. Radio UAA cuenta con una variada programación musical para todos los gustos, ya sean propuestas dentro del Jazz, Rock, New Age, Reggae, Electrónica, así como música Tradicional de diversas partes del mundo.</p>

    <p>4. Dos son los espacios informativos transmitidos a través de Radio UAA: “UAA Noticias” en colaboración con nuestro canal de Televisión Universitaria «UAA TV», así como la retransmisión del noticiario de Radio Educación «Pulso de la noche”, el cual complementa nuestra barra de información.</p>

    <p>5. En análisis y debate de temas de interés, destaca el programa “Prospectiva 94.5”, donde de la mano de los especialistas se analizan los temas en tendencia de forma imparcial y desde la visión académica de la UAA; en contenido histórico, “La Terca Memoria”, así como “Panorama Universitario”, espacio dedicado a difundir producciones radiofónicas de diferentes Radios Universitarias de México.</p>

    <p>6. Dentro de la barra de difusión del quehacer en los Centros Académicos y Direcciones Generales contamos con producciones como “Hoy Filosofía”, “El Gis”, “ADN de la Salud”, “Altavoz”, “Hablemos de Trabajo Social” y “Proiectus”.</p>

    <p>7. La Extensión Universitaria se difunde a través de nuestras nuevas producciones, como «Contra Rutina», programa del Departamento de Difusión Cultural donde la comunidad universitaria está al día de todas las actividades culturales de nuestra institución: Helikón, Museo de la Muerte, Polifonía Universitaria, Muestras de Cine, etc.</p>

    <p>8. También destaca la participación de productores externos de otras instituciones de Educación Superior como el Instituto Tecnológico de Aguascalientes y la Universidad Pedagógica Nacional; así como de dependencias gubernamentales y municipales, entre ellas el IMAC e ICA quienes completan el vínculo entre la Universidad y Sociedad.</p>

    <p>9. Finalmente, Radio UAA se integra a “La Red” de radiodifusoras y televisoras educativas y culturales de México, con la que colabora desde 2014 y en el año 2015 forma parte de los miembros fundadores de la RRUM (Red de Radiodifusoras Universitarias de México) participando así de manera activa en la difusión de la cultura y la transmisión del conocimiento.</p>
</div> -->
