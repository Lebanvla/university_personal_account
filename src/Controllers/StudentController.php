<?php

namespace Controllers;

use Controllers\Controller;
use Model\Student;

class StudentController extends Controller
{
    public function profile()
    {
        view("user", ["user" => "Lebanvla"]);
    }

    public function getStudyPlan()
    {
        self::json_response([
            "status" => "success",
            'study_plan' => [
                'Первый семестр' => 'Предмет 1',
                'Второй семестр' => 'Предмет 2',
                'Третий семестр' => 'Предмет 3',
                'Четвертый семестр' => 'Предмет 4',
            ]
        ]);
    }

    public function authorisation()
    {
        $data["error"] = $_GET['error'] ?? '';
        view('student_authorisation_form', $data);
    }
    public function authorisationHandler()
    {
        if (empty($_POST["login"]) || empty($_POST["password"])) {
            self::json_response([
                "status" => "error",
                "title" => "system",
                "description" => "Отсутствуют обязательные поля"
            ]);
            return;
        }

        $login = $_POST["login"];
        $password = $_POST["password"];
        if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
            self::json_response([
                "status" => "error",
                "title" => "login",
                "description" => "Логин должен быть валидным email-адресом"
            ]);
        }
        if (!preg_match('/^[a-zA-Z0-9]{7,}$/', $password)) {
            self::json_response([
                "status" => "error",
                "title" => "password",
                "description" => "Пароль должен содержать только латинские буквы и цифры, минимум 7 символов"
            ]);
        }
        try {
            $user_data = Student::get($login, $password);
        } catch (\Exception $e) {
            self::error_500();
        }


        switch ($user_data) {
            case Student::ERROR_USER_NOT_FOUND:
                self::json_response([
                    "status" => "error",
                    "title" => "login",
                    "description" => "Пользователь не найден"
                ]);
                break;
            case Student::ERROR_PASSWORD_NOT_VALID:
                self::json_response([
                    "status" => "error",
                    "title" => "password",
                    "description" => "Пароль не верен"
                ]);
                break;
            default:
                foreach ($user_data as $key => $value) {
                    $_SESSION[$key] = $value;
                }
                var_export($_SESSION);
                self::json_response([
                    "status" => "success",
                    "link" => "http://localhost/"
                ]);
        }
    }
}
