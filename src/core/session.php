<?php
// includes/session.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('SESSION_TIMEOUT_SECONDS', 600); // 10 นาที

function updateLastActivity(): void
{
    $_SESSION['last_activity'] = time();
}

function isSessionExpired(): bool
{
    if (!isset($_SESSION['last_activity'])) {
        return false;
    }

    return (time() - $_SESSION['last_activity']) > SESSION_TIMEOUT_SECONDS;
}

function requireLogin(): void
{
    if (!isset($_SESSION['user'])) {
        header("Location: /pages/auth/login.php");
        exit;
    }

    if (isSessionExpired()) {
        session_unset();
        session_destroy();
        header("Location: /pages/auth/login.php?error=session_timeout");
        exit;
    }

    updateLastActivity();
}