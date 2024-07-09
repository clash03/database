<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "book_rental";

// Connection to database
$con = new mysqli($servername, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
