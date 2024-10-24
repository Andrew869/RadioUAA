<header>
    <nav class="navbar">
        <div class="logo">
            <a href="Inicio.html">
                <img src="resources/img/logo-radio-uaa-blanco.png" alt="Radio UAA Logo">
            </a>
        </div>
        <!-- Botón Hamburguesa -->
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <ul class="nav-links" id="nav-links">
            <li><a href="inicio" class="nav-link">Inicio</a></li>
            <li class="dropdown">
                <a class="arrow-down">Nosotros</a>
                <ul class="dropdown-content">
                    <li><a href="nosotros" class="nav-link">Acerca de Radio UAA</a></li>
                    <li><a href="preguntas-frecuentes" class="nav-link">Preguntas Frecuentes</a></li>
                    <li><a href="consejo-ciudadano" class="nav-link">Consejo Ciudadano</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="arrow-down">Defensoría</a>
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

        <!-- Botón Modo Oscuro -->
        <div class="dark-mode-toggle">
            <label for="toggle" id="label_toggle" aria-label="Toggle Dark Mode">
                <?php echo GetSVG($iconProperties[$currentTheme]['url'], $iconProperties[$currentTheme]['styles']) ?>
                <!-- <i id="theme-icon" class="fa-solid fa-moon"></i> -->
            </label>
            <input type="checkbox" id="toggle" aria-hidden="true" <?php echo ($currentTheme === 'dark' ? 'checked' : ''); ?>>
        </div>

        <!-- Search Icon -->
        <div id="cont-icon-search" aria-label="Search">
            <i class="fas fa-search" id="icon-search"></i>
        </div>
        <!-- Search Bar -->
        <div id="cont-bars-search">
            <input type="text" id="inputSearch" placeholder="Buscar en Radio UAA..." aria-label="Search">
        </div>
        <!-- Search Suggestions -->
        <ul id="box-search">
            <li><a href="Index.html"><i class="fas fa-search"></i>Inicio</a></li>
            <li><a href="Acerca de Radio UAA.html"><i class="fas fa-search"></i>Acerca de Radio UAA</a></li>
            <li><a href="Preguntas Frecuentes.html"><i class="fas fa-search"></i>Preguntas Frecuentes</a></li>
            <li><a href="Consejo Ciudadano.html"><i class="fas fa-search"></i>Consejo Ciudadano</a></li>
            <li><a href="Defensoria.html"><i class="fas fa-search"></i>Defensoría de las Audiencias</a></li>
            <li><a href="Derechos de las Audiencias.html"><i class="fas fa-search"></i>Derechos de las Audiencias</a></li>
            <li><a href="Quejas y Sugerencias.html"><i class="fas fa-search"></i>Quejas y Sugerencias</a></li>
            <li><a href="Transparencia.html"><i class="fas fa-search"></i>Transparencia</a></li>
            <li><a href="Politicas de Privacidad.html"><i class="fas fa-search"></i>Políticas de privacidad</a></li>
            <li><a href="programacion.html"><i class="fas fa-search"></i>Programación</a></li>
            <li><a href="#"><i class="fas fa-search"></i>Contenido</a></li>
            <li><a href="Contacto.html"><i class="fas fa-search"></i>Contacto</a></li>
        </ul>
    </nav>
</header>