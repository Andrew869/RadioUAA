import { GetSVG } from './utilities.js';
const body = document.body;
let toggle = document.getElementById('toggle');
let label_toggle = document.getElementById('label_toggle');

// Función para aplicar el tema
const applyTheme = (isDark) => {
    body.classList.toggle('dark', isDark);
    let theme = (isDark ? 'dark' : 'light');
    const iconProperties = {
        dark: {url: '../resources/img/svg/sun.svg', styles: ["18px", "18px", "white"]},
        light: {url: '../resources/img/svg/moon.svg', styles: ["18px", "18px", "white"]}
    }

    // GetSVG(label_toggle, (isDark ? 'resources/img/sun.svg' : 'resources/img/moon.svg'), ["18px", "18px", "yellow"]);
    GetSVG(label_toggle, iconProperties[theme].url, iconProperties[theme].styles);
};
// width: 18px; height: 18px; fill: black;
// Manejo del cambio de tema
toggle.addEventListener('change', (event) => {
    let checked = event.target.checked;
    const theme = checked ? 'dark' : 'light';
    applyTheme(checked);
    document.cookie = `theme=${theme}; path=/; max-age=${30 * 24 * 60 * 60}; SameSite=Lax`;
});