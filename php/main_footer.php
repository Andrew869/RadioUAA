<div class="container-social-buttons">
    <div class="social-buttons">
        <a href="https://wa.me/524499121588" target="_blank" class="social-button whatsapp <?php echo $currentTheme === "dark"? "light" : "dark" ?>">
            <?php echo GetSVG('resources/img/svg/whatsapp.svg', ["24px", "24px"]) ?>
        </a>
        <a href="https://www.instagram.com/radio.uaa/" target="_blank" class="social-button instagram <?php echo $currentTheme === "dark"? "light" : "dark" ?>">
            <?php echo GetSVG('resources/img/svg/instagram.svg', ["24px", "24px"]) ?>
        </a>
        <a href="https://www.facebook.com/RadioUAA" target="_blank" class="social-button facebook <?php echo $currentTheme === "dark"? "light" : "dark" ?>">
            <?php echo GetSVG('resources/img/svg/facebook.svg', ["24px", "24px"]) ?>
        </a>
        <a href="https://open.spotify.com/show/33OclgjRhmrjS1GaSAwXoU" target="_blank" class="social-button spotify <?php echo $currentTheme === "dark"? "light" : "dark" ?>">
            <?php echo GetSVG('resources/img/svg/spotify.svg', ["24px", "24px"]) ?>
        </a>
    </div>
</div>



<?php include 'php/player.php' ?>

<footer>
<div class="container-descarga-buttons">
    <div class="animated-text">
        <span>Descarga</span>
        <span>Nuestra</span>
        <span>App</span>
    </div>
   
    
    <div class="descarga-buttons">
        <a href="https://play.google.com/store/search?q=radio+uaa+94.5fm&c=apps&pli=1" target="_blank" class="social-button google-play">
            <!-- <img src="resources/img/svg/google-play.svg" alt="Google Play Logo" class="button-logo"> -->
            <?php echo GetSVG('resources/img/svg/google-play.svg', ["20px", "20px"]) ?>
            <span>Google Play</span>
        </a>
        <a href="https://apps.apple.com/mx/app/radio-uaa-94-5fm/id6670407197" target="_blank" class="social-button apple-store">
            <!-- <img src="resources/img/svg/app-store.svg" alt="App Store Logo" class="button-logo"> -->
            <?php echo GetSVG('resources/img/svg/app-store.svg', ["20px", "20px"]) ?>
            <span>App Store</span>
        </a>
    </div>
</div>

<div class="container-uaa">
    <a href="https://www.uaa.mx/portal/" target="_blank">
        <div class="icon">
            <?php echo GetSVG('resources/img/svg/uaa-logo.svg', ["150px", "150px"]) ?>
        </div>
        
    </a>

    <a href="https://www.uaa.mx/dgdv/" target="_blank">
        <div class="icon">
            <?php echo GetSVG('resources/img/svg/uaa-dgdv.svg', ["150px", "150px"]) ?>
        </div>
    </a>
</div>

<div class="copyright-container">
    <div class="copyright-links">
        <p><b>&copy; Derechos de autor 1978-2024 Radio UAA – Proyección de la voz universitaria</b>
            <a class="internal-link" href="/politica-de-privacidad">| Politica de Privacidad |</a>
            <a class="internal-link" href="/transparencia">Transparencia |</a>
        </p>
    </div>
</div>

</footer>