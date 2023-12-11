<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require "../bootstrap.php";

use Src\Controller\ExposeDataController;
use Src\Controller\ActivityHandler;

$expose = new ExposeDataController();
$user = new ActivityHandler();

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    //
    if ($_GET["url"] == "fetch-all-official") {
        die(json_encode($user->fetchAllOfficial()));
    }

    //
    elseif ($_GET["url"] == "fetch-official") {
        # code...
    }

    //
    elseif ($_GET["url"] == "fetch-all-offense") {
        die(json_encode($user->fetchAllOffense()));
    }

    //
    elseif ($_GET["url"] == "fetch-offense") {
        # code...
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if ($_GET["url"] == "user-login") {

        if (!isset($_POST["email"]) || empty($_POST["email"]))
            die(json_encode(array("success" => false, "message" => "Email address required!")));
        if (!isset($_POST["password"]) || empty($_POST["password"]))
            die(json_encode(array("success" => false, "message" => "Password required!")));
        if (!isset($_SESSION["_userLogToken"]) || empty($_SESSION["_userLogToken"]))
            die(json_encode(array("success" => false, "message" => "Invalid request: 1!")));
        if (!isset($_POST["_vALToken"]) || empty($_POST["_vALToken"]))
            die(json_encode(array("success" => false, "message" => "Invalid request: 2!")));
        if ($_POST["_vALToken"] !== $_SESSION["_userLogToken"])
            die(json_encode(array("success" => false, "message" => "Invalid request: 3!")));

        $username = $expose->validateText($_POST["email"]);
        $password = $expose->validatePassword($_POST["password"]);
        $result = $user->verifyUserLogin($username, $password);

        if (empty($result)) {
            $_SESSION['userLogSuccess'] = false;
            die(json_encode(array("success" => false, "message" => "Incorrect application username or password! ")));
        }

        $_SESSION['user'] = $result[0]["id"];
        $_SESSION['role'] = $result[0]["user_type"];
        $_SESSION['userLogSuccess'] = true;

        die(json_encode(array("success" => true,  "message" => strtolower($result[0]["user_type"]))));
    }

    //
    elseif ($_GET["url"] == "add-official") {
        # code...
    }

    //
    elseif ($_GET["url"] == "edit-official") {
        # code...
    }

    //
    elseif ($_GET["url"] == "remove-official") {
        # code...
    }

    //
    elseif ($_GET["url"] == "add-offense") {
        # code...
    }

    //
    elseif ($_GET["url"] == "edit-offense") {
        # code...
    }

    //
    elseif ($_GET["url"] == "remove-offense") {
        # code...
    }

    //
    elseif ($_GET["url"] == "report-offense") {
        # code...
    }

    //
    elseif ($_GET["url"] == "edit-reported-offense") {
        # code...
    }

    //
    elseif ($_GET["url"] == "delete-reported-offense") {
        # code...
    }
} else {
    http_response_code(405);
}
