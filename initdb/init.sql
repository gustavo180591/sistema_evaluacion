CREATE DATABASE IF NOT EXISTS sistema_evaluacion CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sistema_evaluacion;

-- Tabla de Evaluadores
CREATE TABLE evaluadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    email VARCHAR(150) UNIQUE,
    password VARCHAR(255),
    fecha_alta DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Usuarios (admin o evaluador)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rol ENUM('administrador', 'evaluador') NOT NULL,
    referencia_id INT,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (referencia_id) REFERENCES evaluadores(id) ON DELETE SET NULL
);

-- Tabla de Atletas
CREATE TABLE atletas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    evaluador_id INT,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    dni VARCHAR(20),
    sexo ENUM('M','F','Otro'),
    fecha_nacimiento DATE,
    altura_cm DECIMAL(5,2),
    peso_kg DECIMAL(5,2),
    envergadura_cm DECIMAL(5,2),
    altura_sentado_cm DECIMAL(5,2),
    lateralidad_visual ENUM('Izquierdo', 'Derecho', 'Ambidiestro'),
    lateralidad_podal ENUM('Izquierdo', 'Derecho', 'Ambidiestro'),
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (evaluador_id) REFERENCES evaluadores(id) ON DELETE SET NULL
);

-- Tabla de Lugares
CREATE TABLE lugares (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    zona VARCHAR(100),
    direccion VARCHAR(255)
);

-- Insertar usuario administrador por defecto
INSERT INTO evaluadores (nombre, apellido, email, password) VALUES 
('Admin', 'Admin', 'admin@admin.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO usuarios (rol, referencia_id, email, password) VALUES 
('administrador', (SELECT id FROM evaluadores WHERE email = 'admin@admin.com'), 'admin@admin.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
