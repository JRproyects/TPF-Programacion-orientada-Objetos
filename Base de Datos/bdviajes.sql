-- Crear base de datos y usarla
DROP DATABASE IF EXISTS bdviajes;
CREATE DATABASE bdviajes;
USE bdviajes;

-- Tabla base: persona
CREATE TABLE persona (
    idPersona INT AUTO_INCREMENT PRIMARY KEY,
    pnombre VARCHAR(50) NOT NULL,
    papellido VARCHAR(50) NOT NULL
);

-- Tabla pasajero (hereda de persona)
CREATE TABLE pasajero (
    idPersona INT PRIMARY KEY,
    pdocumento VARCHAR(20) NOT NULL,
    ptelefono VARCHAR(20) NOT NULL,
    FOREIGN KEY (idPersona) REFERENCES persona(idPersona) ON DELETE CASCADE
);

-- Tabla empresa
CREATE TABLE empresa (
    idEmpresa INT AUTO_INCREMENT PRIMARY KEY,
    enombre VARCHAR(50) NOT NULL,
    eDireccion VARCHAR(255) NOT NULL
);

-- Tabla responsable (hereda de persona)
CREATE TABLE responsablev (
    idPersona INT PRIMARY KEY,
    rnumeroempleado INT UNIQUE NOT NULL,
    rnumerolicencia INT NOT NULL,
    idEmpresa INT,
    FOREIGN KEY (idPersona) REFERENCES persona(idPersona) ON DELETE CASCADE,
    FOREIGN KEY (idEmpresa) REFERENCES empresa(idEmpresa) ON DELETE SET NULL
);

-- Tabla de viajes
CREATE TABLE viaje (
    idviaje INT AUTO_INCREMENT PRIMARY KEY,
    vdestino VARCHAR(255),
    vcantmaxpasajeros INT NOT NULL,
    idEmpresa INT NOT NULL,
    rnumeroEmpleado INT,
    vimporte FLOAT NOT NULL,
    FOREIGN KEY (idEmpresa) REFERENCES empresa(idEmpresa) ON DELETE CASCADE,
    FOREIGN KEY (rnumeroEmpleado) REFERENCES responsablev(rnumeroempleado) ON DELETE SET NULL
);

-- Relación muchos a muchos entre viaje y pasajero
CREATE TABLE viaje_pasajero (
    idviaje INT,
    idPersona INT,
    PRIMARY KEY (idviaje, idPersona),
    FOREIGN KEY (idviaje) REFERENCES viaje(idviaje) ON DELETE CASCADE,
    FOREIGN KEY (idPersona) REFERENCES pasajero(idPersona) ON DELETE CASCADE
);

-- Tabla de auditoría
CREATE TABLE log_eventos (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    entidad VARCHAR(50),
    id_referencia INT,
    accion VARCHAR(20),
    usuario VARCHAR(100),
    fecha_log TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    detalle TEXT
);
CREATE TABLE log_eventos (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    entidad VARCHAR(50),
    id_referencia INT,
    accion VARCHAR(20),
    fecha_log TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario VARCHAR(100),
    detalle TEXT
);
