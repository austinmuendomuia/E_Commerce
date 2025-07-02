<?php
session_start();
include_once 'includes/db.php';
include_once 'includes/header.php';

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch products from database
$products = [];
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TechShop - Home</title>
    <link rel="stylesheet" href="css/style.css"> <!-- link your CSS here -->
</head>
<body>

<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-text">
        <h1>Welcome to TechShop</h1>
        <p>Find the latest gadgets, gear, and essentials – all in one place.</p>
        <a href="#products" class="shop-now">
            <i class="fa fa-shopping-cart"></i> Shop Now
        </a>
    </div>
</section>

<!-- FEATURED PRODUCTS -->
<div class="container" id="products">
  <h2>Our Products</h2>
  <div class="products-grid">
    <?php if (!empty($products)): ?>
      <?php foreach ($products as $product): ?>
        <?php
          // Fetch image for each product
          $imageQuery = $conn->prepare("SELECT image_url, alt_text FROM product_images WHERE product_id = ? LIMIT 1");
          $imageQuery->bind_param("s", $product['product_id']);
          $imageQuery->execute();
          $imageResult = $imageQuery->get_result();
          $image = $imageResult->fetch_assoc();

          $img_url = $image ? 'uploads/' . $image['image_url'] : 'uploads/default.jpg';
          $alt_text = $image ? $image['alt_text'] : 'Product Image';
        ?>
        <div class="product-card">
          <img src="<?= $img_url ?>" alt="<?= $alt_text ?>" class="product-image">
          <h3><?= htmlspecialchars($product['name']) ?></h3>
          <p><?= htmlspecialchars($product['description']) ?></p>
          <strong>KES <?= number_format($product['price']) ?></strong><br>
          <a href="product.php?id=<?= urlencode($product['product_id']) ?>" class="btn">View Product</a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No products available at the moment.</p>
    <?php endif; ?>
  </div>
</div>

<?php include_once 'includes/footer.php'; ?>
</body>
</html>
