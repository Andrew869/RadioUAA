let slideIndex = 0;
showSlides();

function showSlides() {
    let slides = document.getElementsByClassName("mySlides");

    // Ocultar todas las imágenes
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.opacity = 0;
        slides[i].style.display = "none";
    }

    slideIndex++;
    
    if (slideIndex > slides.length) {
        slideIndex = 1;
    }

    // Mostrar la siguiente imagen con una transición suave
    slides[slideIndex - 1].style.display = "block";
    setTimeout(function () {
        slides[slideIndex - 1].style.opacity = 1;
    }, 50); // Pequeño retraso para que la transición se note

    setTimeout(showSlides, 5000); // Cambia la imagen cada 5 segundos
}
