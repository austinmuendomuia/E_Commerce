<!DOCTYPE html>
<html>
<head>
<link rel='stylesheet' href='style.css'>
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
echo "Welcome to the protected page, " . $_SESSION['username'];
?>

</body>
</html>