<?php
require __DIR__ . '/../includes/db_connection.php';
session_start();
session_regenerate_id(true); // Regenerate session ID to prevent session fixation
$_SESSION = []; // Clear session data
session_destroy();
header("Location: login.php");
exit();
