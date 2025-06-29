<?php session_start(); ?>
<nav>
  <?php if (isset($_SESSION['user_id'])): ?>
    Welcome, <?= $_SESSION['username'] ?> |
    <a href="logout.php">Logout</a>
  <?php else: ?>
    <a href="login.php">Login</a> | <a href="signup.php">Signup</a>
  <?php endif; ?>
</nav>
