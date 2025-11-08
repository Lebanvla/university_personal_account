<?php

namespace Model;

use Model\Database;

class Student
{
    public const ERROR_USER_NOT_FOUND = 1;
    public const ERROR_PASSWORD_NOT_VALID = 2;
    public static function get($login, $password): array | int
    {
        try {
            $result = Database::prepare("select id, password, family, name, patronymic, group_id from users where login = ?", "s", [$login]);
            if (count($result) === 0) {
                return self::ERROR_USER_NOT_FOUND;
            } else {
                $user_data = $result[0];
                if (!password_verify($password, $user_data["password"])) {
                    return self::ERROR_PASSWORD_NOT_VALID;
                } else {
                    $result["role"] = "student";
                    return $result;
                }
            }
        } catch (\Exception $e) {
            throw new \Exception("Ошибка базы данных: " . $e->getMessage(), 3);
        }
    }
}
