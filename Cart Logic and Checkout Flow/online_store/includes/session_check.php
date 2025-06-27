<?php session_start();
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
        exit();
    }
}

// Add after login check
if (isLoggedIn() && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    syncSessionCartToDatabase($_SESSION['user_id'], $_SESSION['cart']);
}
?>