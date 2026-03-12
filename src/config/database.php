<?php
    $serverName = "192.168.1.50"; 
    $connectionOptions = [
        "Database" => "datadebt",
        "Uid" => "tcc",
        "PWD" => "123456", 
        "CharacterSet" => "UTF-8"
    ];

    try {
        $conn = new PDO("sqlsrv:server=$serverName;Database=datadebt;TrustServerCertificate=1", $connectionOptions['Uid'], $connectionOptions['PWD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        header('Content-Type: application/json; charset=utf-8');
        die(json_encode(["success" => false, "message" => "Database Connect Error: " . $e->getMessage()]));
    }
