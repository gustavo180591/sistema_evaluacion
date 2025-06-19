-- MIGRACIÓN SIMPLE: Solo agregar tabla evaluaciones y relación atleta-lugar
USE sistema_evaluacion;

-- 1. Crear tabla de evaluaciones
CREATE TABLE IF NOT EXISTS evaluaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    atleta_id INT NOT NULL,
    evaluador_id INT,
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
    FOREIGN KEY (lugar_id) REFERENCES lugares(id) ON DELETE SET NULL
);

-- 2. Verificar si la columna lugar_id ya existe en atletas
SET @sql = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE table_schema='sistema_evaluacion' 
        AND table_name='atletas' 
        AND column_name='lugar_id') > 0,
    'SELECT ''Columna lugar_id ya existe en atletas'' as message',
    'ALTER TABLE atletas ADD COLUMN lugar_id INT, ADD FOREIGN KEY (lugar_id) REFERENCES lugares(id) ON DELETE SET NULL'
));
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 3. Mostrar confirmación
SELECT 'MIGRACIÓN COMPLETADA - Tabla evaluaciones creada y atletas modificado' as status; 