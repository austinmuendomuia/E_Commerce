<?php
require __DIR__ . '/../includes/admin_authenticate.php';
require 'C:\xampp\htdocs\eCommerceProject\includes\db_connection.php';

if (!isset($_GET['id'])) {
    header("Location: orders.php");
    exit();
}

$order_id = (int)$_GET['id'];

// Get order details
$order = $conn->query("
    SELECT o.*, u.username, u.email_address, u.phone_number, 
           sm.name as shipping_method, sm.cost as shipping_cost,
           a.*
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.user_id
    LEFT JOIN shipping_method sm ON o.shipping_method_id = sm.id
    LEFT JOIN address a ON o.delivery_id = a.address_id
    WHERE o.id = $order_id
")->fetch_assoc();

if (!$order) {
    header("Location: orders.php");
    exit();
}

// Get order items
$items = $conn->query("
    SELECT oi.*, p.name as product_name 
    FROM order_items oi
    LEFT JOIN product p ON oi.product_id = p.id
    WHERE oi.order_id = $order_id
");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['status'])) {
    if ($_POST['action'] == 'update_status') {
        $errors = [];

        // Status validation
        $allowedStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'];
        if (!in_array($_POST['status'], $allowedStatuses)) {
            $errors[] = "Invalid order status";
        }

        // Order ID validation (for updates)
        if (isset($_POST['order_id'])) {
            $orderExists = $conn->query("SELECT id FROM orders WHERE id = " . (int)$_POST['order_id'])->num_rows;
            if (!$orderExists) {
                $errors[] = "Order does not exist";
            }
        }
    }
    // Update status if form submitted
    if (isset($_POST['action']) && $_POST['action'] == 'update_status') {
        $status = $conn->real_escape_string($_POST['status']);
        $conn->query("UPDATE orders SET order_status='$status' WHERE id=$order_id");
        $order['order_status'] = $status;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>ORDER DETAILS</title>
    <link rel="stylesheet" href="/eCommerceProject/includes/style.css">
    <link rel="stylesheet" href="/eCommerceProject/includes/style2.css">
    <style>
        .order-section {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .order-section h2 {
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            text-align: left;
            padding: 12px;
            background: #f2f2f2;
        }

        .data-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .total-row {
            font-weight: bold;
            background: #f9f9f9;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
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
    </style>
</head>

<body>
    <div class="admin-container">
        <h1 class="admin-title">Order Details #<?= $order_id ?></h1>

        <div class="order-section">
            <h2>Customer Information</h2>
            <p><strong>Name:</strong> <?= htmlspecialchars($order['username']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($order['email_address']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone_number'] ?: 'N/A') ?></p>
            <p><strong>Order Status:</strong>
                <span class="status-badge status-<?= $order['order_status'] ?>">
                    <?= ucfirst($order['order_status']) ?>
                </span>
            </p>
        </div>

        <div class="order-section">
            <h2>Shipping Information</h2>
            <p><strong>Address:</strong><br>
                <?= htmlspecialchars($order['street'] ?: 'N/A') ?><br>
                <?= $order['unit_number'] ? htmlspecialchars('Unit: ' . $order['unit_number']) . '<br>' : '' ?>
                <?= htmlspecialchars($order['city'] ?: 'N/A') ?>,
                <?= htmlspecialchars($order['region'] ?: 'N/A') ?><br>
                <?= htmlspecialchars($order['postal_code'] ?: 'N/A') ?><br>
                <?= htmlspecialchars($order['country'] ?: 'N/A') ?>
            </p>
            <p><strong>Shipping Method:</strong>
                <?= htmlspecialchars($order['shipping_method']) ?>
                ($<?= number_format($order['shipping_cost'], 2) ?>)
            </p>
        </div>

        <div class="order-section">
            <h2>Order Items</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>PRODUCT</th>
                        <th>PRICE</th>
                        <th>QUANTITY</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = $items->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['product_name']) ?></td>
                            <td>$<?= number_format($item['unit_price'], 2) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>$<?= number_format($item['total_price'], 2) ?></td>
                        </tr>
                    <?php endwhile; ?>
                    <tr class="total-row">
                        <td colspan="3"><strong>Subtotal:</strong></td>
                        <td>$<?= number_format($order['order_total'] - $order['shipping_cost'], 2) ?></td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3"><strong>Shipping:</strong></td>
                        <td>$<?= number_format($order['shipping_cost'], 2) ?></td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3"><strong>Total:</strong></td>
                        <td>$<?= number_format($order['order_total'], 2) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="order-section">
            <h2>Update Status</h2>
            <form method="POST">
                <div class="form-row">
                    <select name="status" class="form-input">
                        <option value="pending" <?= $order['order_status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="processing" <?= $order['order_status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                        <option value="shipped" <?= $order['order_status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                        <option value="delivered" <?= $order['order_status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                        <option value="cancelled" <?= $order['order_status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        <option value="refunded" <?= $order['order_status'] == 'refunded' ? 'selected' : '' ?>>Refunded</option>
                    </select>
                    <input type="hidden" name="action" value="update_status">
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>

        <a href="orders.php" class="btn">Back to Orders</a>
    </div>
</body>

</html>