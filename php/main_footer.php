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

<div class="container-descarga-buttons">
    <div class="descarga-buttons">
        <a href="https://play.google.com/store/search?q=radio+uaa+94.5fm&c=apps&pli=1" target="_blank" class="social-button google-play">
            <?php echo GetSVG('resources/img/svg/google-play.svg', ["20px", "20px", "white"]) ?>
        </a>
        <a href="https://apps.apple.com/mx/app/radio-uaa-94-5fm/id6670407197"target="_blank" class="social-button apple-store">
            <?php echo GetSVG('resources/img/svg/app-store.svg', ["24px", "24px", "white"]) ?>
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
    <div class="copyright-container">
        <div class="copyright">
            <p>&copy; Derechos de autor 1978-2024 Radio UAA – Proyección de la voz universitaria</p>
        </div>
        <div class="copyright-links">
            <a class="internal-link" href="politica-de-privacidad"> <span style="color: white;"><b>| Politica de Privacidad |</span>.</b></a>
            <a class="internal-link" href="transparencia"> <span style="color: white;"><b>Transparencia</span>.</b></a>
        </div>
    </div>
</footer>
<script type="module" src="js/light-dark-mode.js?v=<?php echo time(); ?>"></script>
<script src="js/navbar.js?v=<?php echo time(); ?>"></script>
<!-- <script src="js/barrabuscar.js?v=<?php echo time(); ?>"></script> -->