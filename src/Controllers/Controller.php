<?php

namespace Controllers;

class Controller
{
    public static function json_response(string $name, array $data)
    {
        header('Content-Type: application/json; charset=utf-8');
        extract($data);
        require $_SERVER["DOCUMENT_ROOT"] . "/src/Json_templates/{$name}.php";
        exit;
    }

    public static function view(string $view, array $data = [])
    {
        extract($data);
        require $_SERVER["DOCUMENT_ROOT"] . "/src/Views/{$view}.php";
    }

    public static function error_500()
    {
        header('HTTP/1.1 500 INTERNAL SERVER ERROR');
        exit;
    }


    public static function error_400()
    {
        header('HTTP/1.1 400 NOT_FOUND');
        exit;
    }
}
