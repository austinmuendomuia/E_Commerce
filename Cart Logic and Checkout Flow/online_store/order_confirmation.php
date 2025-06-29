<?php
require_once 'includes/session_check.php';
require_once 'config/database.php';

requireLogin();

$order_id = $_GET['order_id'] ?? 0;
$user_id = $_SESSION['user_id'];

// Get order details
$stmt = $pdo->prepare("
    SELECT o.*, u.email, u.full_name 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    WHERE o.id = ? AND o.user_id = ?
");
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header("Location: index.php");
    exit();
}

// Get order items
$stmt = $pdo->prepare("
    SELECT oi.*, p.name, p.image 
    FROM order_items oi 
    JOIN products p ON oi.product_id = p.id 
    WHERE oi.order_id = ?
");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Online Store</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="cart.php">Cart</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="confirmation-container">
        <div class="confirmation-header">
            <h1>✅ Order Confirmed!</h1>
            <p>Thank you for your purchase, <?= htmlspecialchars($order['full_name']) ?>!</p>
        </div>
        
        <div class="order-details">
            <div class="order-info">
                <h2>Order Information</h2>
                <p><strong>Order ID:</strong> #<?= $order['id'] ?></p>
                <p><strong>Date:</strong> <?= date('F j, Y g:i A', strtotime($order['order_date'])) ?></p>
                <p><strong>Payment Method:</strong> <?= ucwords(str_replace('_', ' ', $order['payment_method'])) ?></p>
                <p><strong>Status:</strong> <?= ucfirst($order['order_status']) ?></p>
            </div>
            
            <div class="order-items">
                <h2>Items Ordered</h2>
                <?php foreach ($order_items as $item): ?>
                    <div class="order-item">
                        <img src="<?= htmlspecialchars($item['image']) ?>" 
                             alt="<?= htmlspecialchars($item['name']) ?>">
                        <div class="item-details">
                            <h3><?= htmlspecialchars($item['name']) ?></h3>
                            <p>Quantity: <?= $item['quantity'] ?></p>
                            <p>Price: $<?= number_format($item['price'], 2) ?></p>
                        </div>
                        <div class="item-total">
                            $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="order-total">
                <h2>Order Total: $<?= number_format($order['total_amount'], 2) ?></h2>
            </div>
        </div>
        
        <div class="confirmation-actions">
            <a href="products.php" class="btn btn-primary">Continue Shopping</a>
            <a href="index.php" class="btn btn-secondary">Back to Home</a>
        </div>
        
        <div class="next-steps">
            <h3>What's Next?</h3>
            <ul>
                <li>You'll receive an email confirmation shortly</li>
                <li>Your order will be processed within 1-2 business days</li>
                <li>You can track your order status in your account</li>
            </ul>
        </div>
    </main>
</body>
</html>