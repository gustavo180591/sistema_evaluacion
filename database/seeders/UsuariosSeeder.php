<?php

class UsuariosSeeder {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function run() {
        // Admin user
        $usuarios = [
            [
                'nombre' => 'Administrador',
                'apellido' => 'Sistema',
                'email' => 'admin@colegio.edu',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'rol' => 'administrador',
                'estado' => 'activo'
            ]
        ];
        
        // Get evaluadores to create user accounts for them
        $evaluadores = $this->db->query("SELECT * FROM evaluadores")->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($evaluadores as $evaluador) {
            $usuarios[] = [
                'nombre' => $evaluador['nombre'],
                'apellido' => $evaluador['apellido'],
                'email' => $evaluador['email'],
                'password' => $evaluador['password'],
                'rol' => 'evaluador',
                'estado' => 'activo'
            ];
        }
        
        // Add some regular users
        $usuariosExtra = [
            [
                'nombre' => 'Profesor',
                'apellido' => 'Educación Física',
                'email' => 'profesor@colegio.edu',
                'password' => password_hash('profesor123', PASSWORD_DEFAULT),
                'rol' => 'usuario',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Coordinador',
                'apellido' => 'Deportes',
                'email' => 'coordinador@colegio.edu',
                'password' => password_hash('coordinador123', PASSWORD_DEFAULT),
                'rol' => 'usuario',
                'estado' => 'activo'
            ]
        ];
        
        $usuarios = array_merge($usuarios, $usuariosExtra);
        
        foreach ($usuarios as $usuario) {
            $this->db->query(
                "INSERT INTO usuarios (nombre, apellido, email, password, rol, estado) VALUES (?, ?, ?, ?, ?, ?)",
                [
                    $usuario['nombre'],
                    $usuario['apellido'],
                    $usuario['email'],
                    $usuario['password'],
                    $usuario['rol'],
                    $usuario['estado']
                ]
            );
        }
    }
}
