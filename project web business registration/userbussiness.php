<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user']['id'];
$username = $_SESSION['user']['username'];

$sql = "SELECT * FROM businesses WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Business</title>
    <link rel="stylesheet" href="user.css">
</head>
<body>
    <header class="header">
        <div class="welcome">WELCOME, <span class="username"><?= htmlspecialchars($username) ?></span></div>
        <a href="logout.php" class="logout">LOG OUT</a>
    </header>

    <div class="button-container">
        <button class="btn-status active">BUSINESS</button>
        <button onclick="window.location.href='userstatus.php'" class="btn-status">STATUS</button>
    </div>

    <div class="content">
        <?php if ($result->num_rows > 0): 
            $row = $result->fetch_assoc(); ?>
            <h2>Your Business Information</h2>
            <p><strong>Business Name:</strong> <?= htmlspecialchars($row['business_name']) ?></p>
            <p><strong>Owner Name:</strong> <?= htmlspecialchars($row['name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
            <p><strong>IC Number:</strong> <?= htmlspecialchars($row['ic_number']) ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($row['address']) ?></p>
            <p><strong>Type:</strong> <?= htmlspecialchars($row['type']) ?></p>
        <?php else: ?>
            <p>YOU DON'T HAVE ANY BUSINESS RIGHT NOW</p>
            <button onclick="window.location.href='registerbussness.php'" class="btn-register">REGISTER</button>
        <?php endif; ?>
    </div>

    <div class="copyright">
        COPYRIGHT &copy; CHONG KHIUN CHIEN
    </div>
</body>
</html>
