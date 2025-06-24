<?php

class ResultadosTestsSeeder {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function run() {
        $evaluaciones = $this->db->query("SELECT id, atleta_id, evaluador_id, fecha_evaluacion FROM evaluaciones")->fetchAll(PDO::FETCH_ASSOC);
        $tests = $this->db->query("SELECT * FROM tests")->fetchAll(PDO::FETCH_ASSOC);
        $lugares = $this->db->query("SELECT id FROM lugares")->fetchAll(PDO::FETCH_COLUMN);
        
        foreach ($evaluaciones as $evaluacion) {
            // Each evaluation gets 3-6 random tests
            $numTests = rand(3, 6);
            $selectedTests = array_rand($tests, min($numTests, count($tests)));
            
            if (!is_array($selectedTests)) {
                $selectedTests = [$selectedTests];
            }
            
            foreach ($selectedTests as $testIndex) {
                $test = $tests[$testIndex];
                $resultado = $this->generateTestResult($test['nombre_test']);
                $lugarId = $lugares[array_rand($lugares)];
                
                $this->db->query(
                    "INSERT INTO resultados_tests (
                        evaluacion_id, atleta_id, evaluador_id, test_id, lugar_id, 
                        fecha_test, resultado_json
                    ) VALUES (?, ?, ?, ?, ?, ?, ?)",
                    [
                        $evaluacion['id'],
                        $evaluacion['atleta_id'],
                        $evaluacion['evaluador_id'],
                        $test['id'],
                        $lugarId,
                        $evaluacion['fecha_evaluacion'],
                        json_encode($resultado, JSON_UNESCAPED_UNICODE)
                    ]
                );
            }
        }
    }
    
    private function generateTestResult($testName) {
        switch ($testName) {
            case 'Test de Fuerza de Agarre':
                return [
                    'mano_derecha_1' => rand(20, 60),
                    'mano_derecha_2' => rand(20, 60),
                    'mano_derecha_3' => rand(20, 60),
                    'mano_izquierda_1' => rand(18, 58),
                    'mano_izquierda_2' => rand(18, 58),
                    'mano_izquierda_3' => rand(18, 58),
                    'unidad' => 'kg',
                    'observaciones' => 'Realizado según protocolo estándar'
                ];
                
            case 'Test de Salto Vertical':
                $altura = rand(30, 80);
                return [
                    'intento_1' => $altura,
                    'intento_2' => $altura + rand(-5, 5),
                    'intento_3' => $altura + rand(-5, 5),
                    'mejor_intento' => $altura + rand(0, 5),
                    'unidad' => 'cm',
                    'observaciones' => 'Técnica correcta en todos los intentos'
                ];
                
            case 'Test de Salto con Contramovimiento':
                $altura = rand(35, 85);
                return [
                    'intento_1' => $altura,
                    'intento_2' => $altura + rand(-5, 5),
                    'intento_3' => $altura + rand(-5, 5),
                    'mejor_intento' => $altura + rand(0, 5),
                    'unidad' => 'cm',
                    'tiempo_contacto' => rand(180, 300) / 100, // 1.8 - 3.0 segundos
                    'observaciones' => 'Buena ejecución del contramovimiento'
                ];
                
            case 'Test de Salto de Longitud':
                $distancia = rand(150, 300);
                return [
                    'intento_1' => $distancia,
                    'intento_2' => $distancia + rand(-20, 20),
                    'intento_3' => $distancia + rand(-20, 20),
                    'mejor_intento' => $distancia + rand(0, 20),
                    'unidad' => 'cm',
                    'observaciones' => 'Buena técnica de despegue y aterrizaje'
                ];
                
            case 'Test de Preferencia Motriz':
                return [
                    'mano_dominante' => rand(0, 1) ? 'Derecha' : 'Izquierda',
                    'pie_dominante' => rand(0, 1) ? 'Derecho' : 'Izquierdo',
                    'ojo_dominante' => rand(0, 1) ? 'Derecho' : 'Izquierdo',
                    'observaciones' => 'Evaluación de preferencia motriz completada'
                ];
                
            case 'Test de Lateralidad Visual':
                return [
                    'ojo_dominante' => rand(0, 1) ? 'Derecho' : 'Izquierdo',
                    'pruebas_realizadas' => 3,
                    'consistencia' => rand(80, 100) . '%',
                    'observaciones' => 'Preferencia lateral clara'
                ];
                
            case 'Test de Lateralidad Podal':
                return [
                    'pie_dominante' => rand(0, 1) ? 'Derecho' : 'Izquierdo',
                    'pruebas_realizadas' => 5,
                    'consistencia' => rand(80, 100) . '%',
                    'observaciones' => 'Buena estabilidad en ambos pies'
                ];
                
            case 'Test de Wells':
                $distancia = rand(10, 40);
                return [
                    'distancia_alcanzada' => $distancia,
                    'unidad' => 'cm',
                    'flexibilidad' => $this->getFlexibilidadNivel($distancia),
                    'observaciones' => 'Buena flexibilidad en la zona lumbar'
                ];
                
            case 'Test de Velocidad 20m':
                $tiempo = rand(350, 600) / 100; // 3.5 - 6.0 segundos
                return [
                    'tiempo' => $tiempo,
                    'unidad' => 'segundos',
                    'velocidad_media' => number_format(20 / $tiempo, 2) . ' m/s',
                    'observaciones' => 'Buena aceleración inicial'
                ];
                
            default:
                return [
                    'resultado' => 'Prueba completada',
                    'observaciones' => 'Sin datos específicos para este test'
                ];
        }
    }
    
    private function getFlexibilidadNivel($distancia) {
        if ($distancia >= 30) return 'Excelente';
        if ($distancia >= 20) return 'Buena';
        if ($distancia >= 10) return 'Regular';
        return 'Baja';
    }
}
