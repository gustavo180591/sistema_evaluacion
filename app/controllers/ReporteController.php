<?php

class ReporteController {
    
    public function estadisticas() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }
        
        // Obtener estadísticas básicas
        $evaluadorId = $_SESSION['usuario_id'];
        
        try {
            $db = Database::getConnection();
            
            // Estadísticas generales
            $stats = [
                'total_atletas' => 0,
                'total_evaluaciones' => 0,
                'total_tests' => 0,
                'evaluaciones_mes' => 0,
                'atletas_por_sexo' => [],
                'tests_mas_usados' => [],
                'evaluaciones_recientes' => [],
                'rendimiento_promedio' => []
            ];
            
            // Total de atletas del evaluador
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM atletas WHERE evaluador_id = ?");
            $stmt->execute([$evaluadorId]);
            $stats['total_atletas'] = $stmt->fetch()['total'];
            
            // Total de evaluaciones/tests realizados
            $stmt = $db->prepare("SELECT COUNT(*) as total FROM resultados_tests WHERE evaluador_id = ?");
            $stmt->execute([$evaluadorId]);
            $stats['total_tests'] = $stmt->fetch()['total'];
            
            // Evaluaciones del mes actual
            $stmt = $db->prepare("SELECT COUNT(*) as total FROM resultados_tests WHERE evaluador_id = ? AND MONTH(fecha_test) = MONTH(CURRENT_DATE()) AND YEAR(fecha_test) = YEAR(CURRENT_DATE())");
            $stmt->execute([$evaluadorId]);
            $stats['evaluaciones_mes'] = $stmt->fetch()['total'];
            
            // Atletas por sexo
            $stmt = $db->prepare("SELECT sexo, COUNT(*) as cantidad FROM atletas WHERE evaluador_id = ? GROUP BY sexo");
            $stmt->execute([$evaluadorId]);
            while ($row = $stmt->fetch()) {
                $stats['atletas_por_sexo'][] = $row;
            }
            
            // Tests más utilizados
            $stmt = $db->prepare("
                SELECT t.nombre_test, COUNT(rt.test_id) as cantidad 
                FROM resultados_tests rt 
                JOIN tests t ON rt.test_id = t.id 
                WHERE rt.evaluador_id = ? 
                GROUP BY rt.test_id, t.nombre_test 
                ORDER BY cantidad DESC 
                LIMIT 5
            ");
            $stmt->execute([$evaluadorId]);
            while ($row = $stmt->fetch()) {
                $stats['tests_mas_usados'][] = $row;
            }
            
            // Evaluaciones recientes
            $stmt = $db->prepare("
                SELECT 
                    CONCAT(a.nombre, ' ', a.apellido) as atleta,
                    t.nombre_test,
                    rt.fecha_test,
                    l.nombre as lugar
                FROM resultados_tests rt
                JOIN atletas a ON rt.atleta_id = a.id
                JOIN tests t ON rt.test_id = t.id
                JOIN lugares l ON rt.lugar_id = l.id
                WHERE rt.evaluador_id = ?
                ORDER BY rt.fecha_test DESC
                LIMIT 10
            ");
            $stmt->execute([$evaluadorId]);
            while ($row = $stmt->fetch()) {
                $stats['evaluaciones_recientes'][] = $row;
            }
            
            require_once __DIR__ . '/../views/reportes/estadisticas.php';
            
        } catch (Exception $e) {
            error_log("Error en estadísticas: " . $e->getMessage());
            $error = "Error al cargar las estadísticas: " . $e->getMessage();
            require_once __DIR__ . '/../views/reportes/estadisticas.php';
        }
    }
    
    public function exportar() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }
        
        require_once __DIR__ . '/../views/reportes/exportar.php';
    }
    
    public function generarExcel() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }
        
        // Aquí iría la lógica para generar el Excel
        // Por ahora redirigimos con mensaje
        header('Location: index.php?controller=Reporte&action=exportar&success=excel_generado');
        exit;
    }
    
    public function generarPDF() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }
        
        // Aquí iría la lógica para generar el PDF
        // Por ahora redirigimos con mensaje
        header('Location: index.php?controller=Reporte&action=exportar&success=pdf_generado');
        exit;
    }
} 