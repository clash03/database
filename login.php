<?php
session_start();
include "database.php"; // Ensure this is the correct path to your database.php file

if (isset($_POST["login"])) {
    $staff_id = $_POST["staff_id"];
    $password = md5($_POST["password"]);

    // Ensure the connection is successful
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM staffs WHERE staff_id='$staff_id' AND password='$password'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION["staff_id"] = $staff_id;
        header("Location:index.php"); // Ensure the correct path to index.php
        exit();
    } else {
        $error = "User not found, please <a href='register.php'>Register</a> first!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form class="post" method="post">
        <div class="post2">
        Staff ID: <br><input type="text" name="staff_id" required size="20"><br><br><br>
        Password: <br><input type="password" name="password" required size="20"><br><br>
        </div><br>
        <div id="login">
        <input  type="submit" name="login" value="Login">
        </div>

    </form>
    <?php if (isset($error)) { echo "<p class='error-message'>$error</p>"; } ?>
<div id="logo">
    <img src="picture/logo.png">
    <h3>WEBSITE BUILDER</h3>
</div>

</body>
</html>
