<?php

require __DIR__ . '/../includes/admin_authenticate.php';
require __DIR__ . '/../includes/db_connection.php';

$errors = [];

// Handle actions
if (isset($_GET['approve'])) {
    $id = (int)$_GET['approve'];
    $conn->query("UPDATE reviews SET is_approved=1 WHERE id=$id");
    header("Location: reviews.php");
    exit();
} elseif (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM reviews WHERE id=$id");
    header("Location: reviews.php");
    exit();
}

// Get all reviews
$reviews = $conn->query("
    SELECT r.*, u.username, p.name as product_name 
    FROM reviews r
    JOIN users u ON r.user_id = u.user_id
    JOIN order_items oi ON r.order_item_id = oi.id
    JOIN product p ON oi.product_id = p.id
    ORDER BY r.created_at DESC
");

if (!$reviews) {
    die("Error loading reviews: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>MANAGE REVIEWS</title>

    <link rel="stylesheet" href="/eCommerceProject/includes/style.css">
    <link rel="stylesheet" href="/eCommerceProject/includes/style2.css">
    <style>
        .review-card {
            background: white;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .review-meta {
            color: #666;
        }

        .stars {
            color: #ffc107;
            font-weight: bold;
        }

        .review-actions {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <h1 class="admin-title">Manage Reviews</h1>

        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="review-list">
            <?php while ($review = $reviews->fetch_assoc()): ?>
                <div class="review-card <?= $review['is_approved'] ? 'approved' : 'pending' ?>">
                    <div class="review-header">
                        <div class="review-meta">
                            <strong><?= htmlspecialchars($review['product_name']) ?></strong>
                            <span>by <?= htmlspecialchars($review['username']) ?></span>
                            <span>• <?= date('M d, Y', strtotime($review['created_at'])) ?></span>
                        </div>
                        <div class="stars">
                            <?= str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']) ?>
                        </div>
                    </div>

                    <h4><?= htmlspecialchars($review['title']) ?></h4>
                    <p><?= htmlspecialchars($review['review']) ?></p>

                    <div class="review-actions">
                        <?php if (!$review['is_approved']): ?>
                            <a href="?approve=<?= $review['id'] ?>" class="btn btn-sm">Approve</a>
                        <?php endif; ?>
                        <a href="?delete=<?= $review['id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Delete this review?')">Delete</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>