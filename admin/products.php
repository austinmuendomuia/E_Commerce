<?php

require __DIR__ . '/../includes/admin_authenticate.php';
require __DIR__ . '/../includes/db_connection.php';

$errors = [];
$success_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    // Simple validation
    if (empty($_POST['name'])) {
        $errors[] = "Product name is required";
    }

    if (empty($_POST['category_id']) || !is_numeric($_POST['category_id'])) {
        $errors[] = "Valid category is required";
    }

    // If no errors, process the form
    if (empty($errors)) {
        $name = $conn->real_escape_string($_POST['name']);
        $description = $conn->real_escape_string($_POST['description']);
        $category_id = (int)$_POST['category_id'];

        if ($_POST['action'] == 'add') {
            // Add new product
            $conn->query("INSERT INTO product (category_id, name, description) 
                         VALUES ($category_id, '$name', '$description')");

            if ($conn->error) {
                $errors[] = "Error adding product: " . $conn->error;
            } else {
                $success_message = "Product added successfully";
            }
        } elseif ($_POST['action'] == 'update') {
            // Update existing product
            $id = (int)$_POST['id'];
            $conn->query("UPDATE product SET 
                         name = '$name', 
                         description = '$description', 
                         category_id = $category_id 
                         WHERE id = $id");

            if ($conn->error) {
                $errors[] = "Error updating product";
            } else {
                $success_message = "Product updated successfully";
            }
        }
    }
}

// Handle delete 
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM product WHERE id = $id");
    header("Location: products.php");
    exit();
}

// Get products and categories
$products = $conn->query("SELECT p.*, c.category_name 
                         FROM product p 
                         LEFT JOIN category c ON p.category_id = c.id 
                         ORDER BY p.name");
$categories = $conn->query("SELECT * FROM category ORDER BY category_name");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>MANAGE PRODUCTS</title>
    <
        <link rel="stylesheet" href="/eCommerceProject/includes/style.css">
        <link rel="stylesheet" href="/eCommerceProject/includes/style2.css">
        <style>
            .product-card {
                border: 1px solid #ddd;
                padding: 15px;
                margin-bottom: 15px;
                border-radius: 5px;
                background: white;
            }

            .form-input {
                width: 100%;
                padding: 8px;
                margin-bottom: 10px;
            }

            .btn {
                padding: 8px 15px;
                margin-right: 5px;
                cursor: pointer;
            }

            .variant {
                margin-bottom: 15px;
                padding: 10px;
                border: 1px solid #eee;
            }
        </style>
        <script>
            // Simple variant addition kept
            function addVariant() {
                const container = document.getElementById('variants-container');
                const variantDiv = document.createElement('div');
                variantDiv.className = 'variant';
                variantDiv.innerHTML = `
                <div>
                    <input type="text" name="variants[][sku]" placeholder="SKU" class="form-input">
                    <input type="number" step="0.01" name="variants[][price]" placeholder="Price" class="form-input">
                    <input type="number" name="variants[][quantity]" placeholder="Quantity" class="form-input">
                </div>
                <div>
                    <input type="text" name="variants[][color]" placeholder="Color" class="form-input">
                    <input type="text" name="variants[][size]" placeholder="Size" class="form-input">
                    <button type="button" onclick="this.parentNode.parentNode.remove()" class="btn">Remove</button>
                </div>
            `;
                container.appendChild(variantDiv);
            }
        </script>
</head>

<body>
    <div class="admin-container">
        <h1 class="admin-title">Manage Products</h1>

        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST">
                <select name="category_id" class="form-input" required>
                    <option value="">Select Category</option>
                    <?php while ($cat = $categories->fetch_assoc()): ?>
                        <option value="<?= $cat['id'] ?>">
                            <?= htmlspecialchars($cat['category_name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <input type="text" name="name" class="form-input" placeholder="Product Name" required>

                <textarea name="description" class="form-input" placeholder="Description" required></textarea>

                <div id="variants-container">
                    <h3>Product Variants</h3>
                    <button type="button" onclick="addVariant()" class="btn">Add Variant</button>
                </div>

                <input type="hidden" name="action" value="add">
                <button type="submit" class="btn btn-primary">ADD PRODUCT</button>
            </form>
        </div>

        <div class="product-list">
            <?php while ($product = $products->fetch_assoc()): ?>
                <div class="product-card">
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p>Category: <?= htmlspecialchars($product['category_name']) ?></p>
                    <p><?= htmlspecialchars(substr($product['description'], 0, 100)) ?>...</p>
                    <div class="actions">
                        <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn">Edit</a>
                        <a href="?delete=<?= $product['id'] ?>" class="btn btn-danger"
                            onclick="return confirm('Delete this product?')">Delete</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>