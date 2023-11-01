<?php
require_once "DBConnect.php";

class OfficialsHandler
{
    private $conn = null;
    public function __construct()
    {
        $this->conn = (new DatabaseConnector())->connect();
    }

    
}
