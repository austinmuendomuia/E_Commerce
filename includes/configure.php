<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'gn1234');
define('DB_NAME', 'ecommerce');

// Database connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$conn->set_charset("utf8mb4"); //Allow for a wider range of characters, including emojis and special characters

// Enable error reporting for MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Check connection
if (!$conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (session_start() === PHP_SESSION_NONE) {
    session_start();
}

// Admin credentials
// These credentials should be securely stored and hashed in a real application
define('ADMIN_EMAIL', 'admin@example.com');
// Use a secure password hashing function to store the admin password
define('ADMIN_PASSWORD_HASH', password_hash('$2y$12$kLDt9.YsxsofSMrMMFjNaeCy7b7tdS81nM07.s4P3LoK7uS3YDD/i', PASSWORD_DEFAULT)); // Store hashed password for security
