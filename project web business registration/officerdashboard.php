<?php
session_start();
$conn = new mysqli("localhost", "root", "", "project");

if (!isset($_SESSION['officer'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['officer']['username'] ?? 'Officer';
$officer_id = $_SESSION['officer']['id'] ?? null;

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $business_id = intval($_POST['business_id']);
    $action = $_POST['action'];

    if (in_array($action, ['approve', 'reject']) && $officer_id) {
        $status = ($action === 'approve') ? 'approved' : 'rejected';

        $stmt = $conn->prepare("INSERT INTO applications (business_id, officer_id, status) 
                               VALUES (?, ?, ?)
                               ON DUPLICATE KEY UPDATE 
                                   officer_id = VALUES(officer_id), 
                                   status = VALUES(status)");
        $stmt->bind_param("iis", $business_id, $officer_id, $status);

        if ($stmt->execute()) {
            header("Location: officerdashboard.php?success=1");
            exit;
        } else {
            if ($stmt->errno == 1062) {
                header("Location: officerdashboard.php?error=duplicate");
            } else {
                header("Location: officerdashboard.php?error=database");
            }
            exit;
        }
    }
}

$sql = "SELECT b.id, b.business_name, b.name, b.email, b.ic_number, b.address, b.type
        FROM businesses b
        LEFT JOIN applications a ON b.id = a.business_id
        WHERE a.business_id IS NULL";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Officer Dashboard</title>
    <link rel="stylesheet" href="user.css">
    <style>
        .top-center {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            font-weight: bold;
            font-size: 14px;
            z-index: 1000;
            background-color: #fff;
            padding: 5px 10px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="copyright">
    COPYRIGHT &copy; CHONG KHIUN CHIEN
</div>

<header class="header">
    <div class="welcome">WELCOME, <span class="username"><?= htmlspecialchars($username) ?></span></div>
    <a href="logout.php" class="logout">LOG OUT</a>
</header>

<div class="button-container">
    <button class="btn-status active">APPLICATION</button>
    <button onclick="window.location.href='verification.php'" class="btn-status">VERIFICATION</button>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="notification success">
        Application processed successfully!
    </div>
<?php elseif (isset($_GET['error'])): ?>
    <div class="notification error">
        <?php
        switch ($_GET['error']) {
            case 'duplicate':
                echo "Error: This application was already processed by another officer";
                break;
            case 'database':
                echo "Database error occurred. Please try again";
                break;
            default:
                echo "An error occurred";
        }
        ?>
    </div>
<?php endif; ?>

<?php if ($result && $result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="content">
            <p><strong>BUSINESS:</strong> <?= htmlspecialchars($row['business_name']) ?></p>
            <p><strong>OWNER NAME:</strong> <?= htmlspecialchars($row['name']) ?></p>
            <p><strong>EMAIL:</strong> <?= htmlspecialchars($row['email']) ?></p>
            <p><strong>IC NUMBER:</strong> <?= htmlspecialchars($row['ic_number']) ?></p>
            <p><strong>ADDRESS:</strong> <?= htmlspecialchars($row['address']) ?></p>
            <p><strong>TYPE:</strong> <?= htmlspecialchars($row['type']) ?></p>
            <form method="post" action="officerdashboard.php" style="display: inline;">
                <input type="hidden" name="business_id" value="<?= (int)$row['id'] ?>">
                <button type="submit" name="action" value="approve" class="btn-status">APPROVE</button>
                <button type="submit" name="action" value="reject" class="btn-status" style="background-color: red;">REJECT</button>
            </form>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <div class="content">
        <p>No pending applications found.</p>
    </div>
<?php endif; ?>

</body>
</html>
