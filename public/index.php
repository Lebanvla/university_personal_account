<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use Pecee\SimpleRouter\SimpleRouter;


include(__DIR__ . "/../src/helpers.php");
include(__DIR__ . "/../src/routes.php");


try {
    SimpleRouter::setDefaultNamespace('Controllers');
    if (isset($_SESSION['role'])) {
        $role = $_SESSION['role'];
        switch ($role) {
            case 'student':
                student_routes();
                break;
            case 'professor';
                professor_routes();
                break;
            case 'admin':
                admin_routes();
                break;
            case 'techical_specialist':
                student_routes();
                professor_routes();
                admin_routes();
                break;
            default:
                log_error("Неизвестная или устаревшая роль $role. Произведён перезапуск сайта");
                session_destroy();
                header("Location: http://localhost/student/authorisation");
                exit;
        }
    } else {
        authorisation_routes();
    }
    SimpleRouter::start();
} catch (\Pecee\SimpleRouter\Exceptions\NotFoundHttpException $e) {
    http_response_code(404);
    exit;
} catch (\Exception $e) {
    log_error($e->getMessage());
    http_response_code(500);
    echo 'Ошибка на сервере';
    exit;
}
