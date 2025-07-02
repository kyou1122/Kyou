<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Redirect if not officer
if (!isset($_SESSION['officer'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['officer']['username'] ?? 'Officer';

$sql = "
SELECT 
    b.business_name,
    b.name AS owner_name,
    b.email,
    b.ic_number,
    b.address,
    b.type,
    a.status,
    a.date_submitted,
    u.username AS officer_name
FROM 
    applications a
JOIN 
    businesses b ON a.business_id = b.id
LEFT JOIN 
    users u ON a.officer_id = u.id
ORDER BY 
    a.date_submitted DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verification Page</title>
    <link rel="stylesheet" href="user.css">
</head>
<body>

<header class="header">
    <div class="welcome">WELCOME, <span class="username"><?= htmlspecialchars($username) ?></span></div>
    <a href="logout.php" class="logout">LOG OUT</a>
</header>

<div class="button-container">
    <button onclick="window.location.href='officerdashboard.php'" class="btn-status">APPLICATION</button>
    <button class="btn-status active">VERIFICATION</button>
</div>


<div class="content">
    <h2>Verified Applications</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Business Name</th>
                <th>Owner Name</th>
                <th>Email</th>
                <th>IC Number</th>
                <th>Address</th>
                <th>Type</th>
                <th>Status</th>
                <th>Date Submitted</th>
                <th>Officer</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): 
                $status = $row['status'] ?? 'pending';
                $status_class = match(strtolower($status)) {
                    'approved' => 'status-approved',
                    'rejected' => 'status-rejected',
                    default => 'status-pending'
                };
            ?>
            <tr>
                <td><?= htmlspecialchars($row['business_name']) ?></td>
                <td><?= htmlspecialchars($row['owner_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['ic_number']) ?></td>
                <td><?= htmlspecialchars($row['address']) ?></td>
                <td><?= htmlspecialchars($row['type']) ?></td>
                <td class="<?= $status_class ?>"><?= ucfirst($status) ?></td>
                <td><?= htmlspecialchars($row['date_submitted']) ?></td>
                <td class="officer-name"><?= $row['officer_name'] ? htmlspecialchars($row['officer_name']) : 'N/A' ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No applications have been verified yet.</p>
    <?php endif; ?>
</div>
<div class="copyright">
       COPYRIGHT &copy; CHONG KHIUN CHIEN
    </div>
</body>
</html>