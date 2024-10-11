<div id="original_input">
    <div id="text">
        <label for="nombre_programa">nombre del programa</label>
        <input type="text">
    </div>
    <div id="descripcion">
        <label for="descripcion">descripcion</label>
        <textarea></textarea>
    </div>

    <div id="programa" class="form">
        <div id="nombre_programa">
            <label for="nombre_programa">nombre del programa</label>
            <input type="text">
        </div>
        <div id="input_file">
            <label for=""></label>
            <div>
                <input type="file" name="fileToUpload" id="fileInput" accept="image/*">
                <div id="feedback_file"></div>
            </div>
        </div>
        <div id="descripcion">
            <label for="descripcion">descripcion</label>
            <textarea></textarea>
        </div>
        <div id="schedules_container">
            <div id="originalschedule" class="schedule">
                <div class="days_container">
                    <ul class="days_list">
                    </ul>
                </div>
                <label for="">Hora inicio</label>
                <input type="time" id="hora_inicio">
                <label for="">Hora final</label>
                <input type="time" id="hora_fin">
                <label for="">Es retrasmision</label>
                <input type="checkbox" id="es_retransmision">
                <div class="feedback_schedules"></div>
            </div>
            <button id="addNewSchedule">añadir nuevo horario</button>
        </div>
        <h3>Presentador(es)</h3>
        <div class="lists-container">
            <div>
                <h3>Seleccionados</h3>
                <ul id="optionsSelected" class="options">
                </ul>
            </div>
            <div>
                <h3>Disponibles</h3>
                <ul id="optionsAvailable" class="options">
                </ul>
            </div>
        </div>
        <h3>Genero(s)</h3>
        <div id="generos" class="container">
            <div>
                <h3>Generos seleccionados</h3>
                <ul id="generosSelected" class="generos">
                    
                </ul>
            </div>
            <div>
                <h3>Generos disponibles</h3>
                <ul id="generosAvailable" class="generos">
                    <?php
                        $generos = SQL::Select(SQL::GENERO, [], ["id_genero", "nombre_genero"])->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($generos as $genero) {
                            echo '<li id="' . $genero["id_genero"] . '">' . $genero["nombre_genero"] . '</li>';
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div id="horario" class="form">
        
    </div>
    <div id="presentador" class="form">
        <div id="nombre_presentador">
            <label for="">nombre del presentador</label>
            <input type="text">
        </div>
        <div id="biografia">
            <label for="">biografia</label>
            <textarea></textarea>
        </div>
        <div id="input_file">
            <label for=""></label>
            <div class="drop-zone" id="drop-zone" for="fileInput">
                TODO: ARREGLAR ARRASTRADO DE ARCHIVO!!!
            </div>
            <input type="file" name="fileToUpload" id="fileInput" accept="image/*" style="display:none;">
            <div id="feedback_file"></div>
        </div>
    </div>
    <div id="genero" class="form">
        <div>
            <label for="">nombre del genero</label>
            <input type="text" id="nombre_genero">
        </div>
    </div>
    <div id="user" class="form">
        <div>
            <label for="">nombre usuario</label>
            <input type="text" id="username"></input>
        </div>
        <div>
            <label for="">correo</label>
            <input type="email" id="email"></input>
        </div>
        <div>
            <label for="">contraseña</label>
            <input type="password" id="password"></input>
        </div>
        <div>
            <label for="">nombre completo</label>
            <input type="text" id="nombre_completo"></input>
        </div>
        <div>
            <label for="">rol</label>
            <input type="email" id="email"></input>
        </div>
        <div>
            <label for="">rol</label>
            <select id="enumContent" id="rol">
                <option>Seleccione un rol</option>
                <?php
                    foreach (SQL::GetEnumValues(SQL::USER, "rol") as $value) {
                        echo "<option>$value</option>";
                    }
                ?>
            </select>
        </div>
        <div>
            <label for="">cuenta activa</label>
            <input type="checkbox" id="cuenta_activa" checked>
        </div>
    </div>
    <div class="clearfix">
        <button type="button" id="cancelBtn" class="modalBtn">Cancel</button>
        <button type="button" id="confirmBtn" class="modalBtn">Crear</button>
    </div> 
</div>