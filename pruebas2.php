<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla con encabezado sticky</title>
    <style>
        /* #customRange {
            position: sticky;
            bottom: 20px;
            width: 100%;
            height: 8px;
            -webkit-appearance: none;
            appearance: none;
            background: linear-gradient(to right, #4CAF50 0%, #4CAF50 10%, #ddd 20%, #ddd 100%);
            border-radius: 5px;
            outline: none;

        }

        #customRange::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            background: #4CAF50;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
            z-index: 1;
        }

        #customRange::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background: #4CAF50;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
            z-index: 1;
        }

        #customRange::-ms-thumb {
            width: 20px;
            height: 20px;
            background: #4CAF50;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
            z-index: 1;
        }

        main,
        footer {
            width: 100%;
            height: 9000px;
            background-color: teal;
        }

        .dropdown-content {
            display: none;
        }

        .wrap {
            height: 80vh;
            position: relative;
            overflow: scroll;
            margin: 10em auto 20em;
            max-width: 960px;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior: contain;
        }

        .scenes {
            display: flex;
            flex-wrap: nowrap;
        }

        .track {
            flex: 1 0 calc(22% + 7px);
            scroll-snap-align: start;
        }

        .track+.track {
            margin-left: -1px;
        }

        .heading {
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            border: solid #fff;
            border-width: 0 1px;
            z-index: 1;
            background: #efefef;
            font-weight: 700;
        }

        .entry {
            border: 1px solid #ebebeb;
            border-top: 0;
            background: #fff;
            height: 8em;
            padding: 1em;
        }


        @media (max-width: 767px) {
            .track {
                flex: 1 0 calc(50% + 7px);
            }
        } */
        table {
      width: 100%;
      border-collapse: collapse; /* Para colapsar los bordes de la tabla */
    }
    
    td, th {
      width: 1500px; /* Ancho fijo para todas las celdas */
      border: 1px solid #ccc; /* Borde para visualización */
      padding: 8px; /* Espaciado interno */
      text-align: center; /* Alineación del contenido */
    }
    </style>
</head>

<body>

    <main>
    <table>
  <thead>
    <tr>
      <th>Encabezado 1</th>
      <th>Encabezado 2</th>
      <th>Encabezado 3</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Celda 1</td>
      <td>Celda 2</td>
      <td>Celda 3</td>
    </tr>
    <tr>
      <td>Celda 4</td>
      <td>Celda 5</td>
      <td>Celda 6</td>
    </tr>
  </tbody>
</table>


        <div class="d"></div>
        <div class="wrap">
            <div class="scenes">
                <div class="track">
                    <div class="heading">Heading 1</div>
                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit amet.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit amet consectetur.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                </div>
                <div class="track">
                    <div class="heading">Heading 2</div>

                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit amet.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit amet consectetur.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                </div>
                <div class="track">
                    <div class="heading">Heading 3</div>

                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit amet.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit amet consectetur.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                </div>
                <div class="track">
                    <div class="heading">Heading 4</div>

                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit amet.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit amet consectetur.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                </div>
                <div class="track">
                    <div class="heading">Heading 5</div>

                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit amet.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit amet consectetur.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                </div>
                <div class="track">
                    <div class="heading">Heading 6</div>

                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit amet.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit amet consectetur.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                </div>
                <div class="track">
                    <div class="heading">Heading 7</div>

                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit amet.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit amet consectetur.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem, ipsum dolor.</h3>
                    </div>
                    <div class="entry">
                        <h3>Lorem ipsum dolor sit.</h3>
                    </div>
                </div>
            </div>
        </div>


        <!-- <div class="nav-links">
            <ul>
                <li><a href="inicio" class="nav-link">Inicio</a></li>
                <li class="dropdown">
                    <a class="nav-link arrow-down">Nosotros</a>
                    <ul class="dropdown-content">
                        <li><a href="nosotros" class="nav-link">Acerca de Radio UAA</a></li>
                        <li><a href="preguntas-frecuentes" class="nav-link">Preguntas Frecuentes</a></li>
                        <li><a href="consejo-ciudadano" class="nav-link">Consejo Ciudadano</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="nav-link arrow-down">Defensoría</a>
                    <ul class="dropdown-content">
                        <li><a href="defensoria-de-las-audiencias" class="nav-link">Defensoría de las Audiencias</a></li>
                        <li><a href="derechos-de-la-audiencia" class="nav-link">Derechos de las Audiencias</a></li>
                        <li><a href="quejas-sugerencias" class="nav-link">Quejas y Sugerencias</a></li>
                        <li><a href="transparencia" class="nav-link">Transparencia</a></li>
                        <li><a href="politica-de-privacidad" class="nav-link">Políticas de privacidad</a></li>
                    </ul>
                </li>
                <li><a href="programacion" class="nav-link">Programación</a></li>
                <li><a href="contenido" class="nav-link">Contenido</a></li>
                <li><a href="contacto" class="nav-link">Contacto</a></li>
            </ul>
        </div> -->
    </main>

    <input type="range" id="customRange" min="0" max="1" step="0.01" value="1" />
    <footer>

    </footer>
</body>

</html>