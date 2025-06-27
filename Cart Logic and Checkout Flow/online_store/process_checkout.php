<?php
require_once 'includes/session_check.php';
require_once 'includes/cart_functions.php';
require_once 'config/database.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: checkout.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_items = getCartItems($user_id);
$cart_total = getCartTotal($user_id);

// Validate cart is not empty
if (empty($cart_items)) {
    header("Location: cart.php");
    exit();
}

try {
    // Start transaction
    $pdo->beginTransaction();
    
    // Create order
    $stmt = $pdo->prepare("
        INSERT INTO orders (user_id, total_amount, payment_method, order_status) 
        VALUES (?, ?, ?, 'completed')
    ");
    $stmt->execute([
        $user_id, 
        $cart_total, 
        $_POST['payment_method']
    ]);
    
    $order_id = $pdo->lastInsertId();
    
    // Add order items
    $stmt = $pdo->prepare("
        INSERT INTO order_items (order_id, product_id, quantity, price) 
        VALUES (?, ?, ?, ?)
    ");
    
    foreach ($cart_items as $item) {
        $stmt->execute([
            $order_id,
            $item['product_id'],
            $item['quantity'],
            $item['price']
        ]);
    }
    
    // Clear cart
    clearCart($user_id);
    
    // Commit transaction
    $pdo->commit();
    
    // Redirect to confirmation
    header("Location: order_confirmation.php?order_id=" . $order_id);
    exit();
    
} catch (Exception $e) {
    // Rollback transaction
    $pdo->rollback();
    
    // Redirect back to checkout with error
    header("Location: checkout.php?error=processing_failed");
    exit();
}
?>