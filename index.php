<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Product Catalog</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Product Catalog</h2>

<!-- Search + Filter Form -->
<form method="GET" action="">
  <input type="text" name="search" placeholder="Search..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

  <!-- Category Dropdown -->
  <select name="category">
    <option value="">All Categories</option>
    <?php
      $category = $_GET['category'] ?? '';
      $cat_result = $conn->query("SELECT DISTINCT category FROM products ORDER BY category ASC");
      if ($cat_result) {
        while ($row = $cat_result->fetch_assoc()) {
          $cat = $row['category'];
          $selected = ($cat == $category) ? 'selected' : '';
          echo "<option value=\"" . htmlspecialchars($cat) . "\" $selected>" . htmlspecialchars($cat) . "</option>";
        }
      }
    ?>
  </select>

  <!-- Sort Dropdown -->
  <select name="sort">
    <option value="">Sort By</option>
    <option value="price_asc" <?= ($_GET['sort'] ?? '') === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
    <option value="price_desc" <?= ($_GET['sort'] ?? '') === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
    <option value="name_asc" <?= ($_GET['sort'] ?? '') === 'name_asc' ? 'selected' : '' ?>>Name: A–Z</option>
    <option value="name_desc" <?= ($_GET['sort'] ?? '') === 'name_desc' ? 'selected' : '' ?>>Name: Z–A</option>
  </select>

  <button type="submit">Filter</button>
</form>

<!-- Product Display Grid -->
<div class="product-list">
<?php
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$sort = $_GET['sort'] ?? '';

// Base query
$sql = "SELECT * FROM products WHERE 1";

// Add search filter
if ($search) {
  $safe_search = $conn->real_escape_string($search);
  $sql .= " AND name LIKE '%$safe_search%'";
}

// Add category filter
if ($category) {
  $safe_category = $conn->real_escape_string($category);
  $sql .= " AND category = '$safe_category'";
}

// Add sorting
switch ($sort) {
  case 'price_asc':
    $sql .= " ORDER BY price ASC";
    break;
  case 'price_desc':
    $sql .= " ORDER BY price DESC";
    break;
  case 'name_asc':
    $sql .= " ORDER BY name ASC";
    break;
  case 'name_desc':
    $sql .= " ORDER BY name DESC";
    break;
}

$result = $conn->query($sql);

// Display products
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $image = $row['image'] ?: 'default.jpg';
    echo "<div class='product-card'>";
    echo "<img src='images/{$image}' alt='Product Image'>";
    echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
    echo "<p>" . htmlspecialchars($row['description']) . "</p>";
    echo "<p><strong>\$" . number_format($row['price'], 2) . "</strong></p>";
    echo "</div>";
  }
} else {
  echo "<p>No products found.</p>";
}
?>
</div>

</body>
</html>
