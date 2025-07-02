<?php
session_start();
include_once 'includes/db.php';
include_once 'includes/header.php';

//  Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

//  Get cart data
$cart = $_SESSION['cart'] ?? [];
?>

<div class="container checkout-form">
  <h2>Checkout</h2>

  <?php if (empty($cart)): ?>
    <p>Your cart is empty. <a href="index.php">Go shopping 🛒</a></p>
  <?php else: ?>
    <!-- Updated form action -->
    <form action="place_order.php" method="POST">
      <label for="fullname">Full Name:</label>
      <input type="text" name="full_name" required><br>

      <label for="address">Address:</label>
      <textarea name="address" required></textarea><br>

      <label for="payment_method">Payment Method:</label>
      <select name="payment_method" required>
        <option value="Mpesa">Mpesa</option>
        <option value="Paypal">PayPal</option>
        <option value="Card">Credit/Debit Card</option>
        <option value="COD">Cash on Delivery</option>
      </select><br><br>

      <h3>🧾 Order Summary:</h3>
      <ul class="order-list">
        <?php
        $total = 0;
        foreach ($cart as $item):
            if (!is_array($item)) continue;
            $lineTotal = $item['price'] * $item['quantity'];
            $total += $lineTotal;
        ?>
          <li><?= htmlspecialchars($item['name']) ?> x <?= $item['quantity'] ?> – KES <?= number_format($lineTotal, 2) ?></li>
        <?php endforeach; ?>
      </ul>

      <p><strong>Total: KES <?= number_format($total, 2) ?></strong></p>

      <button type="submit" class="btn">✅ Place Order</button>
    </form>
  <?php endif; ?>
</div>

<?php include_once 'includes/footer.php'; ?>
