<?php

define('BASE_URL', '/sia-multimedia');

$host   = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'sia_multimedia';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    die('Database connection failed. Is MySQL running in XAMPP, and did you import database.sql? <br>Details: ' . $e->getMessage());
}

function e($text) {
    return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8');
}
