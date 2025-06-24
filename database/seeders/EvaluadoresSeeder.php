<?php

class EvaluadoresSeeder {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function run() {
        $evaluadores = [
            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'email' => 'juan.perez@colegio.edu',
                'password' => password_hash('password123', PASSWORD_DEFAULT)
            ],
            [
                'nombre' => 'María',
                'apellido' => 'González',
                'email' => 'maria.gonzalez@colegio.edu',
                'password' => password_hash('password123', PASSWORD_DEFAULT)
            ],
            [
                'nombre' => 'Carlos',
                'apellido' => 'Rodríguez',
                'email' => 'carlos.rodriguez@colegio.edu',
                'password' => password_hash('password123', PASSWORD_DEFAULT)
            ],
            [
                'nombre' => 'Ana',
                'apellido' => 'Martínez',
                'email' => 'ana.martinez@colegio.edu',
                'password' => password_hash('password123', PASSWORD_DEFAULT)
            ]
        ];
        
        foreach ($evaluadores as $evaluador) {
            $this->db->query(
                "INSERT INTO evaluadores (nombre, apellido, email, password) VALUES (?, ?, ?, ?)",
                [$evaluador['nombre'], $evaluador['apellido'], $evaluador['email'], $evaluador['password']]
            );
        }
    }
}
