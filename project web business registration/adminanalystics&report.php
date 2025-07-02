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

// User role count
$user_roles = [];
$role_query = "SELECT role, COUNT(*) AS count FROM users GROUP BY role";
$role_result = $conn->query($role_query);
while ($row = $role_result->fetch_assoc()) {
    $user_roles[$row['role']] = $row['count'];
}


$app_status = [];
$app_query = "SELECT status, COUNT(*) AS count FROM applications GROUP BY status";
$app_result = $conn->query($app_query);
while ($row = $app_result->fetch_assoc()) {
    $app_status[$row['status']] = $row['count'];
}

$biz_type = [];
$biz_query = "SELECT type, COUNT(*) AS count FROM businesses GROUP BY type";
$biz_result = $conn->query($biz_query);
while ($row = $biz_result->fetch_assoc()) {
    $biz_type[$row['type']] = $row['count'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Analytics & Reports</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="admin.css">

</head>

<body>
    <div class="sidebar">
        <h2>ADMIN DASHBOARD</h2>
        <a href="adminanalystics&report.php" class="active">ANALYTICS & REPORT</a>
        <a href="adminusermanagment.php">USER MANAGEMENT</a>
        <a href="adminbusiness.php">BUSINESS</a>
        <a href="adminapplication.php">APPLICATION</a>
        <a href="logout.php">LOG OUT</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>ANALYTICS & REPORT</h2>
        </div>

        <div class="summary">
            <h3>Overall Summary</h3>
            <p>Total Users: <?= array_sum($user_roles) ?></p>
            <p>Total Applications: <?= array_sum($app_status) ?></p>
            <p>Total Businesses: <?= array_sum($biz_type) ?></p>
        </div>

        <div class="charts-container">
            <div class="chart-card">
                <h4>User Roles</h4>
                <canvas id="userRoleChart"></canvas>
            </div>
            <div class="chart-card">
                <h4>Application Status</h4>
                <canvas id="appStatusChart"></canvas>
            </div>
            <div class="chart-card">
                <h4>Business Types</h4>
                <canvas id="bizTypeChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const userRoles = <?= json_encode(array_values($user_roles)) ?>;
        const userLabels = <?= json_encode(array_keys($user_roles)) ?>;

        const appStatus = <?= json_encode(array_values($app_status)) ?>;
        const appLabels = <?= json_encode(array_keys($app_status)) ?>;

        const bizTypes = <?= json_encode(array_values($biz_type)) ?>;
        const bizLabels = <?= json_encode(array_keys($biz_type)) ?>;

        function createPieChart(id, labels, data, title) {
            new Chart(document.getElementById(id), {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: title,
                        data: data,
                        backgroundColor: [
                            '#6a0dad', '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' },
                        title: { display: false }
                    }
                }
            });
        }

        createPieChart("userRoleChart", userLabels, userRoles, "User Roles");
        createPieChart("appStatusChart", appLabels, appStatus, "Application Status");
        createPieChart("bizTypeChart", bizLabels, bizTypes, "Business Types");
    </script>

    <div class="copyright">
        COPYRIGHT &copy; CHONG KHIUN CHIEN
    </div>
</body>

</html>