<?php
require __DIR__ . '/../includes/db_connection.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate inputs
    $username = trim($_POST['username']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validate password strength
    if (strlen($password) < 8) {
        $error = "Password must be at least 8 characters";
    } elseif (!preg_match("/[A-Z]/", $password)) {
        $error = "Password must contain at least one uppercase letter";
    } else {
        try {
            // Check if email already exists
            $check_stmt = $conn->prepare("SELECT user_id FROM users WHERE email_address = ?");
            $check_stmt->bind_param("s", $email);
            $check_stmt->execute();

            if ($check_stmt->get_result()->num_rows > 0) {
                $error = "Email already registered";
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert new user 
                $stmt = $conn->prepare("INSERT INTO users (username, email_address, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $username, $email, $hashed_password);

                if ($stmt->execute()) {
                    $success = "Registration successful! Redirecting...";
                    header("Refresh: 2; URL=login.php");
                }
            }
        } catch (Exception $e) {
            error_log("Signup error: " . $e->getMessage());
            $error = "System error. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
    <link rel='stylesheet' href='/eCommerceProject/includes/style.css'>
    <style>
        .error {
            color: red;
            margin: 10px 0;
        }

        .success {
            color: green;
            margin: 10px 0;
        }

        .password-hint {
            font-size: 0.8em;
            color: #666;
            margin-top: -15px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <form method="POST">
        <h2>Create Account</h2>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <input name="username" required placeholder="Username"
            value="<?= htmlspecialchars($username ?? '') ?>"><br>

        <input name="email" type="email" required placeholder="Email"
            value="<?= htmlspecialchars($email ?? '') ?>"><br>

        <input name="password" type="password" required placeholder="Password"><br>
        <div class="password-hint">
            Must be at least 8 characters with one uppercase letter
        </div>

        <button type="submit">Sign Up</button>
        <p>Already have an account? <a href="login.php">Log in</a></p>
    </form>
</body>

</html>