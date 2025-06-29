<?php
require __DIR__ . '/../includes/admin_authenticate.php';
require 'C:\xampp\htdocs\eCommerceProject\includes\db_connection.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_status') {
    // Status validation
    $allowedStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'];
    if (!in_array($_POST['status'], $allowedStatuses) || !isset($_POST['status'])) {
        $errors[] = "Invalid order status";
    }

    // Order ID validation (for updates)
    // Order ID validation
    if (!isset($_POST['order_id']) || !is_numeric($_POST['order_id'])) {
        $errors[] = "Invalid order ID";
    } else {
        $order_id = (int)$_POST['order_id'];
        $stmt = $conn->prepare("SELECT id FROM orders WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $errors[] = "Order does not exist";
        }
        $stmt->close();
    }

    if (empty($errors)) {
        $order_id = (int)$_POST['order_id'];
        $status = $_POST['status'];

        $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $order_id);

        if ($stmt->execute()) {
            $success_message = "Order status updated successfully";
        } else {
            $errors[] = "Failed to update order status";
        }
        $stmt->close();
    }
}
$orders = $conn->query("
    SELECT o.*, u.username, sm.name as shipping_method, a.street, a.city 
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.user_id
    LEFT JOIN shipping_method sm ON o.shipping_method_id = sm.id
    LEFT JOIN address a ON o.delivery_id = a.address_id
    ORDER BY o.order_date DESC
");

$ordersquery = $conn->query($orders);
if (!$orders) {
    die("Error loading Orders: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>MANAGE ORDERS</title>
    <link rel="stylesheet" href="/eCommerceProject/includes/style.css">
    <link rel="stylesheet" href="/eCommerceProject/includes/style2.css">
    <style>
        .order-status {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-processing {
            background-color: #cce5ff;
            color: #004085;
        }

        .status-shipped {
            background-color: #d4edda;
            color: #155724;
        }

        .status-delivered {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-refunded {
            background-color: #e2e3e5;
            color: #383d41;
        }

        .data-table td,
        .data-table th {
            padding: 12px 15px;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <h1 class="admin-title">Manage Orders</h1>

        <table class="data-table">
            <thead>
                <tr>
                    <th>ORDER ID</th>
                    <th>CUSTOMER</th>
                    <th>DATE</th>
                    <th>SHIPPING TO</th>
                    <th>TOTAL</th>
                    <th>STATUS</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $orders->fetch_assoc()): ?>
                    <tr>
                        <td>#<?= $order['id'] ?></td>
                        <td><?= htmlspecialchars($order['username']) ?></td>
                        <td><?= date('M j, Y', strtotime($order['order_date'])) ?></td>
                        <td><?= htmlspecialchars(($order['street'] ? $order['street'] . ',' : '') . ($order['city'] ?? 'N/A')) ?></td>
                        <td>$<?= number_format($order['order_total'], 2) ?></td>
                        <td>
                            <form method="POST" class="inline-form">
                                <select name="status" class="form-input" onchange="this.form.submit()">
                                    <option value="pending" <?= $order['order_status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="processing" <?= $order['order_status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                    <option value="shipped" <?= $order['order_status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                    <option value="delivered" <?= $order['order_status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                    <option value="cancelled" <?= $order['order_status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    <option value="refunded" <?= $order['order_status'] == 'refunded' ? 'selected' : '' ?>>Refunded</option>
                                </select>
                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                <input type="hidden" name="action" value="update_status">
                            </form>
                        </td>
                        <td>
                            <a href="order_details.php?id=<?= $order['id'] ?>" class="btn btn-sm">Details</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>