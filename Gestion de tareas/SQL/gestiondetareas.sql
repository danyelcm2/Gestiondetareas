CREATE DATABASE gestion_tareas;

USE gestion_tareas;

-- Tabla Departamentos
CREATE TABLE departamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- Tabla Usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    codigo_departamento INT NOT NULL,
    role ENUM('usuario', 'administrador', 'informatico') NOT NULL,
    FOREIGN KEY (codigo_departamento) REFERENCES departamentos(id)
);

-- Tabla Prioridades
CREATE TABLE prioridades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nivel INT NOT NULL,  -- 1 = Alta, 2 = Media, 3 = Baja
    descripcion VARCHAR(100) NOT NULL
);

-- Tabla Tareas
CREATE TABLE tareas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descripcion TEXT NOT NULL,
    id_departamento INT NOT NULL,  -- Departamento solicitante
    id_prioridad INT NOT NULL,     -- Prioridad de la tarea
    estado ENUM('pendiente', 'en progreso', 'completada') NOT NULL DEFAULT 'pendiente',
    fecha_solicitud TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_resolucion TIMESTAMP NULL,
    FOREIGN KEY (id_departamento) REFERENCES departamentos(id),
    FOREIGN KEY (id_prioridad) REFERENCES prioridades(id)
);
