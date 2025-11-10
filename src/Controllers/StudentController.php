<?php

namespace Controllers;

use Controllers\Controller;
use Model\Student;

class StudentController extends Controller
{
    public function profile()
    {
        $this->view("user", ["user" => "Lebanvla"]);
    }

    public function getStudyPlan()
    {

        // self::json_response([
        //     "status" => "success",
        //     'study_plan' => [
        //         'Первый семестр' => 'Предмет 1',
        //         'Второй семестр' => 'Предмет 2',
        //         'Третий семестр' => 'Предмет 3',
        //         'Четвертый семестр' => 'Предмет 4',
        //     ]
        // ]);
    }

    public function authorisation()
    {
        $data["error"] = $_GET['error'] ?? '';
        $this->view('student_authorisation_form', $data);
    }
    public function authorisationHandler()
    {
        $response_data = [
            "status" => "",
            "title" => "",
            "description" => ""
        ];
        if (empty($_POST["login"]) || empty($_POST["password"])) {
            $response_data["status"] = "error";
            $response_data["title"] = "system";
            $response_data["description"] = "Отсутствуют обязательные поля";
        }

        $login = $_POST["login"];
        $password = $_POST["password"];
        if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $response_data["status"] = "error";
            $response_data["title"] = "login";
            $response_data["description"] = "Логин должен быть валидным email-адресом";
        }
        if (!preg_match('/^[a-zA-Z0-9]{7,}$/', $password)) {
            $response_data["status"] = "error";
            $response_data["title"] = "password";
            $response_data["description"] = "Пароль должен содержать только латинские буквы и цифры, минимум 7 символов";
        }
        try {
            $user_data = Student::get($login, $password);
        } catch (\Exception $e) {
            self::error_500();
        }


        switch ($user_data) {
            case Student::ERROR_USER_NOT_FOUND:
                $response_data["status"] = "error";
                $response_data["title"] = "login";
                $response_data["description"] = "Пользователь не найден";
                break;
            case Student::ERROR_PASSWORD_NOT_VALID:
                $response_data["status"] = "error";
                $response_data["title"] = "password";
                $response_data["description"] = "Пароль не верен";
                break;
            default:
                unset($user_data[0]['password']);
                foreach ($user_data[0] as $key => $value) {
                    $_SESSION[$key] = $value;
                }
                $_SESSION["role"] = "student";
                $response_data["status"] = "success";
                $response_data["link"] = "http://localhost/";
        }
        $this->json_response($response_data, "authorisation_status");
    }
}
