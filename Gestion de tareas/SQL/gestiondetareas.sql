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
    id_usuario_asignado INT,  -- Nuevo campo para asignar el usuario
    FOREIGN KEY (id_departamento) REFERENCES departamentos(id),
    FOREIGN KEY (id_prioridad) REFERENCES prioridades(id),
    FOREIGN KEY (id_usuario_asignado) REFERENCES usuarios(id)  -- Relación con la tabla de usuarios
);


-- Insertar departamentos
INSERT INTO departamentos (nombre) VALUES 
('Finanzas'),
('Administración'),
('Informática');

-- Insertar prioridades
INSERT INTO prioridades (nivel, descripcion) VALUES 
(1, 'Alta'),
(2, 'Media'),
(3, 'Baja');

-- Insertar usuarios (Ejemplo)
INSERT INTO usuarios (nombre, correo, contraseña, codigo_departamento, role) VALUES 
('Juan Pérez', 'juan@ejemplo.com', '12345', 1, 'usuario'),
('María López', 'maria@ejemplo.com', '12345', 2, 'usuario'),
('Carlos Gómez', 'carlos@ejemplo.com', '12345', 3, 'informatico'),
('Ana Sánchez', 'ana@ejemplo.com', 'admin123', 1, 'administrador');

