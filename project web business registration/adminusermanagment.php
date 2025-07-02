<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$username = "b032410160";
$password = "041224130447";
$database = "student_b032410160";
$conn = new mysqli("localhost", "b032410160", "041224130447", "student_b032410160");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    if ($username && $email && $role && $password) {
        $stmt = $conn->prepare("INSERT INTO users (username, email, role, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $role, $password);
        $stmt->execute();
        $stmt->close();
        header("Location: adminusermanagment.php"); 
        exit();
    }
}

$users = [];
$query = "SELECT id, username, email, role FROM users";
$result = $conn->query($query);
if ($result) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        .notification {
            margin: 15px auto;
            padding: 10px 20px;
            width: 90%;
            max-width: 600px;
            text-align: center;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
        }

        .notification.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .notification.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>ADMIN DASHBOARD</h2>
    <a href="adminanalystics&report.php">ANALYTICS & REPORT</a>
    <a href="adminusermanagment.php" class="active">USER MANAGEMENT</a>
    <a href="adminbusiness.php">BUSINESS</a>
    <a href="adminapplication.php">APPLICATION</a>
    <a href="logout.php">LOG OUT</a>
</div>

<div class="main-content">
    <div class="header">
        <h2>WELCOME ADMIN</h2>
        <div><strong>Admin</strong></div>
    </div>

    <div class="container">
        <h3>USER MANAGEMENT</h3>

        <form class="form-add" id="addUserForm" method="POST" style="display: none;">
            <h4>ADD NEW USER</h4>
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="">SELECT ROLE</option>
                <option value="client">CLIENT</option>
                <option value="officer">OFFICER</option>
                <option value="admin">ADMIN</option>
            </select>
            <button type="submit" name="add_user" class="btn">ADD</button>
        </form>

        <div class="filter-tabs">
            <div class="filters">
                <button onclick="filterUsers('client')">CLIENTS</button>
                <button onclick="filterUsers('officer')">OFFICER</button>
                <button onclick="filterUsers('admin')">ADMIN</button>
                <button onclick="filterUsers('all')">ALL</button>
            </div>
            <div class="add-user-button">
                <button onclick="toggleAddUserForm()">ADD USER</button>
            </div>
        </div>

        <table id="usersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>USERNAME</th>
                    <th>EMAIL</th>
                    <th>ROLE</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr data-type="<?= htmlspecialchars($user['role']) ?>">
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td class="actions">
                            <a href="adminedituser.php?id=<?= $user['id'] ?>">Edit</a>
                            <a href="admindeleteuser.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function filterUsers(type) {
        const rows = document.querySelectorAll('#usersTable tbody tr');
        rows.forEach(row => {
            if (type === 'all' || row.dataset.type === type) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function toggleAddUserForm() {
        const form = document.getElementById('addUserForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
</script>

<div class="copyright">
    COPYRIGHT &copy; CHONG KHIUN CHIEN
</div>

</body>
</html>
