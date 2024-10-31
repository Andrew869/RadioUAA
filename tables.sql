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
    dia_semana ENUM('1', '2', '3', '4', '5', '6', '7'),
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

INSERT INTO user (username, email, password_hash, nombre_completo, rol,  cuenta_activa) 
VALUES ('admin', 'admin1@example.com', SHA2('Admin123', 256), 'Juan Admin', 'Admin', TRUE);