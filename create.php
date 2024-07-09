<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "book_rental";  

// Connection to the database
$connection = new mysqli($servername, $username, $password, $database);

$name = "";
$email = "";
$phone = "";
$address = "";
$file_name = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $file_name = basename($_FILES["file"]["name"]);

    do {
        if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($file_name)){
            $errorMessage = "All fields are required";
            break;
        }

        // Check if email already exists
        $sql = "SELECT * FROM clients WHERE email = '$email'";
        $result = $connection->query($sql);
        if ($result->num_rows > 0) {
            $errorMessage = "Email already exists";
            break;
        }

        // Directory where the file will be saved
        $target_dir = "uploads/";
        // Path to the file to be uploaded
        $target_file = $target_dir . $file_name;
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the uploaded file is a PDF
        if ($fileType != "pdf") {
            $errorMessage = "Only PDF files are allowed.";
            $uploadOk = 0;
            break;
        }

        // Attempt to upload the file
        if ($uploadOk == 1) {
            if (!move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $errorMessage = "Sorry, there was an error uploading your file.";
                break;
            }
        } else {
            break;
        }

        // Add new client to the database
        $sql = "INSERT INTO clients (name, email, phone, address, file_name) VALUES ('$name', '$email', '$phone', '$address', '$file_name')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $name = "";
        $email = "";
        $phone = "";
        $address = "";
        $file_name = "";

        $successMessage = "Client added correctly";

        header("location: index.php");
        exit;

    } while (false);
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/create.css">
    <title>Add Client</title>
</head>




<body>
    <div id="logo">
        <img src="picture/logo.png">
        <h3>WEBSITE BUILDER</h3>
    </div>

    <div class="container">
        <h2>New Client</h2>

        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show error-message' role='alert'>
                <strong>$errorMessage</strong>
            </div>
            ";
        }
        ?>
        <div class="border1">
            <form class="border2" method="post" enctype="multipart/form-data">
                <div class="name">
                    <label class="name2">Name:</label>
                    <div class="name3">
                        <input placeholder="Full Name" size="50" type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                    </div>
                </div>
                <br>
                <div class="email">
                    <label class="email2">Email:</label>
                    <div class="email3">
                        <input placeholder="Guess@Example.com" size="50" type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                    </div>
                </div>
                <br>
                <div class="phone">
                    <label class="phone2">Phone:</label>
                    <div class="phone3">
                        <input placeholder="(+60) 11-12345678" size="50" type="text" class="form-control" name="phone" value="<?php echo $phone; ?>">
                    </div>
                </div>
                <br>
                <div class="address">
                    <label class="address2">Address:</label>
                    <div class="address3">
                        <textarea name="address" id="address" style="height: 100px; width: 500px"><?php echo $address; ?></textarea>
                    </div>
                </div>
                <br>
                <div class="file">
                    <label>Upload Your Design (PDF only):</label><br>
                    <input type="file" name="file" id="file"><br><br>
                </div>

            </div>

            <?php
            if (!empty($successMessage)) {
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show success-message' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>
            <div class="buttonsc">
                <div class="submit2">
                    <button type="submit" class="submit3">Submit</button>
                </div>
                <div class="cancel">
                    <a class="cancel2" href="index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>