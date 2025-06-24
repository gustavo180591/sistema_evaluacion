<?php

// Database configuration
$dbConfig = [
    'host' => 'localhost',
    'dbname' => 'sistema_evaluacion',
    'username' => 'root',
    'password' => ''
];

try {
    // Create database connection
    $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    $db = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], $options);
    
    // Include and run the DatabaseSeeder
    require_once __DIR__ . '/database/seeders/DatabaseSeeder.php';
    $seeder = new DatabaseSeeder($db);
    $seeder->run();
    
    echo "\n¡Base de datos sembrada exitosamente!\n";
    
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
