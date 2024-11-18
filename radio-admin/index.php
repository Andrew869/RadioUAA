<?php 
    include "connNCheck.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radio Admin</title>
    <link rel="stylesheet" href="../css/commonStyles.css?v=<?php echo PROJECT_HASH ?>">
</head>
<body>
    <header class="header">
    <?php
        include "nav_header.php";
    ?>
    </header>
    <aside></aside>
    <main class="main">
        <div class="en_vivo">
            <h1>Programas En vivo</h1>
        </div>
        <div class="ultimos_anadidos">
            <h1>Anadidos Ultimamente</h1>
            <div class="contenidos">
                <div class="programas">
                    <h2>PROGRAMAS</h2>
                </div>

                <div class="presentadores">
                    <h2>PRESENTADORES</h2>
                </div>

                 <div class="generos">
                    <h2>GENEROS</h2>
                </div>

            </div>
            

        </div>
       
       
        <div class="comentarios">
            <h2>Ultimos Comentarios</h2>
            <div class="comentarios-con"></div>
        </div>
    </main>
    <footer>

    </footer>
</body>
</html>