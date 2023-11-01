<?php
session_start();

if (!isset($_SESSION["_userLogToken"])) {
    $rstrong = true;
    $_SESSION["_userLogToken"] = hash('sha256', bin2hex(openssl_random_pseudo_bytes(64, $rstrong)));
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <form action="" id="LoginForm">
            <h1 class="mb-4">Login</h1>
            <div class="mb-3">
                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" required class="form-control" />
            </div>
            <div class="mb-3">
                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required class="form-control" />
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="" id="remember" name="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <div class="mb-3">
                <span class="psw">Forgot <a href="forgot-password.php">password?</a></span>
            </div>
            <input type="hidden" name="_vALToken" value="<?= $_SESSION['_userLogToken'] ?>">
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="./utils/js/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script>
        $(document).ready(function() {

            $(document).on({
                ajaxStart: function() {
                    // Show full page LoadingOverlay
                    $.LoadingOverlay("show");
                },
                ajaxStop: function() {
                    // Hide it after 3 seconds
                    $.LoadingOverlay("hide");
                }
            });

            $("#LoginForm").on("submit", function(e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "api/user-login",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(result) {
                        console.log(result);
                        /*if (result.success) {
                            window.location.href = result.message + "/";
                        } else {
                            alert(result['message']);
                        }*/
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

        });
    </script>

</body>

</html>