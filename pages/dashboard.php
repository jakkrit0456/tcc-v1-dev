<?php
require_once __DIR__ . '/../includes/session.php';
requireLogin();

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="dashboard-wrapper">
        <div class="dashboard-card">
            <h1>Dashboard</h1>
            <p><strong>รหัสพนักงาน:</strong> <?= htmlspecialchars((string)($user['staff_no'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Username:</strong> <?= htmlspecialchars($user['staff_user'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>ชื่อ:</strong> <?= htmlspecialchars($user['staff_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Level:</strong> <?= htmlspecialchars($user['staff_level'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>

            <a class="btn-logout" href="../logout.php">ออกจากระบบ</a>
        </div>
    </div>
</body>
</html>