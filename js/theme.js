document.addEventListener('DOMContentLoaded', () => {
    let toggle = document.getElementById('toggle');
    let label_toggle = document.getElementById('label_toggle');
    let themeIcon = document.getElementById('theme-icon'); // Icono del botón
    let imgs = document.getElementsByClassName('logo-uaa');
    let dropdown_content = document.getElementsByClassName('dropdown-content')[0];

    // Función para aplicar el tema
    const applyTheme = (isDark) => {
        document.body.classList.toggle('dark', isDark);
        for (let index = 0; index < imgs.length; index++) {
            imgs[index].style.background = isDark ? "#fff" : "none";
        }
        dropdown_content.style.boxShadow = isDark
            ? "rgba(255, 255, 255, 0.15) 2.4px 2.4px 3.2px"
            : "rgba(0, 0, 0, 0.15) 2.4px 2.4px 3.2px";
        
        label_toggle.innerHTML = isDark ? '<i class="fa-solid fa-sun"></i>' : '<i class="fa-solid fa-moon"></i>';
        label_toggle.style.color = isDark ? "black" : "white";
        themeIcon.classList.toggle('fa-sun', isDark);
        themeIcon.classList.toggle('fa-moon', !isDark);
        themeIcon.style.color = isDark ? "yellow" : "";
    };

    // Verificar si el modo oscuro está guardado en localStorage
    const darkMode = localStorage.getItem('darkMode') === 'true';
    toggle.checked = darkMode; // Establecer el estado del checkbox
    applyTheme(darkMode); // Aplicar el tema al cargar

    // Manejo del cambio de tema
    toggle.addEventListener('change', (event) => {
        let checked = event.target.checked;
        localStorage.setItem('darkMode', checked); // Guardar en localStorage
        applyTheme(checked);
    });

    // Verificar si themeToggle existe antes de agregar el evento
    let themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            toggle.checked = !toggle.checked; 
            toggle.dispatchEvent(new Event('change')); 
        });
    }
});
