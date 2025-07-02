<?php
session_start();
include_once 'includes/header.php';
$order_id = $_GET['order_id'] ?? 'UNKNOWN';
?>

<div class="container order-confirmation">
  <h2>🎉 Order Confirmed!</h2>
  <p>Thank you for shopping at <strong>TechShop</strong>.</p>
  <p>Your order has been placed successfully.</p>
  <p><strong>Order ID:</strong> <?= htmlspecialchars($order_id) ?></p>
  <br>
  <a href="index.php" class="btn">⬅️ Back to Home</a>
</div>

<?php include_once 'includes/footer.php'; ?>
