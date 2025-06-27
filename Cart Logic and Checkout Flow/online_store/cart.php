<?php
require_once 'includes/session_check.php';
require_once 'includes/cart_functions.php';

requireLogin(); // Redirect to login if not logged in

$user_id = $_SESSION['user_id'];
$cart_items = getCartItems($user_id);
$cart_total = getCartTotal($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Online Store</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="cart.php" class="active">Cart</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="cart-container">
        <h1>Your Shopping Cart</h1>
        
        <?php if (empty($cart_items)): ?>
            <div class="empty-cart">
                <p>Your cart is empty</p>
                <a href="products.php" class="btn">Continue Shopping</a>
            </div>
        <?php else: ?>
            <div class="cart-items">
                <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item" data-product-id="<?= $item['product_id'] ?>">
                        <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                        <div class="item-details">
                            <h3><?= htmlspecialchars($item['name']) ?></h3>
                            <p class="price">$<?= number_format($item['price'], 2) ?></p>
                        </div>
                        <div class="quantity-controls">
                            <button class="qty-btn" data-action="decrease">-</button>
                            <input type="number" class="quantity-input" value="<?= $item['quantity'] ?>" min="1">
                            <button class="qty-btn" data-action="increase">+</button>
                        </div>
                        <div class="item-total">
                            $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                        </div>
                        <button class="remove-btn" data-product-id="<?= $item['product_id'] ?>">Remove</button>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="cart-summary">
                <div class="total">
                    <strong>Total: $<span id="cart-total"><?= number_format($cart_total, 2) ?></span></strong>
                </div>
                <div class="cart-actions">
                    <a href="products.php" class="btn btn-secondary">Continue Shopping</a>
                    <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <script>
        // Cart functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Quantity controls
            document.querySelectorAll('.qty-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const cartItem = this.closest('.cart-item');
                    const productId = cartItem.dataset.productId;
                    const quantityInput = cartItem.querySelector('.quantity-input');
                    const action = this.dataset.action;
                    
                    let newQuantity = parseInt(quantityInput.value);
                    if (action === 'increase') {
                        newQuantity++;
                    } else if (action === 'decrease' && newQuantity > 1) {
                        newQuantity--;
                    }
                    
                    updateCartItem(productId, newQuantity);
                    quantityInput.value = newQuantity;
                });
            });
            
            // Direct quantity input
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const cartItem = this.closest('.cart-item');
                    const productId = cartItem.dataset.productId;
                    const quantity = parseInt(this.value);
                    
                    if (quantity >= 1) {
                        updateCartItem(productId, quantity);
                    }
                });
            });
            
            // Remove buttons
            document.querySelectorAll('.remove-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = this.dataset.productId;
                    removeCartItem(productId);
                });
            });
        });
        
        function updateCartItem(productId, quantity) {
            fetch('ajax/cart_operations.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=update&product_id=${productId}&quantity=${quantity}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('cart-total').textContent = data.cart_total;
                    // Update item total
                    const cartItem = document.querySelector(`[data-product-id="${productId}"]`);
                    const price = parseFloat(cartItem.querySelector('.price').textContent.replace('$', ''));
                    const itemTotal = cartItem.querySelector('.item-total');
                    itemTotal.textContent = '$' + (price * quantity).toFixed(2);
                } else {
                    alert(data.message);
                }
            });
        }
        
        function removeCartItem(productId) {
            if (confirm('Remove this item from cart?')) {
                fetch('ajax/cart_operations.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=remove&product_id=${productId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`[data-product-id="${productId}"]`).remove();
                        document.getElementById('cart-total').textContent = data.cart_total;
                        
                        // Check if cart is empty
                        if (document.querySelectorAll('.cart-item').length === 0) {
                            location.reload();
                        }
                    } else {
                        alert(data.message);
                    }
                });
            }
        }
    </script>
</body>
</html>