<?php

class View
{
    public static function render($ruta, $data = [])
    {
        extract($data);
        require __DIR__ . '/../views/' . $ruta . '.php';
    }
}
