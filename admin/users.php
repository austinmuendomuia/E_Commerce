<?php
require __DIR__ . '/../includes/admin_authenticate.php';
require 'C:\xampp\htdocs\eCommerceProject\includes\db_connection.php';

$errors = [];
//Email validation
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

// Status validation
if (!in_array($_POST['status'], [0, 1])) {
    $errors[] = "Invalid user status";
}


if (isset($_POST['action']) && $_POST['action'] == 'update_status') {
    $user_id = (int)$_POST['user_id'];
    $status = $conn->real_escape_string($_POST['status']);
    $conn->query("UPDATE users SET is_active='$status' WHERE user_id=$user_id");
}

$users = $conn->query("
    SELECT u.*, 
           GROUP_CONCAT(DISTINCT a.city ORDER BY a.city SEPARATOR ', ') as locations
    FROM users u
    LEFT JOIN user_address ua ON u.user_id = ua.user_id
    LEFT JOIN address a ON ua.address_id = a.address_id
    GROUP BY u.user_id
    ORDER BY u.username
");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>MANAGE USERS</title>
    <link rel="stylesheet" href="/eCommerceProject/includes/style.css">
    <link rel="stylesheet" href="/eCommerceProject/includes/style2.css">
    <style>
        .user-status {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 14px;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
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

        .form-row {
            display: flex;
            gap: 10px;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <h1 class="admin-title">Manage Users</h1>

        <table class="data-table">
            <thead>
                <tr>
                    <th>USERNAME</th>
                    <th>EMAIL</th>
                    <th>LOCATIONS</th>
                    <th>STATUS</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email_address']) ?></td>
                        <td><?= htmlspecialchars($user['locations'] ?: 'N/A') ?></td>
                        <td>
                            <form method="POST" class="form-row">
                                <select name="status" onchange="this.form.submit()" class="form-input">
                                    <option value="1" <?= $user['is_active'] ? 'selected' : '' ?>>Active</option>
                                    <option value="0" <?= !$user['is_active'] ? 'selected' : '' ?>>Inactive</option>
                                </select>
                                <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                <input type="hidden" name="action" value="update_status">
                            </form>
                        </td>
                        <td>
                            <a href="user_details.php?id=<?= $user['user_id'] ?>" class="btn btn-sm">View</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>