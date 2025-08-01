<?php

class Usuario
{
    public static function findByEmail($email)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public static function crear($datos)
    {
        global $pdo;
        
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, password, rol, estado, fecha_registro, fecha_actualizacion) 
                              VALUES (:nombre, :apellido, :email, :password, :rol, :estado, NOW(), NOW())");
        
        $result = $stmt->execute([
            ':nombre' => $datos['nombre'],
            ':apellido' => $datos['apellido'],
            ':email' => $datos['email'],
            ':password' => $datos['password'],
            ':rol' => $datos['rol'],
            ':estado' => $datos['estado']
        ]);
        
        return $result ? $pdo->lastInsertId() : false;
    }

    public static function todos()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public static function filtrar($filtros = [])
    {
        global $pdo;
        
        $where = [];
        $params = [];
        
        // Aplicar filtros
        if (!empty($filtros['buscar'])) {
            $where[] = "(nombre LIKE :buscar OR apellido LIKE :buscar OR email LIKE :buscar)";
            $params[':buscar'] = '%' . $filtros['buscar'] . '%';
        }
        
        if (!empty($filtros['rol'])) {
            $where[] = "rol = :rol";
            $params[':rol'] = $filtros['rol'];
        }
        
        if (!empty($filtros['estado'])) {
            $where[] = "estado = :estado";
            $params[':estado'] = $filtros['estado'];
        }
        
        // Construir consulta
        $sql = "SELECT * FROM usuarios";
        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        
        // Ordenamiento
        $sql .= " ORDER BY id DESC";
        
        // Paginación
        if (!empty($filtros['pagina']) && !empty($filtros['por_pagina'])) {
            $offset = ($filtros['pagina'] - 1) * $filtros['por_pagina'];
            $sql .= " LIMIT :offset, :limit";
            $params[':offset'] = (int)$offset;
            $params[':limit'] = (int)$filtros['por_pagina'];
        }
        
        $stmt = $pdo->prepare($sql);
        
        // Vincular parámetros
        foreach ($params as $key => $value) {
            $paramType = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue($key, $value, $paramType);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function contar()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios");
        return $stmt->fetchColumn();
    }
    
    public static function contarFiltrados($filtros = [])
    {
        global $pdo;
        
        $where = [];
        $params = [];
        
        // Aplicar filtros (misma lógica que en filtrar)
        if (!empty($filtros['buscar'])) {
            $where[] = "(nombre LIKE :buscar OR apellido LIKE :buscar OR email LIKE :buscar)";
            $params[':buscar'] = '%' . $filtros['buscar'] . '%';
        }
        
        if (!empty($filtros['rol'])) {
            $where[] = "rol = :rol";
            $params[':rol'] = $filtros['rol'];
        }
        
        if (!empty($filtros['estado'])) {
            $where[] = "estado = :estado";
            $params[':estado'] = $filtros['estado'];
        }
        
        $sql = "SELECT COUNT(*) FROM usuarios";
        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
}
