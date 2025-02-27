# RadioUAA
***RadioUAA web page***

---

#### Data Base:
```sql
CREATE DATABASE radio_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE radio_db;

CREATE TABLE programa (
    id_programa INT PRIMARY KEY AUTO_INCREMENT,
    nombre_programa VARCHAR(64) NOT NULL,
    url_img VARCHAR(255),
    descripcion TEXT
) 
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE genero (
    id_genero INT PRIMARY KEY AUTO_INCREMENT,
    nombre_genero VARCHAR(64) NOT NULL
) 
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE programa_genero (
    id_programa INT,
    id_genero INT,
    PRIMARY KEY (id_programa, id_genero),
    FOREIGN KEY (id_programa) REFERENCES programa(id_programa),
    FOREIGN KEY (id_genero) REFERENCES genero(id_genero)
) 
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE presentador (
    id_presentador INT PRIMARY KEY AUTO_INCREMENT,
    nombre_presentador VARCHAR(64) NOT NULL,
    biografia TEXT,
    url_img VARCHAR(255)
) 
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE programa_presentador (
    id_programa INT,
    id_presentador INT,
    PRIMARY KEY (id_programa, id_presentador),
    FOREIGN KEY (id_programa) REFERENCES programa(id_programa),
    FOREIGN KEY (id_presentador) REFERENCES presentador(id_presentador)
) 
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE horario (
    id_horario INT PRIMARY KEY AUTO_INCREMENT,
    id_programa INT,
    dia_semana ENUM('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'),
    hora_inicio TIME,
    hora_fin TIME,
    es_retransmision BOOLEAN,
    FOREIGN KEY (id_programa) REFERENCES programa(id_programa)
) 
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE user (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(64) UNIQUE NOT NULL,
    email VARCHAR(64) UNIQUE NOT NULL,
    password_hash CHAR(64) NOT NULL,
    nombre_completo VARCHAR(64),
    rol ENUM('Admin', 'Editor', 'Moderador') NOT NULL,
    cuenta_activa BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultimo_acceso TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    session_token CHAR(32)
)
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

---


#### Insertions:
```sql
-- Insertar programas
INSERT INTO programa (nombre_programa, url_imagen, descripcion) 
VALUES ('Mañanas en la Radio', 'resources/img/programa_default.jpg', 'Programa matutino con noticias y entrevistas.'),
       ('Ritmos del Sábado', 'resources/img/programa_default.jpg', 'Programa musical con los mejores éxitos del momento.'),
       ('Deportes en Vivo', 'resources/img/programa_default.jpg', 'Cobertura en vivo de eventos deportivos.');

-- Insertar géneros
INSERT INTO genero (nombre_genero)
VALUES ('Noticias'), 
       ('Entretenimiento'), 
       ('Deportes'), 
       ('Música');

-- Relacionar programas con géneros
INSERT INTO programa_genero (id_programa, id_genero) 
VALUES (1, 1),  -- "Mañanas en la Radio" es de género "Noticias"
       (1, 2),  -- "Mañanas en la Radio" también es de género "Entretenimiento"
       (2, 4),  -- "Ritmos del Sábado" es de género "Música"
       (3, 3);  -- "Deportes en Vivo" es de género "Deportes"

-- Insertar presentadores
INSERT INTO presentador (nombre_presentador, biografia, url_foto) 
VALUES ('Juan Pérez', 'Periodista con 10 años de experiencia en medios.', 'resources/img/profile_default.jpg'),
       ('Ana Gómez', 'Locutora y productora con 8 años en la radio.', 'resources/img/profile_default.jpg'),
       ('Carlos Martínez', 'Experto en deportes con amplia trayectoria.', 'resources/img/profile_default.jpg');

-- Relacionar programas con presentadores
INSERT INTO programa_presentador (id_programa, id_presentador) 
VALUES (1, 1),  -- "Mañanas en la Radio" con Juan Pérez
       (1, 2),  -- "Mañanas en la Radio" con Ana Gómez
       (2, 2),  -- "Ritmos del Sábado" con Ana Gómez
       (3, 3);  -- "Deportes en Vivo" con Carlos Martínez

-- Insertar horarios
INSERT INTO horario (id_programa, dia_semana, hora_inicio, hora_fin, es_retransmision) 
VALUES (1, 'Lunes', '08:00:00', '10:00:00', FALSE),  -- "Mañanas en la Radio" en vivo los Lunes de 08:00 a 10:00
       (1, 'Sábado', '18:00:00', '20:00:00', TRUE),   -- Retransmisión de "Mañanas en la Radio" los Sábados de 18:00 a 20:00
       (2, 'Sábado', '20:00:00', '22:00:00', FALSE),  -- "Ritmos del Sábado" en vivo los Sábados de 20:00 a 22:00
       (3, 'Miércoles', '16:00:00', '18:00:00', FALSE); -- "Deportes en Vivo" en vivo los Miércoles de 16:00 a 18:00

-- Insertar un SuperAdmin (Acceso completo a todas las funciones.)
INSERT INTO user (username, email, password_hash, nombre_completo, rol,  cuenta_activa) 
VALUES ('admin1', 'admin1@example.com', SHA2('Admin123', 256), 'Juan Admin', 'Admin', TRUE);

-- Insertar un Editor (Puede modificar contenido.)
INSERT INTO user (username, email, password_hash, nombre_completo, rol,  cuenta_activa)  
VALUES ('editor1', 'editor1@example.com', SHA2('Editor123', 256), 'Ana Editor', 'Editor', TRUE);

-- Insertar un Moderador (Puede gestionar comentarios y usuarios.)
INSERT INTO user (username, email, password_hash, nombre_completo, rol,  cuenta_activa) 
VALUES ('moderador1', 'moderador1@example.com', SHA2('Moderador123', 256), 'Carlos Moderador', 'Moderador', TRUE);
```