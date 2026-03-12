<?php
require_once __DIR__ . '/../includes/session.php';

if (isset($_SESSION['user']) && !isSessionExpired()) {
    updateLastActivity();
    header("Location: ./dashboard.php");
    exit;
}

$errorText = '';
if (isset($_GET['error']) && $_GET['error'] === 'session_timeout') {
    $errorText = 'ไม่มีการใช้งานเกิน 10 นาที ระบบออกจากระบบอัตโนมัติ';
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="page-wrapper">
        <div class="login-card">
            <h1 class="title">เข้าสู่ระบบ</h1>
            <p class="subtitle">Debt Collection Management System</p>

            <form id="loginForm" class="login-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="กรอกชื่อผู้ใช้งาน"
                        autocomplete="username"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="กรอกรหัสผ่าน"
                        autocomplete="current-password"
                    >
                </div>

                <div id="alertBox" class="alert <?= $errorText !== '' ? 'show error' : '' ?>">
                    <?= htmlspecialchars($errorText, ENT_QUOTES, 'UTF-8') ?>
                </div>

                <button type="submit" id="loginBtn" class="btn-login">
                    Login
                </button>
            </form>
        </div>
    </div>

    <script src="../js/login.js"></script>
</body>
</html>