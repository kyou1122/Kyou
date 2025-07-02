<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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

// Get applications with officer name
$sql = "
    SELECT b.*, a.status, u.username AS officer_name
    FROM businesses b
    LEFT JOIN applications a ON b.id = a.business_id
    LEFT JOIN users u ON a.officer_id = u.id
    WHERE b.user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Status</title>
    <link rel="stylesheet" href="user.css">
</head>
<body>

<header class="header">
    <div class="welcome">WELCOME, <span class="username"><?= htmlspecialchars($username) ?></span></div>
    <a href="logout.php" class="logout">LOG OUT</a>
</header>

<div class="button-container">
    <button onclick="window.location.href='userbussiness.php'" class="btn-status">BUSINESS</button>
    <button class="btn-status active">STATUS</button>
</div>

<div class="content">
    <h2>Business Registration Status</h2>

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
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['ic_number']) ?></td>
                <td><?= htmlspecialchars($row['address']) ?></td>
                <td><?= htmlspecialchars($row['type']) ?></td>
                <td class="<?= $status_class ?>"><?= ucfirst($status) ?></td>
                <td class="officer-name"><?= $row['officer_name'] ? htmlspecialchars($row['officer_name']) : 'Processing' ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <div class="status-note">
            PLEASE COME TO SSM BRANCH TO PROCEED MORE DETAILS AND BRINGING WITH DOCUMENT FOR VERIFICATION.<br>
            DOCUMENT LIST : <a href="https://www.ssm.com.my/Documents/register_business_company/company/senarai_semak_16.11.17.pdf" target="_blank" rel="noopener noreferrer">https://www.ssm.com.my/Documents/register_business_company/company/senarai_semak_16.11.17.pdf</a>
        </div>
    <?php else: ?>
        <p>You haven't registered any businesses yet.</p>
        <button onclick="window.location.href='registerbussness.php'" class="btn-register">REGISTER</button>
    <?php endif; ?>
</div>
<div class="copyright">
       COPYRIGHT &copy; CHONG KHIUN CHIEN
    </div>
</body>
</html>
