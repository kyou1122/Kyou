<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION['user']['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="user.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="welcome">
            WELCOME, <span class="username"><?= htmlspecialchars($username) ?></span>
        </div>
        <a href="login.php" class="logout">LOG OUT</a>
    </header>

    <!-- Buttons -->
    <div class="button-container">
        <button onclick="window.location.href='userbussiness.php'" class="btn-business">BUSINESS</button>
        <button onclick="window.location.href='userstatus.php'" class="btn-status">STATUS</button>
    </div>

    <div class="copyright">
       COPYRIGHT &copy; CHONG KHIUN CHIEN
    </div>
</body>
</html>
