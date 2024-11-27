<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ejemplo de posición absoluta</title>
<style>
    .slideshow-content {
    padding: 10px;
    /* width: 960px;
    height: 300px */
    /* background-color: #0866FF; */
}

.slideshow-container {
    /* max-width: 1000px; */
    position: relative;
    /* margin: auto; */
}

.slide {
    display: none;
    max-width: 960px;
    max-height: 480px;
    width: 9000px;
    height: 450px;
    /* aspect-ratio: 16/8; */
    background-color: yellow;
}

.slide img {
    background-color: #005530;
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    /* border-radius: 12px; */
}

/* Next & previous buttons */
.prev,
.next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    padding: 16px;
    margin-top: -22px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    transition: 0.6s ease;
    border-radius: 0 3px 3px 0;
    user-select: none;
}

/* Position the "next button" to the right */
.next {
    right: 0;
    border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
    background-color: rgba(0, 0, 0, 0.8);
}

/* Caption text */
.text {
    color: #f2f2f2;
    font-size: 15px;
    padding: 8px 12px;
    position: absolute;
    bottom: 8px;
    /* inset: 0 0 0 0; */
    width: 100%;
    text-align: center;
    /* background-color: rgba(0, 0, 0, 0.473); */
}

/* Number text (1/3 etc) */
.numbertext {
    color: #f2f2f2;
    font-size: 12px;
    padding: 8px 12px;
    position: absolute;
    top: 0;
}

/* The dots/bullets/indicators */
.dot {
    cursor: pointer;
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #555;
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.6s ease;
}

.active,
.dot:hover {
    background-color: #fff;
}

/* Fading animation */
.fade {
    animation-name: fade;
    animation-duration: 1.5s;
}

@keyframes fade {
    from {
        opacity: 0.4;
    }
    to {
        opacity: 1;
    }
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
    .prev,
    .next,
    .text {
        font-size: 11px;
    }
}

</style>
</head>
<body>
<div class="slideshow-content">
        <div class="slideshow-container">
            <div class="slide fade">
                <!-- <div class="numbertext">1 / 3</div> -->
                <img src="resources/img/promo-AppRadioUAA.png">
                <div class="text">Caption Text</div>
            </div>

            <div class="slide fade">
            <!-- <div class="numbertext">2 / 3</div> -->
            <img src="resources/img/IMG_0716.jpg">
            <div class="text">Caption Two</div>
            </div>

            <div class="slide fade">
            <!-- <div class="numbertext">3 / 3</div> -->
            <img src="resources/img/IMG_0716.jpg">
            <div class="text">Caption Three</div>
            </div>

            <a class="prev">❮</a>
            <a class="next">❯</a>

        </div>
        <div style="text-align:center">
            <span class="dot"></span> 
            <span class="dot"></span> 
            <span class="dot"></span> 
        </div>
    </div>
</body>
    <script>
        
        let slideIndex = 1;
        let slideTimeout;
        
        SetupSlideshow();
 
  function SetupSlideshow() {
     const prev = document.querySelector('.prev');
     const next = document.querySelector('.next');
     const dots = document.getElementsByClassName("dot");
 
     showSlides(1);
 
     prev.onclick = () => {plusSlides(-1)};
     next.onclick = () => {plusSlides(1)};
 
     for (let i = 0; i < dots.length; i++) {
         dots[i].onclick = () => {currentSlide(i + 1)};
     }
 }
 
 function plusSlides(n) {
     showSlides(slideIndex += n);
 }
   
 function currentSlide(n) {
     showSlides(slideIndex = n);
 }
 
 function showSlides(n) {
     clearTimeout(slideTimeout);
     let i;
     let slides = document.getElementsByClassName("slide");
     let dots = document.getElementsByClassName("dot");
 
     if(!slides) return;
 
     if (n > slides.length) {slideIndex = 1}
     if (n < 1) {slideIndex = slides.length}
     for (i = 0; i < slides.length; i++) {
         slides[i].style.display = "none";  
     }
     for (i = 0; i < dots.length; i++) {
         dots[i].className = dots[i].className.replace(" active", "");
     }
     slides[slideIndex-1].style.display = "block";
     dots[slideIndex-1].className += " active";
     // slideTimeout = setTimeout(() => {plusSlides(1)}, 8000);
 }
    </script>
</html>
