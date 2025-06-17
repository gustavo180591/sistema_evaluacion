<?php

abstract class Controller
{
    protected function view($ruta, $data = [])
    {
        extract($data);
        require_once __DIR__ . '/../views/' . $ruta . '.php';
    }

    protected function redirect($controller, $action = null)
    {
        $url = 'index.php?controller=' . urlencode($controller);
        if ($action) {
            $url .= '&action=' . urlencode($action);
        }
        header('Location: ' . $url);
        exit;
    }
}
