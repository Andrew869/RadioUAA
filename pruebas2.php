<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tabla con encabezado sticky</title>
<style>
#customRange {
    width: 100%;
    height: 8px;
    -webkit-appearance: none;
    appearance: none;
    background: linear-gradient(to right, #4CAF50 0%, #4CAF50 10%, #ddd 20%, #ddd 100%);
    border-radius: 5px;
    outline: none;
    position: relative;
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

</style>
</head>
<body>
<input type="range" id="customRange"min="0" max="1" step="0.01" value="1"/>


</body>
</html>
