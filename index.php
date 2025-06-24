<?php error_reporting(E_ALL); ini_set('display_errors', 1); ?>
<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Product Catalog</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Product Catalog</h2>

<!-- Search + Category Filter Form -->
<form method="GET" action="">
  <input type="text" name="search" placeholder="Search..." value="<?= $_GET['search'] ?? '' ?>">
  <select name="category">
    <option value="">All Categories</option>
    <option value="Electronics">Electronics</option>
    <option value="Fashion">Fashion</option>
    <option value="Books">Books</option>
  </select>
  <button type="submit">Filter</button>
</form>

<!-- Display Products -->
<div class="product-list">
<?php
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';

$sql = "SELECT * FROM products WHERE 1";

if ($search) {
  $sql .= " AND name LIKE '%$search%'";
}
if ($category) {
  $sql .= " AND category = '$category'";
}

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

while ($row = $result->fetch_assoc()) {
  echo "<div class='product-card'>";
  echo "<img src='images/{$row['image']}' alt='Product Image'>";
  echo "<h3>{$row['name']}</h3>";
  echo "<p>{$row['description']}</p>";
  echo "<p><strong>\${$row['price']}</strong></p>";
  echo "</div>";
}
?>
</div>

</body>
</html>
