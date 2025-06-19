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

-- Tabla de Tests (catálogo de tipos de pruebas disponibles)
CREATE TABLE tests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_test VARCHAR(100),
    descripcion TEXT,
    unidad_medida VARCHAR(50), -- ej: segundos, metros, kg, repeticiones
    activo BOOLEAN DEFAULT TRUE
);

-- NUEVA TABLA: Evaluaciones (sesión completa de evaluación)
CREATE TABLE evaluaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    atleta_id INT NOT NULL,
    evaluador_id INT NOT NULL,
    lugar_id INT,
    fecha_evaluacion DATE NOT NULL,
    hora_inicio TIME,
    hora_fin TIME,
    estado ENUM('iniciada', 'en_progreso', 'completada', 'cancelada') DEFAULT 'iniciada',
    observaciones TEXT,
    clima VARCHAR(100), -- condiciones climáticas si es relevante
    temperatura_ambiente DECIMAL(4,1), -- grados celsius
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (atleta_id) REFERENCES atletas(id) ON DELETE CASCADE,
    FOREIGN KEY (evaluador_id) REFERENCES evaluadores(id) ON DELETE SET NULL,
    FOREIGN KEY (lugar_id) REFERENCES lugares(id)
);

-- TABLA MODIFICADA: Resultados de Tests (ahora pertenecen a una evaluación)
CREATE TABLE resultados_tests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    evaluacion_id INT NOT NULL,
    test_id INT NOT NULL,
    resultado_valor DECIMAL(10,3), -- valor numérico principal del test
    resultado_json JSON, -- datos adicionales del test (tiempos parciales, etc.)
    orden_realizacion TINYINT, -- orden en que se realizó el test (1, 2, 3...)
    observaciones_test TEXT, -- observaciones específicas de este test
    fecha_realizacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (evaluacion_id) REFERENCES evaluaciones(id) ON DELETE CASCADE,
    FOREIGN KEY (test_id) REFERENCES tests(id)
);

-- Tabla para insertar algunos datos de ejemplo
INSERT INTO lugares (nombre, zona, direccion) VALUES 
('Polideportivo Central', 'Centro', 'Av. Principal 123'),
('Campo de Deportes Norte', 'Zona Norte', 'Calle Deportiva 456'),
('Gimnasio Municipal', 'Zona Sur', 'Av. Municipal 789');

INSERT INTO tests (nombre_test, descripcion, unidad_medida) VALUES 
('Velocidad 30m', 'Prueba de velocidad en 30 metros', 'segundos'),
('Salto en Largo', 'Salto horizontal sin impulso', 'metros'),
('Fuerza de Prensión', 'Fuerza de agarre de mano', 'kg'),
('Agilidad T-Test', 'Prueba de agilidad en T', 'segundos'),
('Resistencia 12 min', 'Test de Cooper - distancia en 12 minutos', 'metros'),
('Flexibilidad Sit&Reach', 'Flexibilidad de tronco hacia adelante', 'centímetros'),
('Salto Vertical', 'Altura máxima de salto vertical', 'centímetros'); 