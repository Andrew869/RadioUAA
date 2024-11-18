<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla con encabezado sticky</title>
    <style>
        #customRange {
            position: sticky;
            right: 0;
            bottom: 20px;
            width: 50%;
            height: 8px;
            -webkit-appearance: none;
            appearance: none;
            background: linear-gradient(to right, #4CAF50 0%, #4CAF50 10%, #ddd 20%, #ddd 100%);
            border-radius: 5px;
            outline: none;

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

        main,
        footer {
            width: 100%;
            height: 9000px;
            background-color: teal;
        }

        .container {
            background-color: cyan;
            height: 1000px;
        }

        .sticky-element {
            position: sticky;
            top: 20px;
            width: max-content;
            margin-left: auto;
        }

        .other-stuff {
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sticky-element">
            <button>Button 1</button>
            <button>Button 2</button>
        </div>
        <div class="other-stuff">
            Some other stuff that is drawn up if float: right is applied on sticky-element.
            (But shouldn't)
        </div>
    </div>
    <!-- <main>
    </main>

    <input type="range" id="customRange" min="0" max="1" step="0.01" value="1" />
    <footer>

    </footer> -->
</body>

</html>