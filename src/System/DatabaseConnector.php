<?php

namespace Src\System;

class DatabaseConnector
{

    private $conn = null;

    public function __construct()
    {
        $host = getenv('DB_ADMIN_HOST');
        $port = getenv('DB_ADMIN_PORT');
        $db   = getenv('DB_ADMIN_DATABASE');
        $user = getenv('DB_ADMIN_USERNAME');
        $pass = getenv('DB_ADMIN_PASSWORD');

        try {
            $this->conn = new \PDO("mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db", $user, $pass);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    private function query($str, $params = array())
    {
        $stmt = $this->conn->prepare($str);
        $stmt->execute($params);
        if (explode(' ', $str)[0] == 'SELECT' || explode(' ', $str)[0] == 'CALL') {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } elseif (explode(' ', $str)[0] == 'INSERT' || explode(' ', $str)[0] == 'UPDATE' || explode(' ', $str)[0] == 'DELETE') {
            return 1;
        }
    }

    //Get raw data from db
    public function getData($query, $params = array())
    {
        $result = $this->query($query, $params);
        if (!empty($result)) return $result;
        return 0;
    }

    //Insert, Upadate or Delete Data
    public function inputData($query, $params = array())
    {
        $result = $this->query($query, $params);
        if (!empty($result)) return $result;
        return 0;
    }
}
