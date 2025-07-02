<?php
session_start();
include_once 'includes/db.php';
include_once 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$product_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->bind_param("s", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p class='error-msg'>Product not found.</p>";
    include_once 'includes/footer.php';
    exit;
}

$product = $result->fetch_assoc();

// 🖼️ Get image from product_images table
$imageQuery = $conn->prepare("SELECT image_url, alt_text FROM product_images WHERE product_id = ? LIMIT 1");
$imageQuery->bind_param("s", $product_id);
$imageQuery->execute();
$imageResult = $imageQuery->get_result();
$image = $imageResult->fetch_assoc();

$image_url = $image ? 'uploads/' . $image['image_url'] : 'uploads/default.jpg';
$alt_text = $image ? $image['alt_text'] : $product['name'];
?>

<section class="product-detail">
    <div class="product-image">
        <img src="<?= $image_url ?>" alt="<?= htmlspecialchars($alt_text) ?>" width="400">
    </div>
    <div class="product-info">
        <h2><?= htmlspecialchars($product['name']) ?></h2>
        <p><?= htmlspecialchars($product['description']) ?></p>
        <strong class="price">KES <?= number_format($product['price']) ?></strong>

        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" value="1" min="1">
            <button type="submit" name="add_to_cart" class="btn">Add to Cart 🛒</button>
        </form>

        <div class="product-actions">
            <a href="cart.php" class="btn">View Cart</a>
            <a href="index.php" class="btn">Continue Shopping</a>
        </div>
    </div>
</section>

<?php include_once 'includes/footer.php'; ?>
