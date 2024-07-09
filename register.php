<?php
session_start();
include "database.php"; 

$successMessage = "";
$errorMessage = "";

if (isset($_POST["register"])) {
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $staff_id = mysqli_real_escape_string($con, $_POST["staff_id"]);
    $password = md5($_POST["password"]);

    // Check if email already exists
    $email_check_query = "SELECT * FROM staffs WHERE email='$email' LIMIT 1";
    $result = mysqli_query($con, $email_check_query);
    $staff = mysqli_fetch_assoc($result);
    
    if ($staff) { // if staff exists
        if ($staff['email'] === $email) {
            $errorMessage = "Email already exists! Please try again with a different email.";
        }
    } else {
        $query = "INSERT INTO staffs (name, email, staff_id, password) VALUES ('$name', '$email', '$staff_id', '$password')";
        if (mysqli_query($con, $query)) {
            $successMessage = "Registration successful! Click <a href='login.php'>here</a> to login.";
        } else {
            $errorMessage = "Error: " . mysqli_error($con);
        }
    }
}


if (isset($_POST['upload'])) {
    // Directory where the file will be saved
    $target_dir = "uploads/";
    // Path to the file to be uploaded
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the uploaded file is a PDF
    if ($fileType != "pdf") {
        echo "Only PDF files are allowed.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (e.g., limit to 5MB)
    if ($_FILES["file"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // If everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Insert file metadata into the database
            $file_name = basename($_FILES["file"]["name"]);
            $sql = "INSERT INTO uploads (file_name) VALUES ('$file_name')";

            if (mysqli_query($con, $sql)) {
                echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded and metadata saved.";
            } else {
                echo "Error: " . mysqli_error($con);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/register.css">
    <title>Register</title>
</head>
<body>

<div id="logo">
    <img src="picture/logo.png">
    <h3>WEBSITE BUILDER</h3>
</div>

<h1>Register New Account</h1>

<form class="post" method="post">
    Name: <br><input size="34" type="text" name="name" required><br><br>
    Email: <br><input size="34" type="email" name="email" required><br><br>
    Staff ID: <br><input size="34" type="text" name="staff_id" required><br><br>
    Password: <br><input size="34" type="password" name="password" required><br><br>

    <div id="register">
        <input type="submit" name="register" value="Register">
    </div>
</form>

<div class="back">
    <a href="login.php">< Login</a>
</div>

<?php if (!empty($successMessage)): ?>
    <div class="success-message">
        <?php echo $successMessage; ?>
    </div>
<?php endif; ?>

<?php if (!empty($errorMessage)): ?>
    <div class="error-message">
        <?php echo $errorMessage; ?>
    </div>
<?php endif; ?>

</body>
</html>
