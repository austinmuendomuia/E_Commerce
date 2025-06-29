<?php
require __DIR__ . '/../includes/admin_authenticate.php';
require 'C:\xampp\htdocs\eCommerceProject\includes\db_connection.php';

// Get stats
$result = $conn->query("SELECT COUNT(*) as count FROM product");
$products_count = $result ? $result->fetch_assoc()['count'] : 0;
$result = $conn->query("SELECT COUNT(*) as count FROM orders WHERE order_status != 'cancelled'");
$orders_count = $result ? $result->fetch_assoc()['count'] : 0;
$result = $conn->query("SELECT COUNT(*) as count FROM users");
$users_count = $result ? $result->fetch_assoc()['count'] : 0;
// Calculate total revenue from delivered orders
// Assuming 'order_total' is the column that holds the total amount for each order  
$result = $conn->query("SELECT SUM(order_total) as total FROM orders WHERE order_status = 'delivered'");
$revenue = $result ? ($result->fetch_assoc()['total'] ?: 0) : 0;

// Recent orders
$recent_orders = $conn->query("
    SELECT o.id, o.order_date, o.order_total, u.username 
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    ORDER BY o.order_date DESC
    LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>ADMIN DASHBOARD</title>
    <link rel="stylesheet" href="/eCommerceProject/includes/style.css">
    <link rel="stylesheet" href="/eCommerceProject/includes/style2.css">
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-card h3 {
            margin-top: 0;
            color: #555;
            font-size: 1.1rem;
        }

        .stat-card p {
            font-size: 24px;
            font-weight: bold;
            margin: 15px 0;
            color: #333;
        }

        .quick-links {
            margin-top: 40px;
        }

        .quick-links h2 {
            margin-bottom: 15px;
        }

        .recent-orders {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .recent-orders table {
            width: 100%;
            border-collapse: collapse;
        }

        .recent-orders th {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .recent-orders td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <h1 class="admin-title">Admin Dashboard</h1>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Products</h3>
                <p><?= $products_count ?></p>
                <a href="products.php" class="btn btn-sm">Manage</a>
            </div>
            <div class="stat-card">
                <h3>Orders</h3>
                <p><?= $orders_count ?></p>
                <a href="orders.php" class="btn btn-sm">Manage</a>
            </div>
            <div class="stat-card">
                <h3>Users</h3>
                <p><?= $users_count ?></p>
                <a href="users.php" class="btn btn-sm">Manage</a>
            </div>
            <div class="stat-card">
                <h3>Revenue</h3>
                <p>$<?= number_format($revenue ?: 0, 2) ?></p>
            </div>
        </div>

        <div class="quick-links">
            <h2>Quick Actions</h2>
            <a href="products.php?action=add" class="btn">Add Product</a>
            <a href="categories.php" class="btn">Manage Categories</a>
            <a href="reviews.php" class="btn">Moderate Reviews</a>
        </div>

        <div class="recent-orders">
            <h2>Recent Orders</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $recent_orders->fetch_assoc()): ?>
                        <tr>
                            <td><a href="order_details.php?id=<?= $order['id'] ?>">#<?= $order['id'] ?></a></td>
                            <td><?= htmlspecialchars($order['username']) ?></td>
                            <td><?= date('M j, Y', strtotime($order['order_date'])) ?></td>
                            <td>$<?= number_format($order['order_total'], 2) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>