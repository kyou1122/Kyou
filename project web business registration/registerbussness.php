<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "project");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user']['id'];
    $business_name = $_POST['business_name'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $ic_number = $_POST['ic_number'];
    $address = $_POST['address'];
    $type = $_POST['type'];

    $sql = "INSERT INTO businesses (user_id, business_name, name, email, ic_number, address, type) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $user_id, $business_name, $name, $email, $ic_number, $address, $type);
    if ($stmt->execute()) {
        header("Location: userbussiness.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Business</title>
    <link rel="stylesheet" href="user.css">
    
</head>
<body>

<header class="header">
    <div class="welcome">WELCOME, <span class="username"><?php echo htmlspecialchars($_SESSION['user']['username']); ?></span></div>
    <a href="login.php" class="logout">LOG OUT</a>
</header>

<div class="button-container">
    <button onclick="window.location.href='userbussiness.php'" class="btn-business">BUSINESS</button>
</div>



<div class="form-container">
    <h1>REGISTER BUSINESS</h1>
    <form method="POST">
        <label for="business_name">BUSINESS NAME</label>
<input type="text" name="business_name" id="business_name" placeholder="BUSINESS NAME" required>

<label for="name">NAME</label>
<input type="text" name="name" id="name" placeholder="NAME" required>

<label for="email">EMAIL</label>
<input type="email" name="email" id="email" placeholder="EMAIL" required>

<label for="ic_number">IC NUMBER</label>
<input type="text" name="ic_number" id="ic_number" placeholder="EXP : 0123456789012" required>

<label for="address">ADDRESS</label>
<input type="text" name="address" id="address" placeholder="ADDRESS" required>

<label for="type">TYPE</label>
<input type="text" name="type" id="type" placeholder="TYPE" required>

<button type="submit" class="btn-register">SUBMIT</button>

    </form>
</div>
<div class="copyright">
       COPYRIGHT &copy; CHONG KHIUN CHIEN
    </div>
</body>
</html>
