-- MIGRACIÓN: Agregar sistema de evaluaciones
-- Este script actualiza la base de datos existente

USE sistema_evaluacion;

-- 1. Crear tabla de evaluaciones
CREATE TABLE IF NOT EXISTS evaluaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    atleta_id INT NOT NULL,
    evaluador_id INT NOT NULL,
    lugar_id INT,
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
    FOREIGN KEY (evaluador_id) REFERENCES evaluadores(id) ON DELETE SET NULL,
    FOREIGN KEY (lugar_id) REFERENCES lugares(id)
);

-- 2. Modificar tabla tests si no tiene las nuevas columnas
ALTER TABLE tests 
ADD COLUMN IF NOT EXISTS unidad_medida VARCHAR(50) DEFAULT '',
ADD COLUMN IF NOT EXISTS activo BOOLEAN DEFAULT TRUE;

-- 3. Crear nueva tabla de resultados con evaluaciones
CREATE TABLE IF NOT EXISTS resultados_tests_new (
    id INT AUTO_INCREMENT PRIMARY KEY,
    evaluacion_id INT NOT NULL,
    test_id INT NOT NULL,
    resultado_valor DECIMAL(10,3),
    resultado_json JSON,
    orden_realizacion TINYINT,
    observaciones_test TEXT,
    fecha_realizacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (evaluacion_id) REFERENCES evaluaciones(id) ON DELETE CASCADE,
    FOREIGN KEY (test_id) REFERENCES tests(id)
);

-- 4. Migrar datos existentes (si los hay)
-- Crear evaluaciones automáticas para resultados existentes
INSERT INTO evaluaciones (atleta_id, evaluador_id, lugar_id, fecha_evaluacion, estado)
SELECT DISTINCT 
    r.atleta_id, 
    r.evaluador_id, 
    r.lugar_id, 
    r.fecha_test,
    'completada'
FROM resultados_tests r
WHERE NOT EXISTS (
    SELECT 1 FROM evaluaciones e 
    WHERE e.atleta_id = r.atleta_id 
    AND e.evaluador_id = r.evaluador_id 
    AND e.fecha_evaluacion = r.fecha_test
);

-- 5. Migrar resultados a la nueva tabla
INSERT INTO resultados_tests_new (evaluacion_id, test_id, resultado_valor, resultado_json, fecha_realizacion)
SELECT 
    e.id as evaluacion_id,
    r.test_id,
    CAST(JSON_UNQUOTE(JSON_EXTRACT(r.resultado_json, '$.valor')) AS DECIMAL(10,3)) as resultado_valor,
    r.resultado_json,
    CONCAT(DATE(r.fecha_test), ' ', IFNULL(TIME(r.fecha_test), '00:00:00'))
FROM resultados_tests r
JOIN evaluaciones e ON (
    e.atleta_id = r.atleta_id 
    AND e.evaluador_id = r.evaluador_id 
    AND e.fecha_evaluacion = r.fecha_test
);

-- 6. Renombrar tablas
DROP TABLE IF EXISTS resultados_tests_old;
RENAME TABLE resultados_tests TO resultados_tests_old;
RENAME TABLE resultados_tests_new TO resultados_tests;

-- 7. Insertar datos de ejemplo si las tablas están vacías
INSERT IGNORE INTO lugares (nombre, zona, direccion) VALUES 
('Polideportivo Central', 'Centro', 'Av. Principal 123'),
('Campo de Deportes Norte', 'Zona Norte', 'Calle Deportiva 456'),
('Gimnasio Municipal', 'Zona Sur', 'Av. Municipal 789');

INSERT IGNORE INTO tests (nombre_test, descripcion, unidad_medida, activo) VALUES 
('Velocidad 30m', 'Prueba de velocidad en 30 metros', 'segundos', TRUE),
('Salto en Largo', 'Salto horizontal sin impulso', 'metros', TRUE),
('Fuerza de Prensión', 'Fuerza de agarre de mano', 'kg', TRUE),
('Agilidad T-Test', 'Prueba de agilidad en T', 'segundos', TRUE),
('Resistencia 12 min', 'Test de Cooper - distancia en 12 minutos', 'metros', TRUE),
('Flexibilidad Sit&Reach', 'Flexibilidad de tronco hacia adelante', 'centímetros', TRUE),
('Salto Vertical', 'Altura máxima de salto vertical', 'centímetros', TRUE);

-- 8. Mostrar resumen de la migración
SELECT 'MIGRACIÓN COMPLETADA' as status;
SELECT COUNT(*) as total_evaluaciones FROM evaluaciones;
SELECT COUNT(*) as total_resultados FROM resultados_tests;
SELECT COUNT(*) as total_tests FROM tests;
SELECT COUNT(*) as total_lugares FROM lugares; 