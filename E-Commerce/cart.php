<?php
session_start();
include_once 'includes/db.php';
include_once 'includes/header.php';

// TEMP DEBUG: Uncomment to reset cart if it's corrupted
// unset($_SESSION['cart']);

// Step 1: Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    // Fetch product from DB
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        $item = [
            'product_id' => $product['product_id'],
            'name'       => $product['name'],
            'price'      => $product['price'],
            'quantity'   => $quantity
        ];

        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $_SESSION['cart'][] = $item;
    }

    header("Location: cart.php");
    exit;
}
?>

<div class='container'>
    <h2>Your Cart 🛒</h2>

    <?php if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <ul>
        <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $item):
                if (!is_array($item)) continue; // skip broken items

                $lineTotal = $item['price'] * $item['quantity'];
                $total += $lineTotal;
        ?>
            <li><?= htmlspecialchars($item['name']) ?> x <?= $item['quantity'] ?> — KES <?= number_format($lineTotal, 2) ?></li>
        <?php endforeach; ?>
        </ul>

        <strong>Total: KES <?= number_format($total, 2) ?></strong><br><br>
        <a href='checkout.php'><button>Proceed to Checkout</button></a>
    <?php endif; ?>
</div>

<?php include_once 'includes/footer.php'; ?>
