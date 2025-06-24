<?php

class DatabaseSeeder {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function run() {
        // Run seeders in order
        $this->clearExistingData();
        
        $seeders = [
            'LugaresSeeder',
            'DiscapacidadesSeeder',
            'TestsSeeder',
            'EvaluadoresSeeder',
            'UsuariosSeeder',
            'AtletasSeeder',
            'EvaluacionesSeeder',
            'ResultadosTestsSeeder'
        ];
        
        foreach ($seeders as $seederClass) {
            $seederFile = __DIR__ . "/{$seederClass}.php";
            if (file_exists($seederFile)) {
                require_once $seederFile;
                $seeder = new $seederClass($this->db);
                $seeder->run();
                echo "Seeded: {$seederClass}\n";
            }
        }
    }
    
    private function clearExistingData() {
        $tables = [
            'resultados_tests',
            'evaluaciones',
            'atletas',
            'usuarios',
            'evaluadores',
            'tests',
            'lugares',
            'discapacidades'
        ];
        
        // Disable foreign key checks
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        
        foreach ($tables as $table) {
            $this->db->query("TRUNCATE TABLE `{$table}`");
        }
        
        // Re-enable foreign key checks
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
    }
}
