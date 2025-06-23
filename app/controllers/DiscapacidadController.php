<?php

class DiscapacidadController
{
    public function index()
    {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        require_once __DIR__ . '/../models/Discapacidad.php';
        $discapacidades = Discapacidad::todos();

        require_once __DIR__ . '/../views/admin/discapacidades/index.php';
    }

    public function crear()
    {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../models/Discapacidad.php';
            try {
                Discapacidad::crear(
                    $_POST['nombre'],
                    $_POST['descripcion'],
                    $_POST['tipo']
                );
                
                $_SESSION['success'] = 'Discapacidad creada exitosamente';
                header('Location: index.php?controller=Discapacidad&action=index');
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = 'Error al crear la discapacidad: ' . $e->getMessage();
                header('Location: index.php?controller=Discapacidad&action=crear');
                exit;
            }
        }

        require_once __DIR__ . '/../views/admin/discapacidades/crear.php';
    }

    public function editar($id)
    {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        require_once __DIR__ . '/../models/Discapacidad.php';
        $discapacidad = Discapacidad::buscarPorId($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                Discapacidad::actualizar(
                    $id,
                    $_POST['nombre'],
                    $_POST['descripcion'],
                    $_POST['tipo']
                );
                
                $_SESSION['success'] = 'Discapacidad actualizada exitosamente';
                header('Location: index.php?controller=Discapacidad&action=index');
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = 'Error al actualizar la discapacidad: ' . $e->getMessage();
            }
        }

        require_once __DIR__ . '/../views/admin/discapacidades/editar.php';
    }

    public function eliminar($id)
    {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        require_once __DIR__ . '/../models/Discapacidad.php';
        try {
            Discapacidad::eliminar($id);
            $_SESSION['success'] = 'Discapacidad eliminada exitosamente';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al eliminar la discapacidad: ' . $e->getMessage();
        }

        header('Location: index.php?controller=Discapacidad&action=index');
        exit;
    }
}
