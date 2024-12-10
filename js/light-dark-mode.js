import { GetSVG } from './utilities.js?v=70871d';
const body = document.body;
let toggle = document.getElementById('toggle');
let label_toggle = document.getElementById('label_toggle');

// Función para aplicar el tema
const applyTheme = (isDark) => {
    let prevTheme = (isDark ? 'light' : 'dark');
    let currentTheme = (isDark ? 'dark' : 'light');
    
    let elements = document.querySelectorAll('.'+prevTheme);
    let inverted = document.querySelectorAll('.'+currentTheme);
    // let elements2 = document.querySelectorAll('.'+prevTheme + 2);

    elements.forEach(element => {
        element.classList.remove(prevTheme);
        element.classList.add(currentTheme);
    });

    inverted.forEach(element => {
        element.classList.remove(currentTheme);
        element.classList.add(prevTheme);
    });

    // body.classList.toggle('dark', isDark);
    const iconProperties = {
        dark: {url: '../resources/img/svg/sun.svg', styles: ["18px", "18px"]},
        light: {url: '../resources/img/svg/moon.svg', styles: ["18px", "18px"]}
    }

    // GetSVG(label_toggle, (isDark ? 'resources/img/sun.svg' : 'resources/img/moon.svg'), ["18px", "18px", "yellow"]);
    GetSVG(label_toggle, iconProperties[currentTheme].url, iconProperties[currentTheme].styles);
};
// width: 18px; height: 18px; fill: black;
// Manejo del cambio de tema
toggle.addEventListener('change', (event) => {
    let checked = event.target.checked;
    const theme = checked ? 'dark' : 'light';
    applyTheme(checked);
    document.cookie = `theme=${theme}; path=/; max-age=${30 * 24 * 60 * 60}; SameSite=Lax`;
});