<?php
    $jsInitPath = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $initPath = '';
        $jsInitPath = $_POST['initPath'];
    }

    include_once $jsInitPath . 'php/db_connect.php';
?>
<div class="main-title">
    <h1>Radio UAA</h1>
    <p>Proyección de la Voz Universitaria</p>
</div>
<div class="main-content">
    <!-- <iframe
        class="facebook-embed"
        src="https://www.facebook.com/plugins/video.php?href=https://www.facebook.com/270053706369750/videos/595368126259614"
        scrolling="no"
        frameborder="0" 
        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" 
        allowFullScreen="true">
    </iframe> -->
    <div class="slideshow-content">
        <div class="slideshow-container">
            <div class="slide fade">
                <!-- <div class="numbertext">1 / 3</div> -->
                <img src="<?php echo $jsInitPath ?>resources/img/promo-AppRadioUAA.png">
                <div class="text">Caption Text</div>
            </div>

            <div class="slide fade">
            <!-- <div class="numbertext">2 / 3</div> -->
            <img src="<?php echo $jsInitPath ?>resources/img/IMG_0716.jpg">
            <div class="text">Caption Two</div>
            </div>

            <div class="slide fade">
            <!-- <div class="numbertext">3 / 3</div> -->
            <img src="<?php echo $jsInitPath ?>resources/img/IMG_0716.jpg">
            <div class="text">Caption Three</div>
            </div>

            <a class="prev">❮</a>
            <a class="next">❯</a>

        </div>
        <div class="slideshow-dots">
            <span class="dot"></span> 
            <span class="dot"></span> 
            <span class="dot"></span> 
        </div>
    </div>
    <div class="next-programs-content">
        <div>A continuación</div>
        <div class="next-programs-container">
            <?php include $jsInitPath . 'php/programs_info.php' ?>
        </div>
    </div>
</div>

<!-- <iframe 
        src="https://www.facebook.com/plugins/video.php?height=314&href=https%3A%2F%2Fwww.facebook.com%2FRadioUAA%2Fvideos%2F1095161882345068%2F&show_text=false&width=560&t=0" 
        width="560" 
        height="314" 
        style="border:none;overflow:hidden" 
        scrolling="no" 
        frameborder="0" 
        allowfullscreen="false" 
        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
    </iframe> -->