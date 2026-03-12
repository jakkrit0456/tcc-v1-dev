<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../src/core/session.php';
require_once __DIR__ . '/../../src/core/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    echo json_encode([
        'success' => false,
        'message' => 'กรุณากรอก Username และ Password'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!isset($conn)) {
    echo json_encode(['success' => false, 'message' => 'Internal Error: $conn is not defined']);
    exit;
}

$staff = findStaffByUsername($conn, $username);

if (!$staff) {
    echo json_encode([
        'success' => false,
        'message' => 'ไม่พบ User ในระบบ'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if (isUserExpired($staff['staff_expdate'] ?? null)) {
    echo json_encode([
        'success' => false,
        'message' => 'ผู้ใช้งานหมดอายุ ไม่สามารถเข้าใช้งานได้'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!verifyPassword($password, $staff['staff_pass'] ?? null)) {
    echo json_encode([
        'success' => false,
        'message' => 'ใส่รหัสไม่ถูกต้อง'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if (mustChangePassword($staff['set_staff_passchange'])) {
    echo json_encode([
        'success' => true,
        'message' => 'ต้องเปลี่ยนรหัสผ่านก่อนเข้าใช้งาน',
        'redirect' => './change-password.php'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

session_regenerate_id(true);

$_SESSION['user'] = [
    'staff_no'   => $staff['staff_no'] ?? null,
    'staff_user' => $staff['staff_user'] ?? '',
    'staff_name' => $staff['staff_name'] ?? '',
    'staff_level'=> $staff['staff_level'] ?? '',
    'staff_team' => $staff['staff_team'] ?? '',
    'staff_sup'  => $staff['staff_sup'] ?? '',
];

echo json_encode([
        'success' => true,
        'message' => 'เข้าสู่ระบบ',
        'redirect' => './dashboard/dashboard.php'
    ], JSON_UNESCAPED_UNICODE);

updateLastActivity();