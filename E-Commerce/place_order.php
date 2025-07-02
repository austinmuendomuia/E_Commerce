<?php
session_start();
include_once 'includes/db.php';

// Redirect if user not logged in or no cart
if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header("Location: login.php");
    exit;
}

// Grab POST data
$user_id = $_SESSION['user_id'];
$full_name = trim($_POST['full_name']);
$address = trim($_POST['address']);
$payment_method = $_POST['payment_method'];

$total_amount = 0;
$order_id = uniqid('ORD_');

// Step 1: Calculate total
foreach ($_SESSION['cart'] as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

// Step 2: Insert into `orders`
$order_stmt = $conn->prepare("INSERT INTO orders (order_id, user_id, full_name, address, payment_method, total_amount) VALUES (?, ?, ?, ?, ?, ?)");
$order_stmt->bind_param("sssssd", $order_id, $user_id, $full_name, $address, $payment_method, $total_amount);
$order_stmt->execute();

// Step 3: Insert each item into `order_items`
foreach ($_SESSION['cart'] as $item) {
    $item_id = uniqid('ITM_');
    $item_stmt = $conn->prepare("INSERT INTO order_items (item_id, order_id, product_id, quantity, price) VALUES (?, ?, ?, ?, ?)");
    $item_stmt->bind_param("sssii", $item_id, $order_id, $item['product_id'], $item['quantity'], $item['price']);
    $item_stmt->execute();
}

// Step 4: Clear cart and redirect
unset($_SESSION['cart']);
header("Location: order_confirmed.php?order_id=$order_id");
exit;
