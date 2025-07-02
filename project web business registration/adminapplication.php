<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();


if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "
    SELECT 
        a.id AS application_id,
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
    <title>Admin - Applications</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>

    <div class="sidebar">
        <h2>ADMIN DASHBOARD</h2>
        <a href="adminanalystics&report.php">ANALYTICS & REPORT</a>
        <a href="adminusermanagment.php">USER MANAGEMENT</a>
        <a href="adminbusiness.php">BUSINESS</a>
        <a href="adminapplication.php" class="active">APPLICATION</a>
        <a href="logout.php">LOG OUT</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>All Applications</h2>
        </div>

        <div class="container">
            <?php if ($result && $result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
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
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()):
                            $status = $row['status'] ?? 'pending';
                            $status_class = match (strtolower($status)) {
                                'approved' => 'status-approved',
                                'rejected' => 'status-rejected',
                                default => 'status-pending'
                            };
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['application_id']) ?></td>
                                <td><?= htmlspecialchars($row['business_name']) ?></td>
                                <td><?= htmlspecialchars($row['owner_name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['ic_number']) ?></td>
                                <td><?= htmlspecialchars($row['address']) ?></td>
                                <td><?= htmlspecialchars($row['type']) ?></td>
                                <td class="<?= $status_class ?>"><?= ucfirst($status) ?></td>
                                <td><?= htmlspecialchars($row['date_submitted']) ?></td>
                                <td class="officer-name">
                                    <?= $row['officer_name'] ? htmlspecialchars($row['officer_name']) : 'Unassigned' ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No applications found.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="copyright">
        COPYRIGHT &copy; CHONG KHIUN CHIEN
    </div>
</body>

</html>