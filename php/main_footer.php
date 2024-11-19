<div class="container-social-buttons">
    <div class="social-buttons">
        <a href="https://wa.me/524499121588" target="_blank" class="social-button whatsapp">
            <?php echo GetSVG('resources/img/svg/whatsapp.svg', ["24px", "24px", "white"]) ?>
        </a>
        <a href="https://www.instagram.com/radio.uaa/" target="_blank" class="social-button instagram">
            <?php echo GetSVG('resources/img/svg/instagram.svg', ["24px", "24px", "white"]) ?>
        </a>
        <a href="https://www.facebook.com/RadioUAA" target="_blank" class="social-button facebook">
            <?php echo GetSVG('resources/img/svg/facebook.svg', ["24px", "24px", "white"]) ?>
        </a>
        <a href="https://open.spotify.com/show/33OclgjRhmrjS1GaSAwXoU" target="_blank" class="social-button spotify">
            <?php echo GetSVG('resources/img/svg/spotify.svg', ["24px", "24px", "white"]) ?>
        </a>
    </div>
</div>



<?php include 'php/player.php' ?>

<footer>
    <div class="container-uaa">
        <a href="https://www.uaa.mx/portal/" target="_blank">
            <img src="resources/img/UAA-LOGO.png" alt="Logo UAA" class="logo-uaa" />
        </a>
        <a href="https://www.uaa.mx/dgdv/" target="_blank">
            <img src="resources/img/UAA-DG.png" alt="Logo UAA" class="logo-uaa" />
        </a>
    </div>


<div class="container-descarga-buttons">
<div class="animated-text">
        <span>¡Descarga nuestra app y síguenos a todos lados, viva RADIO UAA!!!</span>
    </div>
    <div class="descarga-buttons">
        <a href="https://play.google.com/store/search?q=radio+uaa+94.5fm&c=apps&pli=1" target="_blank" class="social-button google-play">
            <img src="resources/img/svg/google-play.svg" alt="Google Play Logo" class="button-logo">
            <span>Google Play</span>
        </a>
        <a href="https://apps.apple.com/mx/app/radio-uaa-94-5fm/id6670407197" target="_blank" class="social-button apple-store">
            <img src="resources/img/svg/app-store.svg" alt="App Store Logo" class="button-logo">
            <span>App Store</span>
        </a>
    </div>
</div>



    <div class="copyright-container">
        <div class="copyright-links">
            <p><b>&copy; Derechos de autor 1978-2024 Radio UAA – Proyección de la voz universitaria</b>
            <a class="internal-link" href="politica-de-privacidad">| Politica de Privacidad |</a>
            <a class="internal-link" href="transparencia">Transparencia |</a>
            </p>
        </div>
    </div>

</footer>


<script type="module" src="js/light-dark-mode.js?v=<?php echo PROJECT_HASH ?>"></script>
<script src="js/navbar.js?v=<?php echo PROJECT_HASH ?>"></script>
<!-- <script src="js/barrabuscar.js?v=<?php echo PROJECT_HASH ?>"></script> -->