<?php
// logout.php
require_once __DIR__ . '../../src/core/session.php';
$_SESSION = array();

if (session_id() != "" || isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 2592000, '/');
}
session_destroy();

header('Location: /pages/login.php');

exit;
