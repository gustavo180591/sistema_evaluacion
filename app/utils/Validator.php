<?php

class Validator
{
    public static function email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function texto($texto, $min = 2, $max = 100)
    {
        $len = strlen($texto);
        return $len >= $min && $len <= $max;
    }

    public static function numero($numero)
    {
        return is_numeric($numero);
    }

    public static function fecha($fecha)
    {
        return (bool)strtotime($fecha);
    }

    public static function requerido($valor)
    {
        return isset($valor) && trim($valor) !== '';
    }
}
