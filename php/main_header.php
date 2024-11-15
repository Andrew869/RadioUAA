<header>
    <nav class="navbar">
        <div class="logo">
            <a class="nav-link internal-link" href="./">
                <!-- <img src="resources/img/logo-radio-uaa-blanco.png" alt="Radio UAA Logo"> -->
                <?php echo GetSVG('resources/img/svg/logoRadioUAA.svg', ["40px", "40px", "white"]) ?>
            </a>
        </div>
        <div class="nav-links">
            <ul>
                <li><a href="inicio" class="nav-link internal-link">Inicio</a></li>
                <li class="dropdown">
                    <a class="nav-link internal-link arrow-down">Nosotros</a>
                    <ul class="dropdown-content">
                        <li><a href="nosotros" class="nav-link internal-link">Acerca de Radio UAA</a></li>
                        <li><a href="preguntas-frecuentes" class="nav-link internal-link">Preguntas Frecuentes</a></li>
                        <li><a href="consejo-ciudadano" class="nav-link internal-link">Consejo Ciudadano</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="nav-link internal-link arrow-down">Defensoría</a>
                    <ul class="dropdown-content">
                        <li><a href="defensoria-de-las-audiencias" class="nav-link internal-link">Defensoría de las Audiencias</a></li>
                        <li><a href="derechos-de-la-audiencia" class="nav-link internal-link">Derechos de las Audiencias</a></li>
                        <li><a href="quejas-sugerencias" class="nav-link internal-link">Quejas y Sugerencias</a></li>
                        <li><a href="transparencia" class="nav-link internal-link">Transparencia</a></li>
                        <li><a href="politica-de-privacidad" class="nav-link internal-link">Políticas de privacidad</a></li>
                    </ul>
                </li>
                <li><a href="programacion" class="nav-link internal-link">Programación</a></li>
                <li><a href="contenido" class="nav-link internal-link">Contenido</a></li>
                <li><a href="contacto" class="nav-link internal-link">Contacto</a></li>
            </ul>
        </div>

        <div class="search-bar-content">
            <div class="search-bar-container">
                <div class="search-bar">
                    <input type="text" id="inputSearch" placeholder="Buscar..." aria-label="Search">
                    <label id="search-icon" class="icon" for="inputSearch">
                        <?php echo GetSVG('resources/img/svg/search.svg', ["18px", "18px", "black"]) ?>
                    </label>
                </div>
                <ul id="box-search">
                    <li><a class="internal-link" href="inicio"><?php echo GetSVG('resources/img/svg/search.svg', ['18px', '18px', 'black']) ?>Inicio</a></li>
                    <li><a class="internal-link" href="nosotros"><?php echo GetSVG('resources/img/svg/search.svg', ['18px', '18px', 'black']) ?>Acerca de Radio UAA</a></li>
                    <li><a class="internal-link" href="preguntas-frecuentes"><?php echo GetSVG('resources/img/svg/search.svg', ['18px', '18px', 'black']) ?>Preguntas Frecuentes</a></li>
                    <li><a class="internal-link" href="consejo-ciudadano"><?php echo GetSVG('resources/img/svg/search.svg', ['18px', '18px', 'black']) ?>Consejo Ciudadano</a></li>
                    <li><a class="internal-link" href="defensoria-de-las-audiencias"><?php echo GetSVG('resources/img/svg/search.svg', ['18px', '18px', 'black']) ?>Defensoría de las Audiencias</a></li>
                    <li><a class="internal-link" href="derechos-de-la-audiencia"><?php echo GetSVG('resources/img/svg/search.svg', ['18px', '18px', 'black']) ?>Derechos de las Audiencias</a></li>
                    <li><a class="internal-link" href="quejas-sugerencias"><?php echo GetSVG('resources/img/svg/search.svg', ['18px', '18px', 'black']) ?>Quejas y Sugerencias</a></li>
                    <li><a class="internal-link" href="transparencia"><?php echo GetSVG('resources/img/svg/search.svg', ['18px', '18px', 'black']) ?>Transparencia</a></li>
                    <li><a class="internal-link" href="politica-de-privacidad"><?php echo GetSVG('resources/img/svg/search.svg', ['18px', '18px', 'black']) ?>Políticas de privacidad</a></li>
                    <li><a class="internal-link" href="programacion"><?php echo GetSVG('resources/img/svg/search.svg', ['18px', '18px', 'black']) ?>Programación</a></li>
                    <li><a class="internal-link" href="contenido"><?php echo GetSVG('resources/img/svg/search.svg', ['18px', '18px', 'black']) ?>Contenido</a></li>
                    <li><a class="internal-link" href="contacto"><?php echo GetSVG('resources/img/svg/search.svg', ['18px', '18px', 'black']) ?>Contacto</a></li>
                </ul>
            </div>
            <div class="close-btn">
                &times;
            </div>
        </div>

        <div id="button-search" class="icon">
            <?php echo GetSVG('resources/img/svg/search.svg', ["18px", "18px", "white"]) ?>
        </div>

        <!-- Botón Modo Oscuro -->
        <div class="dark-mode-toggle">
            <label for="toggle" id="label_toggle" class="icon">
                <?php echo GetSVG($iconProperties[$currentTheme]['url'], $iconProperties[$currentTheme]['styles']) ?>
                <!-- <i id="theme-icon" class="fa-solid fa-moon"></i> -->
            </label>
            <input type="checkbox" id="toggle" aria-hidden="true" <?php echo ($currentTheme === 'dark' ? 'checked' : ''); ?>>
        </div>
        <div id="menu-icon">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
    </nav>
</header>