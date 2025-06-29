<?php
$conn = new mysqli("localhost", "root", "", "ecommerce_site", 3307); // Use 3307 if you changed it
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
