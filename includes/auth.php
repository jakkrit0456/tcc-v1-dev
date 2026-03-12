<?php
// includes/auth.php

require_once __DIR__ . '/../config/database.php';

function findStaffByUsername($conn, string $username): ?array
{
    $sql = "SELECT * FROM dbo.staff WHERE staff_user = :user";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':user' => $username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}

function verifyPassword(string $inputPassword, ?string $dbPassword): bool
{
    if (empty($dbPassword)) return false;
    $dbPassword = trim($dbPassword);

    if (password_verify($inputPassword, $dbPassword)) {
        return true;
    }

    if (md5($inputPassword) === $dbPassword) {
        return true;
    }
    $utf16_pass = iconv("UTF-8", "UTF-16LE", $inputPassword);
    if (md5($utf16_pass) === $dbPassword) {
        return true;
    }

    return ($inputPassword === $dbPassword);
}

function isUserExpired($expDate): bool
{
    if (empty($expDate)) {
        return false;
    }

    if ($expDate instanceof DateTime) {
        $today = new DateTime('today');
        return $expDate < $today;
    }

    try {
        $date = new DateTime((string)$expDate);
        $today = new DateTime('today');
        return $date < $today;
    } catch (Exception $e) {
        return false;
    }
}

function mustChangePassword($setPassChange) {
    if ($setPassChange == 0 || $setPassChange === null) {
        return true; 
    }

    return false;
}

// function mustChangePassword(array $staff): bool
// {
//     return isset($staff['set_staff_passchange']) && (int)$staff['set_staff_passchange'] === 1;
// }