<?php
require __DIR__ . '/db_connection.php';
// require __DIR__ . '/configure.php'; // Include the configuration file for admin credentials
session_start();
function isAdminAuthenticated()
{
    // Check if the session variable for admin login is set
    // This variable should be set when the admin logs in successfully 
    return !empty($_SESSION['admin_logged_in']);
}

function requireLogin()
{
    if (!isAdminAuthenticated()) {
        // If the admin is not authenticated, redirect to the login page
        header("Location: admin_login.php");
        exit();
    }
}

function logoutAdmin()
{
    // Clear previous session data
    $_SESSION = [];

    if (session_status() === PHP_SESSION_ACTIVE) {
        // Unset all session variables
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 3600, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    // Destroy the session
    session_destroy();

    //Regenerate a new session ID
    session_regenerate_id(true);

    // Redirect to the login page
    header("Location: admin.php");
    exit();
}

function loginAdmin($email, $password)
{
    if ($email === ADMIN_EMAIL && password_verify($password, ADMIN_PASSWORD_HASH)) {
        $_SESSION['admin_logged_in'] = true;
        return true;
    }
    return false;
}
