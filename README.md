# RadioUAA
***RadioUAA web page***

---

#### Data Base:
```sql
CREATE DATABASE radio_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE radio_db;

CREATE TABLE programas (
    id_programa INT PRIMARY KEY AUTO_INCREMENT,
    nombre_programa VARCHAR(255) NOT NULL,
    url_imagen VARCHAR(255),
    descripcion TEXT
) 
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE generos (
    id_genero INT PRIMARY KEY AUTO_INCREMENT,
    nombre_genero VARCHAR(255) NOT NULL
) 
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE programa_genero (
    id_programa INT,
    id_genero INT,
    PRIMARY KEY (id_programa, id_genero),
    FOREIGN KEY (id_programa) REFERENCES programas(id_programa),
    FOREIGN KEY (id_genero) REFERENCES generos(id_genero)
) 
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE presentadores (
    id_presentador INT PRIMARY KEY AUTO_INCREMENT,
    nombre_presentador VARCHAR(255) NOT NULL,
    biografia TEXT,
    url_foto VARCHAR(255)
) 
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE programa_presentador (
    id_programa INT,
    id_presentador INT,
    PRIMARY KEY (id_programa, id_presentador),
    FOREIGN KEY (id_programa) REFERENCES programas(id_programa),
    FOREIGN KEY (id_presentador) REFERENCES presentadores(id_presentador)
) 
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE horarios (
    id_horario INT PRIMARY KEY AUTO_INCREMENT,
    id_programa INT,
    dia_semana ENUM('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'),
    hora_inicio TIME,
    hora_fin TIME,
    es_retransmision BOOLEAN,
    FOREIGN KEY (id_programa) REFERENCES programas(id_programa)
) 
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```
