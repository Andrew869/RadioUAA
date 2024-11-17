<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ejemplo de posición absoluta</title>
<style>
    .padre {
        position: relative;
        width: 300px;
        height: 200px;
        background-color: #f0f0f0;
    }

    .primer-hijo {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 200px;
        height: 100px;
        background-color: #b3e0ff;
    }

    .segundo-hijo {
        position: absolute;
        bottom: 0px;
        right: 0px;
        width: 50px;
        height: 50px;
        background-color: #ffcc80;
    }

    div{
        display: flex;
    }
</style>
</head>
<body>

<div class="padre">
    <div class="primer-hijo">
        Primer hijo absoluto
        <div class="segundo-hijo">
            Segundo hijo absoluto
        </div>
    </div>
</div>

<div>
    <img style="width: 50%" id="image1" src="resources/uploads/img/programa_103[v0]?v=<?php echo "PROJECT_HASH" ?>" alt="">
    <img style="width: 50%" id="image2" src="resources/uploads/img/programa_109[v0].300?v=<?php echo "PROJECT_HASH" ?>" alt="">
</div>
<script type="module" src="js/cal.js"></script>
</body>
</html>
