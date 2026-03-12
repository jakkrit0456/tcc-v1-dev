<?php
header('Content-Type: application/json; charset=utf-8');

$new_password = $_POST['new_password'] ?? '';

echo json_encode([
    'success' => true,
    'message' => 'เปลี่ยนรหัสผ่านสำเร็จ (ระบบทดสอบ)',
    'debug_received_pass' => $new_password
], JSON_UNESCAPED_UNICODE);

exit;