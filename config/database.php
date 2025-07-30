<?php

// Cargar variables de entorno desde el archivo .env
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Ignorar comentarios
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value, '"\''); // Remover comillas
            putenv("$name=$value");
        }
    }
}

$host = getenv('DB_HOST') ?: 'mysql';
$db   = getenv('DB_DATABASE') ?: 'sistema_evaluacion';
$user = getenv('DB_USERNAME') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: 'root';
$charset = getenv('DB_CHARSET') ?: 'utf8mb4';
$collation = getenv('DB_COLLATION') ?: 'utf8mb4_unicode_ci';
$port = getenv('DB_PORT') ?: '3306';

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::ATTR_PERSISTENT         => true,
];

// Use socket for local connections
if ($host === 'localhost' || $host === '127.0.0.1') {
    $dsn = "mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=$db;charset=$charset";
} else {
    // For Docker environments, use TCP connection
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
}

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $pdo->exec("SET NAMES $charset COLLATE $collation");
} catch (PDOException $e) {
    error_log("Error de conexión a la base de datos: " . $e->getMessage());
    throw new PDOException("Error al conectar a la base de datos", (int)$e->getCode());
} ?>
