<?php

class EvaluacionesSeeder {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function run() {
        $atletas = $this->db->query("SELECT id FROM atletas")->fetchAll(PDO::FETCH_COLUMN);
        $evaluadores = $this->db->query("SELECT id FROM evaluadores")->fetchAll(PDO::FETCH_COLUMN);
        
        $estados = ['iniciada', 'en_progreso', 'completada', 'cancelada'];
        $climas = ['Soleado', 'Nublado', 'Lluvioso', 'Ventoso', 'Fresco'];
        
        // Create 2-5 evaluations per athlete
        foreach ($atletas as $atletaId) {
            $numEvaluaciones = rand(2, 5);
            
            for ($i = 0; $i < $numEvaluaciones; $i++) {
                $fechaEvaluacion = $this->randomDate('2024-01-01', date('Y-m-d'));
                $horaInicio = sprintf('%02d:%02d:00', rand(8, 17), rand(0, 1) * 30);
                $horaFin = date('H:i:00', strtotime($horaInicio) + rand(1800, 10800)); // 30 min to 3 hours later
                $estado = $estados[array_rand($estados)];
                $clima = $climas[array_rand($climas)];
                $temperatura = rand(15, 35) + (rand(0, 10) / 10); // Between 15.0 and 35.9°C
                $evaluadorId = $evaluadores[array_rand($evaluadores)];
                
                $this->db->query(
                    "INSERT INTO evaluaciones (
                        atleta_id, evaluador_id, fecha_evaluacion, hora_inicio, 
                        hora_fin, estado, clima, temperatura_ambiente
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
                    [
                        $atletaId,
                        $evaluadorId,
                        $fechaEvaluacion,
                        $horaInicio,
                        $horaFin,
                        $estado,
                        $clima,
                        $temperatura
                    ]
                );
            }
        }
    }
    
    private function randomDate($startDate, $endDate) {
        $min = strtotime($startDate);
        $max = strtotime($endDate);
        $val = rand($min, $max);
        return date('Y-m-d', $val);
    }
}
