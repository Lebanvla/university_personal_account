<?php

namespace Controllers;

use Controllers\Controller;
use Model\Student;

class StudentController extends Controller
{
    public function profile()
    {
        $this->view("user", [
            "id" => $_SESSION["id"],
            "family" => $_SESSION["family"],
            "name" => $_SESSION["name"],
            "patronymic" => $_SESSION["patronymic"],
            "group_id" => $_SESSION["group_id"]
        ]);
    }

    public function getStudyPlan()
    {
        $this->json_response([]);
    }

    public function authorisation()
    {
        $data["error"] = $_GET['error'] ?? '';
        $this->view('student_authorisation_form', $data);
    }
    public function authorisationHandler()
    {
        if (empty($_POST["login"]) || empty($_POST["password"])) {
            $response_data = self::error_json_fabric("system", "Не заполнены основные поля");
        }
        $login = $_POST["login"];
        $password = $_POST["password"];
        if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $response_data = self::error_json_fabric("login", "Логин должен быть валидным email-адресом");
        }
        if (!preg_match('/^[a-zA-Z0-9]{7,}$/', $password)) {
            $response_data = self::error_json_fabric(
                "password",
                "Пароль должен содержать только латинские буквы и цифры, минимум 7 символов"
            );
        }
        try {
            $user_data = Student::get($login, $password);
        } catch (\Exception $e) {
            self::error_500();
        }


        switch ($user_data) {
            case Student::ERROR_USER_NOT_FOUND:
                $response_data = self::error_json_fabric("login", "Пользователь не найден");
                break;
            case Student::ERROR_PASSWORD_NOT_VALID:
                $response_data = self::error_json_fabric("password", "Пароли не совпадают");
                break;
            default:
                $_SESSION["role"] = "student";
                $_SESSION["id"] = $user_data[0]["id"];
                $response_data["status"] = "success";
                $response_data["link"] = "http://localhost/";
        }
        $this->json_response($response_data);
    }

    public static function error_json_fabric(string $title, string $description)
    {
        $response_data = [];
        $response_data["status"] = "error";
        $response_data["title"] = $title;
        $response_data["description"] = $description;
        return $response_data;
    }
}
