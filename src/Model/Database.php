<?php

namespace Model;

use Exception;
use mysqli;

class Database
{
    private mysqli $db;
    private static $instance;
    public function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->db = new mysqli();
        $this->db->connect("localhost", "root", "qq", "university");
    }
    public function __destruct()
    {
        $this->db->close();
    }

    public function __clone()
    {
        throw new DatabaseExcpetion("Вызван неверный метод", 1);
    }

    public function __wakeup()
    {
        throw new DatabaseExcpetion("Вызван неверный метод", 2);
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function getConnection()
    {
        return self::getInstance()->db;
    }

    public static function query(string $query): array
    {
        try {
            $result = self::getConnection()->query($query);
            return ($result instanceof \mysqli_result) ?
                $result->fetch_all(MYSQLI_ASSOC) :
                ["result" => "success"];
        } catch (Exception $e) {
            throw new DatabaseExcpetion("Возникла ошибка запроса: " . $e->getMessage());
        }
    }

    public static function prepare(string $query, string $types, array $params): array
    {
        try {
            $stmt = self::getConnection()->prepare($query);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            return ($result instanceof \mysqli_result) ?
                $result->fetch_all(MYSQLI_ASSOC) :
                ["result" => "success"];
        } catch (Exception $e) {
            throw new DatabaseExcpetion("Возникла ошибка запроса: " . $e->getMessage());
        }
    }
}

class DatabaseExcpetion extends Exception {}
