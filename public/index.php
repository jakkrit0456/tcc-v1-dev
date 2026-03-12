<?php

require_once __DIR__ . '../../src/core/session.php';

if (isset($_SESSION['user_id'])) {
    header('Location: /pages/dashboard/dashboard.php');
} else {
    header('Location: /pages/auth/login.php');
}

exit;