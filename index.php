<?php 
session_start();
include "scripts/mysql_connect.php"; 
if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"]; 
    $sql = mysql_query("SELECT * FROM user WHERE username='$username' AND password='$password' LIMIT 1"); 
    $count = mysql_num_rows($sql); 
    if ($count > 0) { 
        $row = mysql_fetch_array($sql); 
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;
        header("Location:main.php");
    }
    else {
        echo "<script type='text/javascript'>history.back(alert('Wrong username or password'))</script>";
    }
}

if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"]; 
    $sql = mysql_query("INSERT INTO user (username, password) VALUES('$username','$password')") or die (mysql_error());
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;
    header("Location:main.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <?php include_once("src.php"); ?>
    </head>
    <body class="o-page">
        <h1>Counter-Strike: Global Offensive Statistics</h1>
        <div id="content" style="min-height:480px;">
            <div>
                <h2>Please Log In</h2>
                <form method="post" action="index.php">
                    <input placeholder="Username" name="username" type="text" class="form-control" pattern="[A-Za-z0-9]{1,24}" required><br>
                    <input placeholder="Password" name="password" type="password" class="form-control" pattern="[A-Za-z0-9]{1,16}" required><br>
                    <input name="login" type="submit" class="btn btn-success" value="Log In"><br>
                </form>
            </div>
            <div>
                <h2>Not signed up?</h2>
                <form method="post" action="index.php">
                    <input placeholder="Username" name="username" type="text" class="form-control" pattern="[A-Za-z0-9]{1,24}" required><br>
                    <input placeholder="Password" name="password" type="password" class="form-control" id="password1" pattern="[A-Za-z0-9]{1,16}" required><br>
                    <input placeholder="Confirm Password" name="passwordconf" type="password" class="form-control" id="password2" pattern="[A-Za-z0-9]{1,16}" required oninput="check();"> <br>
                    <input name="register" type="submit" class="btn btn-success" value="Sign up"><br>
                </form>
            </div>
        </div>

        <div class="subFooter" style="bottom:0;">Copyright 2015 / Seungmoon Rieh</div>

        <script>
            function check() {
                var p1 = $("#password1");
                var p2 = $("#password2");
                if (p1.val() == p2.val()) {
                    p1.get(0).setCustomValidity("");
                    return true;
                }
                else {
                    p1.get(0).setCustomValidity("Passwords do not match");
                    return false; 
                }
            }
        </script>
    </body>
</html>
