import { GetSVG, ToSeconds } from './utilities.js?v=c40e99';
const audio = document.getElementById('audio');

const playPauseBtn = document.getElementById('playPauseBtn');
const playPauseIcon = document.getElementById('playPauseIcon');
const syncBtn = document.getElementById('syncBtn');
const volumeSlider = document.getElementById('volumeSlider');
const programContainer = document.querySelector('.current-program-info');

const programName = document.querySelector('.current-program-info .curr-pro');
const programImg = document.querySelector('.current-program-info img');
const programTag = document.querySelector('.current-program-info .current-tag-info');

let timeoutId;
let timeToUpdate = 0;

// const loading = document.getElementById('loading');
// const metadata = document.getElementById('metadata');

// const seekBar = document.getElementById('seekBar');
// const currentTime = document.getElementById('currentTime');
// const duration = document.getElementById('duration');

audio.addEventListener('progress', () => {
    if (audio.buffered.length > 0) {
        const bufferedEnd = audio.buffered.end(audio.buffered.length - 1);
        const currentTime = audio.currentTime;
        const bufferTime = bufferedEnd - currentTime;
        // duration.textContent = bufferTime.toFixed(2);
        // duration.textContent = formatTime(bufferTime);
    }
});

function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60);
    return `${minutes}:${secs < 10 ? '0' : ''}${secs}`;
}

// Actualiza el slider con el progreso de la canción
// audio.addEventListener('timeupdate', () => {
//     seekBar.value = (audio.currentTime / (audio.duration - 10)) * 100;
//     // console.log(audio.currentTime / (audio.duration - 10));
//     currentTime.textContent = formatTime(audio.currentTime);
//     // duration.textContent = formatTime(audio.duration);
// });

// Actualiza la duración total de la canción
// audio.addEventListener('timeupdate', () => {
//     seekBar.max = 100;
//     duration.textContent = audio.duration;
// });

// se ejecuta cuando el DOM es cargado, no espera a que toda la pagina este cargada
document.addEventListener('DOMContentLoaded', function() {
    // Código a ejecutar cuando se carga la página
    const savedVolume = localStorage.getItem('audioVolume');
    if (savedVolume !== null) {
        volumeSlider.value = savedVolume;
        const value = (volumeSlider.value - volumeSlider.min) / (volumeSlider.max - volumeSlider.min) * 100;
        volumeSlider.style.background = `linear-gradient(to right, #4CAF50 0%, #4CAF50 ${value}%, #ddd ${value}%, #ddd 100%)`;
        audio.volume = savedVolume;
    }
});
// debe esperar a que toda la pagina este completamente cargada
window.addEventListener('load', function() {
    // console.log('La página se ha cargado completamente.');
});

// Muestra el indicador de carga mientras el audio se está cargando
// audio.addEventListener('waiting', () => {
//     loading.style.display = 'block';
// });

// // Oculta el indicador de carga cuando el audio empieza a reproducirse
// audio.addEventListener('playing', () => {
//     loading.style.display = 'none';
// });

// Para el caso de que la emisora transmita metadata adicional, puedes capturarla
audio.addEventListener('timeupdate', () => {
    // const currentTime = new Date().toLocaleTimeString();

    // // Simulando metadata dinámica
    // const simulatedMetadata = `Canción actual a las ${currentTime}`;
    // metadata.textContent = simulatedMetadata;
});

// Función para reproducir en vivo
const playLive = () => {
    audio.pause();
    audio.currentTime = 0;
    audio.load();
    audio.play().then(() => {
        playPauseIcon.className = 'fa-solid fa-pause';
    }).catch(error => {
        console.log('Error al intentar reproducir:', error);
    });
};

playPauseBtn.addEventListener('click', () => {
    if (audio.paused) {
        audio.play();
        // playLive();
        // playPauseIcon.className = 'fa-solid fa-pause';
        
    } else {
        audio.pause();
        // playPauseIcon.className = 'fa-solid fa-play';
    }
});

syncBtn.addEventListener('click', () => {
    playLive();
});

// Control de volumen
volumeSlider.addEventListener('input', (e) => {
    const value = (volumeSlider.value - volumeSlider.min) / (volumeSlider.max - volumeSlider.min) * 100;
    volumeSlider.style.background = `linear-gradient(to right, #4CAF50 0%, #4CAF50 ${value}%, #ddd ${value}%, #ddd 100%)`;
    console.log(value);
    audio.volume = e.target.value;
    localStorage.setItem('audioVolume', audio.volume);
    if(localStorage.getItem('audioVolume') !== null){
        // console.log("volumen saved");
    }
});

audio.addEventListener('loadedmetadata', () => {
    // if (audio.textTracks.length > 0) {
    //     console.log('El stream contiene metadata.');
    //     for (let i = 0; i < audio.textTracks.length; i++) {
    //         const track = audio.textTracks[i];
    //         track.mode = 'showing'; // Activa el track para leer la metadata
    //         track.addEventListener('cuechange', () => {
    //             const activeCue = track.activeCues[0];
    //             if (activeCue) {
    //                 console.log('Metadata:', activeCue.text);
    //                 // Aquí puedes actualizar la interfaz con la metadata recibida
    //             }
    //         });
    //     }
    // } else {
    //     console.log('El stream no contiene metadata.');
    // }
});

audio.addEventListener('play', () => {
    // playPauseIcon.className = 'fa-solid fa-pause';
    GetSVG(playPauseBtn, "../resources/img/svg/pause.svg", ["24px", "24px", "black"]);
    // console.log("has played");
});

audio.addEventListener('pause', () => {
    // playPauseIcon.className = 'fa-solid fa-play';
    GetSVG(playPauseBtn, "../resources/img/svg/play.svg", ["24px", "24px", "black"]);
    // console.log("has paused");
});

SetupTimetoUpdate();

function SetupTimetoUpdate(){
    let formData = new FormData();
    formData.append('GetCurrProgram', '');
    fetch('php/jsRequest.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // programContainer.innerHTML = data;
        let horaFin = ToSeconds(data[1]['hora_fin']);
        if(horaFin === 0) horaFin = 86400;
        timeToUpdate = (horaFin - ToSeconds(data[0])) * 1000;
        timeoutId = setTimeout(UpdateProgramInfo , timeToUpdate);
        console.log("milisec to update: " + timeToUpdate);
    })
    .catch(error => console.error('Error al cargar el contenido:', error));
}

function UpdateProgramInfo(){
    // console.log("asdasd " + timeToUpdate);
    let formData = new FormData();
    formData.append('GetCurrProgram', '');
    fetch('php/jsRequest.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // console.log(data);
        // programContainer.innerHTML = data;
        programName.textContent = data[1]['nombre_programa'];
        programImg.src = data[1]['url_img'] + ".300";
        if(programTag.classList.contains('live'))
            programTag.classList.remove('live');
        else
            programTag.classList.remove('retransmission');

        programTag.textContent = data[1]['es_retransmision'] ? "Retransmision" : "En vivo";
        programTag.classList.add(data[1]['es_retransmision'] ? "retransmission" : "live");
        
        let horaFin = ToSeconds(data[1]['hora_fin']);
        if(horaFin === 0) horaFin = 86400000;
        timeToUpdate = (horaFin - ToSeconds(data[0])) * 1000;
        timeoutId = setTimeout(UpdateProgramInfo , timeToUpdate);
        console.log("milisec to update: " + timeToUpdate);
    })
    .catch(error => console.error('Error al cargar el contenido:', error));
}

// setTimeout(() => { audio.play() }, 5000);

// let hasInteract = false

// document.addEventListener('click', function() {
//     if(!hasInteract) {
//         hasInteract = true;
//         audio.play().catch(error => {
//             console.log('Error al reproducir audio:', error.message);
//         });
//     }
// });

window.addEventListener('focus', function() {
    // console.log('asdLa aplicación web ha vuelto al primer plano');
    clearTimeout(timeoutId);
    UpdateProgramInfo();
});