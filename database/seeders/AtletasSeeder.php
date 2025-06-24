<?php

class AtletasSeeder {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function run() {
        // Get evaluadores and lugares
        $evaluadores = $this->db->query("SELECT id FROM evaluadores")->fetchAll(PDO::FETCH_COLUMN);
        $lugares = $this->db->query("SELECT id FROM lugares")->fetchAll(PDO::FETCH_COLUMN);
        $discapacidades = $this->db->query("SELECT id FROM discapacidades")->fetchAll(PDO::FETCH_COLUMN);
        
        $nombres = ['Juan', 'María', 'Carlos', 'Ana', 'Pedro', 'Laura', 'Diego', 'Valentina', 'Andrés', 'Camila'];
        $apellidos = ['Gómez', 'López', 'Martínez', 'García', 'Rodríguez', 'Fernández', 'Pérez', 'González', 'Sánchez', 'Romero'];
        $sexos = ['M', 'F', 'Otro'];
        $lateralidades = ['Izquierdo', 'Derecho', 'Ambidiestro'];
        
        for ($i = 1; $i <= 30; $i++) {
            $nombre = $nombres[array_rand($nombres)];
            $apellido = $apellidos[array_rand($apellidos)];
            $sexo = $sexos[array_rand($sexos)];
            $fechaNacimiento = $this->randomDate('2000-01-01', '2015-12-31');
            $altura = rand(120, 190) + (rand(0, 10) / 10); // Entre 120.0 y 200.0 cm
            $peso = rand(30, 100) + (rand(0, 10) / 10); // Entre 30.0 y 110.0 kg
            $dni = str_pad(rand(10000000, 50000000), 8, '0', STR_PAD_LEFT);
            $evaluadorId = $evaluadores[array_rand($evaluadores)];
            $lugarId = $lugares[array_rand($lugares)];
            $discapacidadId = (rand(1, 10) > 7) ? $discapacidades[array_rand($discapacidades)] : null; // 30% chance de tener discapacidad
            
            $this->db->query(
                "INSERT INTO atletas (
                    evaluador_id, lugar_id, nombre, apellido, dni, sexo, fecha_nacimiento,
                    altura_cm, peso_kg, lateralidad_visual, lateralidad_podal, discapacidad_id
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
                [
                    $evaluadorId,
                    $lugarId,
                    $nombre,
                    $apellido,
                    $dni,
                    $sexo,
                    $fechaNacimiento,
                    $altura,
                    $peso,
                    $lateralidades[array_rand($lateralidades)],
                    $lateralidades[array_rand($lateralidades)],
                    $discapacidadId
                ]
            );
        }
    }
    
    private function randomDate($startDate, $endDate) {
        $min = strtotime($startDate);
        $max = strtotime($endDate);
        $val = rand($min, $max);
        return date('Y-m-d', $val);
    }
}
