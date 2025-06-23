-- Crear la base de datos y configurar usuario
CREATE DATABASE IF NOT EXISTS sistema_evaluacion CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sistema_evaluacion;

-- Crear tabla usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('administrador', 'evaluador', 'usuario') NOT NULL DEFAULT 'usuario',
    estado ENUM('activo', 'inactivo') NOT NULL DEFAULT 'activo',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT chk_email_format CHECK (email REGEXP '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar usuario administrador por defecto
INSERT INTO usuarios (nombre, apellido, email, password, rol, estado) 
VALUES (
    'Administrador', 
    'Principal',
    'admin@example.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password: password
    'administrador',
    'activo'
);

-- Crear tabla evaluaciones
CREATE TABLE IF NOT EXISTS evaluaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    atleta_id INT NOT NULL,
    evaluador_id INT NOT NULL,
    fecha_evaluacion DATE NOT NULL,
    hora_inicio TIME,
    hora_fin TIME,
    estado ENUM('iniciada', 'en_progreso', 'completada', 'cancelada') DEFAULT 'iniciada',
    observaciones TEXT,
    clima VARCHAR(100),
    temperatura_ambiente DECIMAL(4,1),
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (atleta_id) REFERENCES atletas(id) ON DELETE CASCADE,
    FOREIGN KEY (evaluador_id) REFERENCES evaluadores(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de Evaluadores
CREATE TABLE evaluadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    email VARCHAR(150) UNIQUE,
    password VARCHAR(255),
    fecha_alta DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Atletas
CREATE TABLE atletas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    evaluador_id INT,
    lugar_id INT,
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
    discapacidad_id INT,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (evaluador_id) REFERENCES evaluadores(id) ON DELETE SET NULL,
    FOREIGN KEY (discapacidad_id) REFERENCES discapacidades(id) ON DELETE SET NULL
);

-- Tabla de Discapacidades
CREATE TABLE discapacidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    tipo ENUM('fisica', 'visual', 'auditiva', 'intelectual', 'psicosocial') NOT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Insertar discapacidades iniciales
INSERT INTO discapacidades (nombre, descripcion, tipo) VALUES
('Amputación', 'Amputación parcial o total de miembros', 'fisica'),
('Paraplejia', 'Parálisis de las piernas', 'fisica'),
('Ceguera', 'Perdida total de la visión', 'visual'),
('Baja visión', 'Limitación significativa de la visión', 'visual'),
('Sordera', 'Perdida total de la audición', 'auditiva'),
('Baja audición', 'Limitación significativa de la audición', 'auditiva'),
('Parálisis cerebral', 'Trastorno del movimiento y postura', 'fisica'),
('Autismo', 'Trastorno del espectro autista', 'intelectual'),
('Síndrome de Down', 'Trastorno genético', 'intelectual'),
('Trastorno del espectro autista', 'Trastorno del neurodesarrollo', 'intelectual');

-- Tabla de Lugares
CREATE TABLE lugares (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    zona VARCHAR(100),
    direccion VARCHAR(255)
);

-- Tabla de Tests
CREATE TABLE tests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_test VARCHAR(100),
    descripcion TEXT
);

-- Tabla de Resultados
CREATE TABLE resultados_tests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    atleta_id INT,
    evaluador_id INT,
    test_id INT,
    lugar_id INT,
    fecha_test DATE,
    resultado_json JSON,
    FOREIGN KEY (atleta_id) REFERENCES atletas(id) ON DELETE CASCADE,
    FOREIGN KEY (evaluador_id) REFERENCES evaluadores(id) ON DELETE SET NULL,
    FOREIGN KEY (test_id) REFERENCES tests(id),
    FOREIGN KEY (lugar_id) REFERENCES lugares(id)
);
