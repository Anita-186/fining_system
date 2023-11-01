<?php
require_once "DatabaseConnector.php";

class ActivityHandler
{
    private $conn = null;

    public function __construct()
    {
        $this->conn = new DatabaseConnector();
    }

    public function resetUserPassword($user_id, $password)
    {
        // Hash password
        $hashed_pw = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE login SET `password` = :pw WHERE `id` = :id";
        $query_result = $this->conn->inputData($query, array(":id" => $user_id, ":pw" => $hashed_pw));

        if ($query_result) return array("success" => true, "message" => "Account's password reset was successful!");
        return array("success" => false, "message" => "Failed to reset user account password!");
    }

    public function verifyUserLogin($data)
    {
        $sql = "SELECT * FROM `login` WHERE `username` = :u";
        $result = $this->conn->getData($sql, array(':u' => $data["username"]));
        if (!empty($data)) {
            if (password_verify($data["password"], $result[0]["password"])) return $result;
        }
        return 0;
    }

    //CRUD for officals

    public function fetchAllOfficial(): mixed
    {
        $query = "SELECT * FROM `officials`";
        $result = $this->conn->inputData($query);
        if (!empty($result)) return array("success" => true, "message" => $result);
        return array("success" => false, "message" => "No records found!");
    }

    public function fetchOfficial($data): mixed
    {
        $query = "SELECT * FROM `officials` WHERE `id` = :id";
        $result = $this->conn->inputData($query, array(":id" => $data["official"]));
        if (!empty($result)) return array("success" => true, "message" => $result);
        return array("success" => false, "message" => "No records found!");
    }

    public function addOfficial($data): mixed
    {
        $query = "INSERT INTO `officials` (`first_name`, `last_name`, `phone_number`, `email_adress`, `role`, `location`) 
                    VALUES (:fn, :ln, :pn, :ea, :rl, :lt)";
        $params = array(
            ":fn" => $data["first_name"], ":ln" => $data["last_name"],
            ":pn" => $data["phone_number"], ":ea" => $data["email_adress"],
            ":rl" => $data["role"], ":lt" => $data["location"]
        );
        if ($this->conn->inputData($query, $params)) return array("success" => true, "message" => "Successfully added a new official!");
        return array("success" => false, "message" => "Failed to add new official!");
    }

    public function updateOfficial($data): mixed
    {
        $query = "UPDATE `officials` 
                    SET `first_name` = :fn, `last_name` = :ln, `phone_number` = :pn, `email_adress` = :ea, `role` = :rl, `location` = :lt 
                    WHERE `id` = :id";
        $params = array(
            ":fn" => $data["first_name"], ":ln" => $data["last_name"],
            ":pn" => $data["phone_number"], ":ea" => $data["email_adress"],
            ":rl" => $data["role"], ":lt" => $data["location"], ":id" => $data["official"]
        );
        if ($this->conn->inputData($query, $params)) return array("success" => true, "message" => "Successfully updated official's details!");
        return array("success" => false, "message" => "Failed to update official's details!");
    }

    public function removeOfficial($data): mixed
    {
        $query = "DELETE FROM `officials` WHERE `id` = :id";
        $params = array(":id" => $data["official"]);
        if ($this->conn->inputData($query, $params)) return array("success" => true, "message" => "Successfully removed official's details!");
        return array("success" => false, "message" => "Failed to remove official's details!");
    }

    // CRUD for offense

    public function fetchAllOffense(): mixed
    {
        $query = "SELECT * FROM `offenses`";
        $result = $this->conn->inputData($query);
        if (!empty($result)) return array("success" => true, "message" => $result);
        return array("success" => false, "message" => "No records found!");
    }

    public function fetchOffense($data): mixed
    {
        $query = "SELECT * FROM `offenses` WHERE `id` = :id";
        $result = $this->conn->inputData($query, array(":id" => $data["offense"]));
        if (!empty($result)) return array("success" => true, "message" => $result);
        return array("success" => false, "message" => "No records found!");
    }

    public function addOffense($data): mixed
    {
        $query = "INSERT INTO `offenses`(`name`, `amount`) VALUES (:nm, :am)";
        $params = array(":fn" => $data["name"], ":ln" => $data["amount"]);
        if ($this->conn->inputData($query, $params)) return array("success" => true, "message" => "Successfully added a new offense!");
        return array("success" => false, "message" => "Failed to add new offense!");
    }

    public function updateOffense($data): mixed
    {
        $query = "UPDATE `offenses` SET `name` = :nm, `amount` = :am WHERE `id` = :id";
        $params = array(":fn" => $data["name"], ":ln" => $data["amount"]);
        if ($this->conn->inputData($query, $params)) return array("success" => true, "message" => "Successfully updated offense's details!");
        return array("success" => false, "message" => "Failed to update offense's details!");
    }

    public function removeOffense($data): mixed
    {
        $query = "DELETE FROM `offenses` WHERE `id` = :id";
        $params = array(":id" => $data["offense"]);
        if ($this->conn->inputData($query, $params)) return array("success" => true, "message" => "Successfully removed offense's details!");
        return array("success" => false, "message" => "Failed to remove offense's details!");
    }

    // Reporting a case

    public function fetchAllReportedCase(): mixed
    {
        $query = "SELECT * FROM `reported_cases`";
        $result = $this->conn->getData($query);
        if (!empty($result)) return array("success" => true, "message" => $result);
        return array("success" => false, "message" => "No records found!");
    }

    public function fetchReportedCase($data): mixed
    {
        $query = "SELECT * FROM `reported_cases` WHERE `id` = :id";
        $result = $this->conn->getData($query, array(":id" => $data["case"]));
        if (!empty($result)) return array("success" => true, "message" => $result);
        return array("success" => false, "message" => "No records found!");
    }

    public function reportCase($data): mixed
    {
        $query = "INSERT INTO `reported_cases`(`official_id`, `ghana_card_number`, `offense_id`, `ticket_number`, `status`) 
                    VALUES (:oc, :gn, :os, :tn, :st)";
        $params = array(
            ":oc" => $data["official"], ":gn" => $data["ghana_card_number"],
            ":os" => $data["offense"], ":tn" => $data["ticket_number"],
            ":st" => "OPEN"
        );
        if ($this->conn->inputData($query, $params)) return array("success" => true, "message" => "Successfully reported a new case!");
        return array("success" => false, "message" => "Failed to report a new case!");
    }

    public function removeReportedCase($data): mixed
    {
        $query = "DELETE FROM `reported_cases` WHERE `id` = :id";
        $params = array(":id" => $data["case"]);
        if ($this->conn->inputData($query, $params)) return array("success" => true, "message" => "Successfully removed reported case!");
        return array("success" => false, "message" => "Failed to remove reported case!");
    }
}
