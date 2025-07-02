<?php
session_start();


if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}


error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("localhost", "root", "", "project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "
SELECT 
    b.id,
    b.business_name,
    b.type,
    b.address,
    u.username,
    u.email
FROM 
    businesses b
JOIN 
    users u ON b.user_id = u.id";

$result = $conn->query($query);
$businesses = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Business Records</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <div class="sidebar">
        <h2>ADMIN DASHBOARD</h2>
        <a href="adminanalystics&report.php">ANALYTICS & REPORT</a>
        <a href="adminusermanagment.php">USER MANAGEMENT</a>
        <a href="adminbusiness.php" class="active">BUSINESS</a>
        <a href="adminapplication.php">APPLICATION</a>
        <a href="logout.php">LOG OUT</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>All Registered Businesses</h2>
        </div>
        <div class="container">
            <?php if (count($businesses) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Business Name</th>
                            <th>Type</th>
                            <th>Address</th>
                            <th>Owner (Username)</th>
                            <th>Owner Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($businesses as $biz): ?>
                            <tr>
                                <td><?= htmlspecialchars($biz['id']) ?></td>
                                <td><?= htmlspecialchars($biz['business_name']) ?></td>
                                <td><?= htmlspecialchars($biz['type']) ?></td>
                                <td><?= htmlspecialchars($biz['address']) ?></td>
                                <td><?= htmlspecialchars($biz['username']) ?></td>
                                <td><?= htmlspecialchars($biz['email']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No businesses registered.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="copyright">
        COPYRIGHT &copy; CHONG KHIUN CHIEN
    </div>
</body>

</html>