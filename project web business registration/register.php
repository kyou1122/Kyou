<?php

$conn = new mysqli("localhost", "root", "", "project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = "client";

    // Check if user already exists
    $checkSql = "SELECT id FROM users WHERE email = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // User exists, update role to 'client'
        $updateSql = "UPDATE users SET role = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ss", $role, $email);
        if ($updateStmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            echo "Error updating role: " . $updateStmt->error;
        }
    } else {
        // User doesn't exist, insert new user
        $insertSql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("ssss", $username, $email, $password, $role);
        if ($insertStmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            echo "Error: " . $insertStmt->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <h1>REGISTER</h1>
    <form method="post" action="">
        <input type="text" name="username" placeholder="USERNAME" required><br><br>
        <input type="email" name="email" placeholder="EMAIL" required><br><br>
        <input type="password" name="password" placeholder="PASSWORD" required><br><br>
        <button type="submit" class="btn-register" >REGISTER</button><br><br>   
        <a href="login.php">Back to Login</a>
    </form>
    </div>

     <div class="copyright">
       COPYRIGHT &copy; CHONG KHIUN CHIEN
    </div>
</body>
</html>
