<?php
// Database connection settings
$host    = '127.0.0.1';
$db      = 'book_manager';
$user    = 'root';
$pass    = '';
$charset = 'utf8mb4';

// The DSN specifies the driver (mysql), host, database name, and charset
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    // Create PDO instance with DSN and credentials
    $pdo = new PDO($dsn, $user, $pass);

    // Set error mode to Exception so errors throw instead of silently failing
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Stop execution and display a generic error (avoid leaking DB details in production)
    die("Connection failed: " . $e->getMessage());
}
?>