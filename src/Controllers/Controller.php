<?php

namespace Controllers;

class Controller
{
    public static function json_response(array $data)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
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
