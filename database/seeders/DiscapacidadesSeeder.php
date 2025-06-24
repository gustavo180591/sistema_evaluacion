<?php

class DiscapacidadesSeeder {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function run() {
        $discapacidades = [
            [
                'nombre' => 'Amputación',
                'descripcion' => 'Amputación parcial o total de miembros',
                'tipo' => 'fisica'
            ],
            [
                'nombre' => 'Paraplejia',
                'descripcion' => 'Parálisis de las piernas',
                'tipo' => 'fisica'
            ],
            [
                'nombre' => 'Ceguera',
                'descripcion' => 'Pérdida total de la visión',
                'tipo' => 'visual'
            ],
            [
                'nombre' => 'Baja visión',
                'descripcion' => 'Limitación significativa de la visión',
                'tipo' => 'visual'
            ],
            [
                'nombre' => 'Sordera',
                'descripcion' => 'Pérdida total de la audición',
                'tipo' => 'auditiva'
            ],
            [
                'nombre' => 'Baja audición',
                'descripcion' => 'Limitación significativa de la audición',
                'tipo' => 'auditiva'
            ],
            [
                'nombre' => 'Parálisis cerebral',
                'descripcion' => 'Trastorno del movimiento y postura',
                'tipo' => 'fisica'
            ],
            [
                'nombre' => 'Autismo',
                'descripcion' => 'Trastorno del espectro autista',
                'tipo' => 'intelectual'
            ],
            [
                'nombre' => 'Síndrome de Down',
                'descripcion' => 'Trastorno genético',
                'tipo' => 'intelectual'
            ],
            [
                'nombre' => 'Trastorno del espectro autista',
                'descripcion' => 'Trastorno del neurodesarrollo',
                'tipo' => 'intelectual'
            ]
        ];
        
        foreach ($discapacidades as $discapacidad) {
            $this->db->query(
                "INSERT INTO discapacidades (nombre, descripcion, tipo) VALUES (?, ?, ?)",
                [$discapacidad['nombre'], $discapacidad['descripcion'], $discapacidad['tipo']]
            );
        }
    }
}
