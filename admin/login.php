<?php
session_start();
require __DIR__ . '/../includes/db_connection.php'; // Fixed path

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE email_address = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                header("Location: catalog.php");
                exit();
            }
        }

        // Generic error message for security
        echo "<div class='error'>Invalid email or password</div>";
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage());
        echo "<div class='error'>System error. Please try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel='stylesheet' href='/eCommerceProject/includes/style.css'>
    <style>
        .error {
            color: red;
            margin: 10px 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <form method="POST">
        <h2>Login</h2>
        <input name="email" type="email" required placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"><br>
        <input name="password" type="password" required placeholder="Password"><br>
        <button type="submit">Login</button>
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </form>
</body>

</html>