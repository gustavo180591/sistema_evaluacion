-- Añadir columna evaluacion_id a resultados_tests
ALTER TABLE resultados_tests ADD COLUMN evaluacion_id INT AFTER id;

-- Añadir la relación con evaluaciones
ALTER TABLE resultados_tests ADD CONSTRAINT fk_resultados_tests_evaluaciones
    FOREIGN KEY (evaluacion_id) REFERENCES evaluaciones(id) ON DELETE CASCADE;

-- Actualizar los registros existentes para establecer la relación con evaluaciones
UPDATE resultados_tests r
JOIN evaluaciones e ON r.atleta_id = e.atleta_id AND r.fecha_test = e.fecha_evaluacion
SET r.evaluacion_id = e.id;
