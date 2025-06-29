<?php 

require_once '../includes/session_check.php';
require_once '../includes/cart_functions.php';

// Ensure user is logged in
if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Please log in first']);
    exit();
}

$action = $_POST['action'] ?? '';
$user_id = $_SESSION['user_id'];

switch ($action) {
    case 'add':
        $product_id = (int)$_POST['product_id'];
        $quantity = (int)($_POST['quantity'] ?? 1);
        
        if (addToCart($user_id, $product_id, $quantity)) {
            $total = getCartTotal($user_id);
            echo json_encode([
                'success' => true, 
                'message' => 'Item added to cart',
                'cart_total' => number_format($total, 2)
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add item']);
        }
        break;
        
    case 'update':
        $product_id = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];
        
        if (updateCartItem($user_id, $product_id, $quantity)) {
            $total = getCartTotal($user_id);
            echo json_encode([
                'success' => true,
                'cart_total' => number_format($total, 2)
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update item']);
        }
        break;
        
    case 'remove':
        $product_id = (int)$_POST['product_id'];
        
        if (removeFromCart($user_id, $product_id)) {
            $total = getCartTotal($user_id);
            echo json_encode([
                'success' => true,
                'message' => 'Item removed',
                'cart_total' => number_format($total, 2)
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to remove item']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}







?>