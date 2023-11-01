<?php

class DatabaseConnector
{
    private $conn = null;
    private $user = "root";
    private $pass = "";

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=localhost;port=3306;charset=utf8mb4;dbname=fining_system", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function connect()
    {
        return $this->conn;
    }
}
