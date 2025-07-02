<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Fetch user data
$stmt = $conn->prepare("SELECT username, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    echo "User not found.";
    exit();
}

// Handle update submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $password = trim($_POST['password']);

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ?, password = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $username, $email, $role, $hashedPassword, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $email, $role, $id);
    }

    $stmt->execute();
    $stmt->close();

    header("Location: adminusermanagment.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="admin.css">

</head>

<body>
    <div class="form-edit">
        <h2>Edit User</h2>
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            <label>Role:</label>
            <select name="role" required>
                <option value="client" <?= $user['role'] === 'client' ? 'selected' : '' ?>>Client</option>
                <option value="officer" <?= $user['role'] === 'officer' ? 'selected' : '' ?>>Officer</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
            <label>New Password:</label>
            <input type="password" name="password" placeholder="Leave blank to keep current password">
            <p class="note">Leave password blank if you do not want to change it.</p>
            <button type="submit">Update</button>
        </form>
        <a href="adminusermanagment.php">← Back to User Management</a>
    </div>
</body>

</html>