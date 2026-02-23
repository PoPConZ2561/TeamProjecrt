<?php
declare(strict_types=1);
function getConnection(): mysqli
{
    $hostname = 'localhost';
    $dbName = 'event_db';
    $username = 'admin';
    $password = '1234';
    $conn = new mysqli($hostname, $username, $password, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}