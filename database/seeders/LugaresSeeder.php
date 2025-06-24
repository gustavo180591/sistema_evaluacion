<?php

class LugaresSeeder {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function run() {
        $lugares = [
            ['nombre' => 'Colegio San José', 'zona' => 'Centro', 'direccion' => 'Av. Principal 123'],
            ['nombre' => 'Instituto Santa María', 'zona' => 'Norte', 'direccion' => 'Calle Falsa 456'],
            ['nombre' => 'Liceo República Argentina', 'zona' => 'Sur', 'direccion' => 'Av. Siempreviva 742'],
            ['nombre' => 'Colegio Técnico Nacional', 'zona' => 'Este', 'direccion' => 'Av. Las Heras 1234'],
            ['nombre' => 'Escuela Normal Superior', 'zona' => 'Oeste', 'direccion' => 'Calle Ficticia 567']
        ];
        
        foreach ($lugares as $lugar) {
            $this->db->query("INSERT INTO lugares (nombre, zona, direccion) VALUES (?, ?, ?)", 
                           [$lugar['nombre'], $lugar['zona'], $lugar['direccion']]);
        }
    }
}
