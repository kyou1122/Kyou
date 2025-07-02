<?php
session_start();


$host = "localhost";
$username = "b032410160";
$password = "041224130447";
$database = "student_b032410160";
$conn = new mysqli("localhost", "b032410160", "041224130447", "student_b032410160");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);


    if (empty($email)) {
        $error = "Please enter your email address";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
    
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
        
            $success = "Password reset instructions have been sent to your email";

        } else {
            $error = "Email not found in our system";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forgot Password - Business Registration</title>
  <style> * { margin: 0; padding: 0; box-sizing: border-box; }
    html, body {
      height: 100%;
      width: 100%;
      font-family: 'Arial', sans-serif;
      background: #0b061f;
      overflow: hidden;
    }
    .container { position: relative; width: 100%; height: 100%; }
    .left-panel, .right-panel {
      position: absolute; top: 0; height: 100%;
      padding: 40px; color: white; overflow: hidden;
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
    }
    .btn:hover { background:linear-gradient(to right, #007bff, #00c6ff); }
    .login-link { margin-top:15px; color:#ccc; font-size:14px; }
    .login-link a { color:#fff; text-decoration:none; margin-left:5px; }
    .forgot-password { text-align: right; margin-bottom: 20px; }
    .forgot-password a { color: #fff; font-size: 13px; text-decoration: none; } </style>
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
      <h2>RESET PASSWORD</h2>
      <form id="forgotForm">
        <div class="form-group"><label>EMAIL</label><input type="email" required /></div>
        <button type="submit" class="btn">SEND LINK</button>
        <div class="login-link"><a href="login.php">Back to Login</a></div>
      </form>
    </div>
  </div>
</div>
<script>
const container = document.getElementById('container');
window.onload = () => container.classList.add('open');
document.getElementById('homeBtn').onclick = () => window.location.href = "home.html";
document.getElementById('forgotForm').onsubmit = e => { e.preventDefault(); alert('Password reset link sent.'); };
</script>
</body>
</html>
