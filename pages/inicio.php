<?php
    $initPath = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $initPath = $_POST['initPath'];
    }

    include_once $initPath . 'php/db_connect.php';
?>
<div class="main-content">
    <iframe
        class="facebook-embed"
        src="https://www.facebook.com/plugins/video.php?href=https://www.facebook.com/270053706369750/videos/595368126259614"
        scrolling="no"
        frameborder="0" 
        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" 
        allowFullScreen="true">
    </iframe>
    <div class="next-programs-content">
        <div>A continuación</div>
        <div class="next-programs-container">
            <?php include $initPath . 'php/programs_info.php' ?>
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