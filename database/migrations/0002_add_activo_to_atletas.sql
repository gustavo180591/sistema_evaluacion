-- Migración: Agregar campo activo a tabla atletas para eliminación suave
-- Fecha: 2024
-- Descripción: Permite ocultar atletas en lugar de eliminarlos permanentemente

-- Agregar campo activo con valor por defecto TRUE
ALTER TABLE atletas ADD COLUMN activo BOOLEAN DEFAULT TRUE;

-- Marcar todos los atletas existentes como activos
UPDATE atletas SET activo = TRUE WHERE activo IS NULL;

-- Agregar índice para mejorar performance en consultas con filtro activo
CREATE INDEX idx_atletas_activo ON atletas(activo);

-- Comentario: 
-- activo = TRUE: Atleta visible en el sistema
-- activo = FALSE: Atleta oculto (eliminación suave) 