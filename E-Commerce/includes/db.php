<?php
$host = "localhost";
$username = "root";
$password = ""; // Leave blank unless you've set one
$database = "ecommerce";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
