<?php
session_start();
$conn = new mysqli("localhost", "root", "", "project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_or_username = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username=? OR email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email_or_username, $email_or_username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    
    if ($user) {
    $storedPassword = rtrim($user['password']); 

    if (password_verify($password, $storedPassword)) {
        switch ($user['role']) {
            case 'admin':
                $_SESSION['admin'] = $user;
                header("Location: adminanalystics&report.php"); 
                break;

            case 'officer':
                $_SESSION['officer'] = $user;
                header("Location: officerdashboard.php");
                break;

            default: // 'client' or anything else
                $_SESSION['user'] = $user;
                header("Location: user.php");
                break;
        }
        exit;
    } else {
        $error = "INCORRECT USERNAME/EMAIL OR PASSWORD.";
    }
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Business Registration</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html, body { height: 100%; width: 100%; font-family: 'Arial', sans-serif; background: #0b061f; overflow: hidden; }
    .container { position: relative; width: 100%; height: 100%; }
    .left-panel, .right-panel {
      position: absolute; top: 0; height: 100%; padding: 40px; color: white; overflow: hidden;
    }
    .left-panel {
      background-image: url("photo-1560179707-f14e90ef3623.jpg");
      background-size: cover; background-position: center;
      display: flex; justify-content: center; align-items: center; flex-direction: column;
      width: 100%; z-index: 2;
    }
    .right-panel {
      background: linear-gradient(135deg, #678dc6 0%, #ffffff 74%);
      right: 0; width: 0%; display: none; z-index: 1;
      justify-content: center; align-items: center; flex-direction: column;
    }
    @keyframes openLeft { 0% {width:100%;} 100% {width:50%;} }
    @keyframes openRight { 0% {width:0%;} 100% {width:50%;} }
    .container.open .left-panel { animation: openLeft 1.2s ease forwards; }
    .container.open .right-panel { display:flex; animation: openRight 1.2s ease forwards; }
    .right-panel-content { opacity: 0; transform: translateX(50px); width: 100%; max-width: 400px; text-align: center; }
    .container.open .right-panel .right-panel-content {
      animation: textFadeInSlide 1s ease forwards; animation-delay: 0.5s;
    }
    @keyframes textFadeInSlide { 0%{opacity:0;transform:translateX(50px);} 100%{opacity:1;transform:translateX(0);} }
    .left-panel h2 { font-size: 36px; margin-bottom: 10px; }
    .left-panel p { font-size: 16px; opacity: 0.85; }
    .right-panel h2 { font-size: 32px; margin-bottom: 30px; }
    .form-group { max-width:300px; margin:0 auto 20px; text-align:left; }
    .form-group label { display:block; margin-bottom:5px; font-size:14px; font-weight:bold; }
    .form-group input {
      width:100%; padding:10px 15px; border:none; border-bottom:2px solid #ccc;
      background:transparent; color:white; font-size:16px; outline:none;
    }
    .form-group input:focus { border-bottom-color: #007bff; }
    .btn {
      width:100%; max-width:300px; padding:12px; border:none; border-radius:20px;
      background:linear-gradient(to right, #00c6ff, #007bff); color:white; font-size:16px; cursor:pointer;
      transition: 0.3s ease;
    }
    .btn:hover { background:linear-gradient(to right, #007bff, #00c6ff); }
    .login-link, .forgot-password {
      margin-top: 15px; color:#ccc; font-size:14px; text-align: center;
    }
    .login-link a, .forgot-password a { color:#fff; text-decoration:none; }
    .login-link a:hover, .forgot-password a:hover { text-decoration: underline; }
    .error { color: #ffb3b3; margin-bottom: 15px; font-size: 14px; }
  </style>
</head>
<body>

<div class="container" id="container">
  <div class="left-panel">
    <div>
      <h2>WELCOME</h2>
      <p>BUSINESS REGISTRATION</p>
      <button class="btn" id="homeBtn">HOME</button>
    </div>
  </div>

  <div class="right-panel">
    <div class="right-panel-content">
      <h2>LOGIN</h2>

      <?php if (!empty($error)): ?>
        <div class="error"><?php echo $error; ?></div>
      <?php endif; ?>

      <form id="loginForm" method="POST">
        <div class="form-group">
          <label>USERNAME / EMAIL</label>
          <input type="text" name="email" required />
        </div>
        <div class="form-group">
          <label>PASSWORD</label>
          <input type="password" name="password" required />
        </div>
        <button type="submit" class="btn">LOGIN</button>
        <div class="login-link">
          Don't have account? <a href="signup.php">Sign up</a>
        </div>
        <div class="forgot-password">
          <a href="forgot.php">Forgot Password?</a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
const container = document.getElementById('container');
window.onload = () => container.classList.add('open');
document.getElementById('homeBtn').onclick = () => window.location.href = "home.html";
</script>

</body>
</html>
