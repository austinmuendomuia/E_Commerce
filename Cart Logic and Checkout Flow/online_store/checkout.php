<?php
require_once 'includes/session_check.php';
require_once 'includes/cart_functions.php';

requireLogin();

$user_id = $_SESSION['user_id'];
$cart_items = getCartItems($user_id);
$cart_total = getCartTotal($user_id);

// Redirect if cart is empty
if (empty($cart_items)) {
    header("Location: cart.php");
    exit();
}

// Get user details
require_once 'config/database.php';
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Online Store</title>
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

    <main class="checkout-container">
        <h1>Checkout</h1>
        
        <div class="checkout-content">
            <!-- Order Summary -->
            <div class="order-summary">
                <h2>Your Order</h2>
                <div class="order-items">
                    <?php foreach ($cart_items as $item): ?>
                        <div class="order-item">
                            <span class="item-name"><?= htmlspecialchars($item['name']) ?></span>
                            <span class="item-quantity">x<?= $item['quantity'] ?></span>
                            <span class="item-price">$<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="order-total">
                    <strong>Total: $<?= number_format($cart_total, 2) ?></strong>
                </div>
            </div>
            
            <!-- Checkout Form -->
            <div class="checkout-form">
                <form action="process_checkout.php" method="POST" id="checkout-form">
                    <h2>Billing Information</h2>
                    
                    <div class="form-group">
                        <label for="full_name">Full Name:</label>
                        <input type="text" id="full_name" name="full_name" 
                               value="<?= htmlspecialchars($user['full_name'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" 
                               value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea id="address" name="address" required><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City:</label>
                            <input type="text" id="city" name="city" 
                                   value="<?= htmlspecialchars($user['city'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="postal_code">Postal Code:</label>
                            <input type="text" id="postal_code" name="postal_code" 
                                   value="<?= htmlspecialchars($user['postal_code'] ?? '') ?>" required>
                        </div>
                    </div>
                    
                    <h2>Payment Information</h2>
                    <p class="payment-note">This is a simulation - no real payment will be processed</p>
                    
                    <div class="form-group">
                        <label for="payment_method">Payment Method:</label>
                        <select id="payment_method" name="payment_method" required>
                            <option value="">Select Payment Method</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="debit_card">Debit Card</option>
                            <option value="paypal">PayPal</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="card_number">Card Number:</label>
                        <input type="text" id="card_number" name="card_number" 
                               placeholder="1234 5678 9012 3456" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="expiry_date">Expiry Date:</label>
                            <input type="text" id="expiry_date" name="expiry_date" 
                                   placeholder="MM/YY" required>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV:</label>
                            <input type="text" id="cvv" name="cvv" 
                                   placeholder="123" required>
                        </div>
                    </div>
                    
                    <div class="checkout-actions">
                        <a href="cart.php" class="btn btn-secondary">Back to Cart</a>
                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Form validation and formatting
        document.getElementById('card_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
            e.target.value = value;
        });
        
        document.getElementById('expiry_date').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });
        
        document.getElementById('cvv').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').substring(0, 3);
        });
        
        // Form submission
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            // Add any additional validation here
            const cardNumber = document.getElementById('card_number').value.replace(/\s/g, '');
            if (cardNumber.length < 16) {
                e.preventDefault();
                alert('Please enter a valid card number');
                return;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.textContent = 'Processing...';
            submitBtn.disabled = true;
        });
    </script>
</body>
</html>