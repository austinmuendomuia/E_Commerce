<?php
require __DIR__ . '/../includes/admin_authenticate.php';
require 'C:\xampp\htdocs\eCommerceProject\includes\db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    // Category validation
    if (strlen($_POST['name']) > 50) {
        $errors[] = "Name too long";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: categories.php");
        exit();
    }

    // Safe to proceed
    $conn->query("INSERT ...");
}
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $name = $conn->real_escape_string($_POST['name']);
    $conn->query("INSERT INTO category (category_name) VALUES ('$name')");
}

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $id = (int)$_POST['id'];
    $name = $conn->real_escape_string($_POST['name']);
    $conn->query("UPDATE category SET category_name='$name' WHERE id=$id");
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $conn->query("DELETE FROM category WHERE id=$id");
    }
}
$categories = $conn->query("SELECT * FROM category ORDER BY category_name");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>MANAGE CATEGORIES</title>
    <link rel="stylesheet" href="/eCommerceProject/includes/style.css">
    <link rel="stylesheet" href="/eCommerceProject/includes/style2.css">
    <style>
        .inline-form {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .inline-form .form-input {
            margin: 0;
            flex: 1;
        }

        .data-table {
            width: 100%;
            margin-top: 20px;
        }

        .data-table th {
            text-align: left;
            background: #f2f2f2;
            padding: 12px 15px;
        }

        .data-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <h1 class="admin-title">Manage Categories</h1>
        <div class="form-container">
            <form method="POST">
                <div class="form-row">
                    <input type="text" name="name" class="form-input" placeholder="Category Name" required>
                    <input type="hidden" name="action" value="add">
                    <button type="submit" class="btn btn-primary">ADD CATEGORY</button>
                </div>
            </form>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>CATEGORY NAME</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($cat = $categories->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <form method="POST" class="inline-form">
                                <input type="text" name="name" class="form-input"
                                    value="<?= htmlspecialchars($cat['category_name']) ?>" required>
                                <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                                <input type="hidden" name="action" value="update">
                                <button type="submit" class="btn btn-sm">Update</button>
                            </form>
                        </td>
                        <td>
                            <a href="?delete=<?= $cat['id'] ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this category?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>