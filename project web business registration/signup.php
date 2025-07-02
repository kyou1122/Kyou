<?php
$conn = new mysqli("localhost", "root", "", "project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = "client";

    $checkSql = "SELECT id FROM users WHERE email = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $updateSql = "UPDATE users SET role = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ss", $role, $email);
        if ($updateStmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Error updating role: " . $updateStmt->error;
        }
    } else {
        $insertSql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("ssss", $username, $email, $password, $role);
        if ($insertStmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Error: " . $insertStmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up - Business Registration</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html, body { height: 100%; width: 100%; font-family: 'Arial', sans-serif; background: #0b061f; overflow: hidden; }
    .container { position: relative; width: 100%; height: 100%; }
    .left-panel, .right-panel { position: absolute; top: 0; height: 100%; padding: 40px; color: white; overflow: hidden; transition: none; }
    .left-panel { background: linear-gradient(315deg, #ffffff 0%, #678dc6 74%); left: 0; width: 0%; z-index: 1; display: none; justify-content: center; align-items: center; flex-direction: column; }
    .right-panel { background-image: url("photo-1560179707-f14e90ef3623.jpg"); background-size: cover; background-position: center; right: 0; width: 100%; z-index: 2; display: flex; justify-content: center; align-items: center; flex-direction: column; }
    @keyframes openRight { 0% { width: 100%; } 100% { width: 50%; } }
    @keyframes openLeft { 0% { width: 0%; } 100% { width: 50%; } }
    .container.open .right-panel { animation: openRight 1.2s ease forwards; }
    .container.open .left-panel { display: flex; animation: openLeft 1.2s ease forwards; }
    @keyframes textFadeInSlideRight { 0% { opacity: 0; transform: translateX(-50px); } 100% { opacity: 1; transform: translateX(0); } }
    .left-panel-content { opacity: 0; transform: translateX(-50px); text-align: center; width: 100%; max-width: 400px; }
    .container.open .left-panel .left-panel-content { animation: textFadeInSlideRight 1s ease forwards; animation-delay: 0.5s; }
    .right-panel h2 { font-size: 36px; margin-bottom: 10px; }
    .right-panel p { font-size: 16px; opacity: 0.85; }
    .left-panel h2 { font-size: 32px; margin-bottom: 30px; }
    .form-group { width: 100%; max-width: 300px; margin: 0 auto 20px; text-align: left; }
    .form-group label { display: block; margin-bottom: 5px; font-size: 14px; font-weight: bold; letter-spacing: 1px; }
    .form-group input { width: 100%; padding: 10px 15px; border: none; border-bottom: 2px solid #ccc; background: transparent; color: white; font-size: 16px; outline: none; }
    .form-group input:focus { border-bottom-color: #007bff; }
    .btn { width: 100%; max-width: 300px; padding: 12px; border: none; border-radius: 20px; background: linear-gradient(to right, #007bff,  #00c6ff); color: white; font-size: 16px; cursor: pointer; transition: background 0.3s ease; }
    .btn:hover { background: linear-gradient(to right, #00c6ff, #007bff); }
    .login-link { margin-top: 15px; color: #ccc; font-size: 14px; }
    .login-link a { color: #fff; text-decoration: none; margin-left: 5px; cursor: pointer; }
    .login-link a:hover { text-decoration: underline; }
    .error { color: #ffb3b3; margin-bottom: 15px; font-size: 14px; }
  </style>
</head>
<body>

<div class="container" id="container">
  <div class="right-panel">
    <div>
      <h2>WELCOME</h2>
      <p>BUSINESS REGISTRATION</p>
      <button class="btn" id="homeBtn" style="margin-top:20px;">HOME</button>
    </div>
  </div>

  <div class="left-panel">
    <div class="left-panel-content">
      <h2>SIGN UP</h2>

      <?php if (!empty($error)): ?>
        <div class="error"><?php echo $error; ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="form-group">
          <label>USERNAME</label>
          <input type="text" name="username" placeholder="USERNAME" required />
        </div>
        <div class="form-group">
          <label>EMAIL</label>
          <input type="email" name="email" placeholder="EMAIL" required />
        </div>
        <div class="form-group">
          <label>PASSWORD</label>
          <input type="password" name="password" placeholder="PASSWORD" required />
        </div>
        <button type="submit" class="btn">CREATE ACCOUNT</button>
        <div class="login-link">
          ALREADY HAVE AN ACCOUNT? <a href="login.php">LOG IN</a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const container = document.getElementById('container');
  const homeBtn = document.getElementById('homeBtn');
  window.onload = () => container.classList.add('open');
  homeBtn.addEventListener('click', () => { window.location.href = "home.html"; });
</script>

</body>
</html>
