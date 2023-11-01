<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == "GET") {
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_GET["url"] == "user-login") {

        if (!isset($_SESSION["_userLogToken"]) || empty($_SESSION["_userLogToken"]))
            die(json_encode(array("success" => false, "message" => "Invalid request: 1!")));
        if (!isset($_POST["_vALToken"]) || empty($_POST["_vALToken"]))
            die(json_encode(array("success" => false, "message" => "Invalid request: 2!")));
        if ($_POST["_vALToken"] !== $_SESSION["_userLogToken"])
            die(json_encode(array("success" => false, "message" => "Invalid request: 3!")));

        $username = $expose->validateText($_POST["username"]);
        $password = $expose->validatePassword($_POST["password"]);
        $result = $admin->verifyAdminLogin($username, $password);

        if (!$result) {
            $_SESSION['userLogSuccess'] = false;
            die(json_encode(array("success" => false, "message" => "Incorrect application username or password! ")));
        }

        $_SESSION['user'] = $result[0]["id"];
        $_SESSION['role'] = $result[0]["role"];
        $_SESSION['user_type'] = $result[0]["type"];
        $_SESSION['userLogSuccess'] = true;

        die(json_encode(array("success" => true,  "message" => strtolower($result[0]["role"]))));
    }
} else {
    http_response_code(405);
}
