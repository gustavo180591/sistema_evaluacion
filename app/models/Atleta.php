<?php

class Atleta
{
    public static function todosPorEvaluador($evaluador_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM atletas WHERE evaluador_id = ? ORDER BY apellido, nombre");
        $stmt->execute([$evaluador_id]);
        return $stmt->fetchAll();
    }

    public static function crear($evaluador_id, $data)
    {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO atletas (
            evaluador_id, nombre, apellido, dni, sexo, fecha_nacimiento,
            altura_cm, peso_kg, envergadura_cm, altura_sentado_cm,
            lateralidad_visual, lateralidad_podal, fecha_registro
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

        return $stmt->execute([
            $evaluador_id,
            $data['nombre'],
            $data['apellido'],
            $data['dni'],
            $data['sexo'],
            $data['fecha_nacimiento'],
            $data['altura_cm'],
            $data['peso_kg'],
            $data['envergadura_cm'],
            $data['altura_sentado_cm'],
            $data['lateralidad_visual'],
            $data['lateralidad_podal']
        ]);
    }

    public static function buscarPorId($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM atletas WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function contar()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM atletas");
        return $stmt->fetchColumn();
    }
}
