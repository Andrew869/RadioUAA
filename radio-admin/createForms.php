<div id="createModal" class="modal">
    <span class="close">&times;</span>
    <div class="modal-content">
        <div class="container">
            <div id="programa" class="form">
                <div>
                    <label for="nombre_programa">nombre del programa</label>
                    <input type="text" id="nombre_programa">
                </div>
                <!-- <div class="drop-zone" id="drop-zone" for="fileInput">
                    Arrastra y suelta tu archivo aquí o haz clic para seleccionar
                </div>
                <input type="file" name="fileToUpload" id="fileInput" accept="image/*" style="display:none;"> -->
                <div id="input_file">
                    <label for=""></label>
                    <div class="drop-zone" id="drop-zone" for="fileInput">
                        <!-- Arrastra y suelta tu archivo aquí o haz clic para seleccionar -->
                        TODO: ARREGLAR ARRASTRADO DE ARCHIVO!!!
                    </div>
                    <input type="file" name="fileToUpload" id="fileInput" accept="image/*" style="display:none;">
                    <div id="feedback_file"></div>
                </div>
                <div>
                    <label for="descripcion">descripcion</label>
                    <textarea id="descripcion"></textarea>
                </div>
                <div id="schedules_container">
                    <div id="originalschedule" class="schedule">
                        <div class="days_container">
                            <ul class="days_list">
                                <?php 
                                    foreach (SQL::GetEnumValues(SQL::HORARIO, "dia_semana") as $dia) {
                                        echo "<li>$dia</li>";
                                    }
                                ?>
                            </ul>
                        </div>
                        <label for="">Hora inicio</label>
                        <input type="time" id="hora_inicio">
                        <label for="">Hora final</label>
                        <input type="time" id="hora_fin">
                        <label for="">Es retrasmision</label>
                        <input type="checkbox" id="es_retransmision">
                        <div class="txtHint"></div>
                    </div>
                    <button id="addNewSchedule">añadir nuevo horario</button>
                </div>
                <h3>Presentador(es)</h3>
                <div class="container">
                    <div>
                        <h3>Presentadores seleccionados</h3>
                        <ul id="presentadoresSelected" class="presentadores">
                                
                        </ul>
                    </div>
                    <div>
                        <h3>Presentadores disponibles</h3>
                        <ul id="presentadoresAvailable" class="presentadores">
                            <?php
                                $presentadores = SQL::Select(SQL::PRESENTADOR, [], ["id_presentador", "nombre_presentador"])->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($presentadores as $presentador) {
                                    echo '<li id_presentador="' . $presentador["id_presentador"] . '">' . $presentador["nombre_presentador"] . '</li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <h3>Genero(s)</h3>
                <div class="container">
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
                <div id="times_container">
                    <div class="times">
                        <div class="days_container">
                            <ul class="days_list">
                                <?php 
                                    foreach (SQL::GetEnumValues(SQL::HORARIO, "dia_semana") as $dia) {
                                        echo "<li>$dia</li>";
                                    }
                                ?>
                            </ul>
                        </div>
                        <label for="">Hora inicio</label>
                        <input type="time" field_name="hora_inicio">
                        <label for="">Hora final</label>
                        <input type="time" field_name="hora_fin">
                        <label for="">Es retrasmision</label>
                        <input type="checkbox" field_name="es_retransmision">
                        <div class="txtHint"></div>
                    </div>
                </div>
                <a id="button_addNew">añadir nuevo horario</a>
            </div>
            <div id="presentador" class="form">
                <div>
                    <label for="">nombre del presentador</label>
                    <input type="text" id="nombre_presentador">
                </div>
                <div>
                    <label for="">biografia</label>
                    <textarea id="biografia"></textarea>
                </div>
                <div id="input_file">
                    <label for=""></label>
                    <div class="drop-zone" id="drop-zone" for="fileInput">
                        <!-- Arrastra y suelta tu archivo aquí o haz clic para seleccionar -->
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
    </div>
</div>