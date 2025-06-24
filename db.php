<?php
$conn = new mysqli("localhost", "root", "", "ecommerce_site");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
