<div class="player container-radio-player">
    <div class="radio-player">
        <audio id="audio" src="https://streamingcwsradio30.com/8148/stream"></audio>
        <div id="loading" class="loading">Cargando...</div>
        <div class="station-info">
            <h2>Radio UAA</h2>
            <p id="metadata">Transmisión en vivo</p>
        </div>
        <div class="controls">
            <button id="playPauseBtn">
                <!-- <i id="playPauseIcon" class="fa-solid fa-play"></i> -->
                <?php echo GetSVG('resources/img/svg/play.svg', ["18px", "18px", "white"]) ?>
            </button>
            <button id="syncBtn">Sync</button>
        </div>
        <div class="volume-control">
            <label for="volumeSlider">Volumen:</label>
            <input
                type="range"
                id="volumeSlider"
                min="0"
                max="1"
                step="0.01"
                value="1"
            />
            <!-- <input type="range" id="seekBar" min="0" value="1"> -->
            <!-- <div id="currentTime">0:00</div> -->
            <!-- <div id="duration">0:00</div> -->
        </div>
    </div>
</div>