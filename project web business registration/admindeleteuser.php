<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
$servername = "localhost";
$username = "b032410160";
$password = "041224130447";
$dbname = "student_b032410160";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_GET['id'])) {
    header("Location: adminusermanagment.php?error=missing_id");
    exit;
}

$user_id = intval($_GET['id']);


$business_ids = [];
$res = $conn->query("SELECT id FROM businesses WHERE user_id = $user_id");
while ($row = $res->fetch_assoc()) {
    $business_ids[] = $row['id'];
}

if (!empty($business_ids)) {
    $ids_str = implode(',', array_map('intval', $business_ids));
    $conn->query("DELETE FROM applications WHERE business_id IN ($ids_str)");
}


$conn->query("DELETE FROM businesses WHERE user_id = $user_id");


$conn->query("DELETE FROM users WHERE id = $user_id");

header("Location: adminusermanagment.php?success=deleted");
exit;
?>
