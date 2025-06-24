<?php

class TestsSeeder {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function run() {
        $tests = [
            [
                'nombre_test' => 'Test de Fuerza de Agarre',
                'descripcion' => 'Evalúa la fuerza isométrica de los músculos de la mano y el antebrazo.'
            ],
            [
                'nombre_test' => 'Test de Salto Vertical',
                'descripcion' => 'Mide la altura que un atleta puede saltar desde una posición estática.'
            ],
            [
                'nombre_test' => 'Test de Salto con Contramovimiento',
                'descripcion' => 'Evalúa la capacidad de absorber y reutilizar energía para generar un salto vertical.'
            ],
            [
                'nombre_test' => 'Test de Salto de Longitud',
                'descripcion' => 'Mide la distancia que un atleta puede saltar desde una línea de despegue.'
            ],
            [
                'nombre_test' => 'Test de Preferencia Motriz',
                'descripcion' => 'Determina la mano o lado del cuerpo que una persona tiende a usar con mayor facilidad.'
            ],
            [
                'nombre_test' => 'Test de Lateralidad Visual',
                'descripcion' => 'Evalúa la preferencia por un ojo para realizar tareas que requieren coordinación visomotora.'
            ],
            [
                'nombre_test' => 'Test de Lateralidad Podal',
                'descripcion' => 'Evalúa la preferencia por un pie para realizar tareas que requieren equilibrio y control motor.'
            ],
            [
                'nombre_test' => 'Test de Wells',
                'descripcion' => 'Evalúa la flexibilidad, especialmente de los isquiotibiales y la zona baja de la espalda.'
            ],
            [
                'nombre_test' => 'Test de Velocidad 20m',
                'descripcion' => 'Mide la velocidad de un individuo en una distancia de 20 metros.'
            ]
        ];
        
        foreach ($tests as $test) {
            $this->db->query(
                "INSERT INTO tests (nombre_test, descripcion) VALUES (?, ?)",
                [$test['nombre_test'], $test['descripcion']]
            );
        }
    }
}
