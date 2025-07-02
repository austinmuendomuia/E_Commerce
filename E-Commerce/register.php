<?php
session_start();
include_once 'includes/db.php';
include_once 'includes/header.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = uniqid('USR_'); // Fix: Generate unique ID
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email already exists
    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");

    $check->bind_param("s", $email);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows > 0) {
        $msg = "Email already exists.";
    } else {
        // Insert new user
       $stmt = $conn->prepare("INSERT INTO users (user_id, username, email, phone_numbers, password) VALUES (?, ?, ?, ?, ?)");

        $stmt->bind_param("sssss", $user_id, $username, $email, $phone_numbers, $password);
        if ($stmt->execute()) {
            $msg = "Account created successfully. You can now <a href='login.php'>Login</a>.";
        } else {
            $msg = "Registration failed. Please try again.";
        }
    }
}
?>

<div class="container">
  <h2>Register</h2>
  <?php if (!empty($msg)): ?>
    <p style="color:red;"><?= $msg ?></p>
  <?php endif; ?>
  <form method="POST">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Create Account</button>
  </form>
</div>

<?php include_once 'includes/footer.php'; ?>
