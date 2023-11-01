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

    private function query($query, $params = array())
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            if (explode(' ', $query)[0] == 'SELECT' || explode(' ', $query)[0] == 'CALL') {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } elseif (explode(' ', $query)[0] == 'INSERT' || explode(' ', $query)[0] == 'UPDATE' || explode(' ', $query)[0] == 'DELETE') {
                return 1;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
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
