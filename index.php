<?php
session_start();
include "header.php"; // Ensure the correct path to header.php
if (!isset($_SESSION["staff_id"])) {
    header("Location: login.php"); // Ensure the correct path to login.php
    exit();
}

$staff_id = $_SESSION["staff_id"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Rental</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="title">
        <h2>List of Clients</h2>
        <a class="button1" href="create.php" role="button">New Client</a> <!-- Ensure the correct path to create.php -->
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>File Name</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "book_rental";      

                // Connection to database
                $connection = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($connection->connect_error) {
                    die("Connection failed: ". $connection->connect_error); 
                }

                $sql = "SELECT * FROM clients";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                // Read data of each row
                while($row = $result->fetch_assoc()) {
                    echo "
                <tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['file_name']}</td>
                    <td>{$row['created_at']}</td>
                    <td>
                        <a class='btn btn-primary btn-sm' href='edit.php?id={$row['id']}'>Edit</a>
                        <a class='btn btn-danger btn-sm' href='delete.php?id={$row['id']}'>Delete</a>
                    </td>
                </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
