let slideIndex = 1;
 
export let slideTimeout;

export function SetupSlideshow() {
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
    slideTimeout = setTimeout(() => {plusSlides(1)}, 8000);
}