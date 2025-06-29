<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require_once __DIR__ . '/configure.php';
// Database connection parameters
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASSWORD = 'gn1234';
$DB_NAME = 'ecommerce';

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}
$conn->set_charset("utf8mb4");
