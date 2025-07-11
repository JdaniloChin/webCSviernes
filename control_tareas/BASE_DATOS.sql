CREATE DATABASE IF NOT EXISTS control_tareas;
USE control_tareas;

DROP TABLE usuarios;
CREATE TABLE usuarios (
Id_usuario INT AUTO_INCREMENT PRIMARY KEY,
Nombre VARCHAR(200) NOT NULL,
Email VARCHAR(100) NOT NULL,
Fecha_Nacimiento DATE NOT NULL,
Contrasenia VARCHAR(50) NOT NULL
);

