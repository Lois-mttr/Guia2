<?php
class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        $dsn = "mysql:host=db;dbname=sistesis_db;charset=utf8mb4";
        $this->conn = new PDO($dsn, "root", "root_password", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}
