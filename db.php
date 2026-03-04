<?php
// Database connection settings
$host = '127.0.0.1';
$db   = 'database';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// The DSN specifies the driver (mysql), host, database name, and charset
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
     // Create PDO
     $pdo = new PDO($dsn, $user, $pass);
     
     // Set error mode to Exception for better debugging
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
     echo "Connected successfully";
} catch (PDOException $e) {
     // Handle connection errors
     echo "Connection failed: " . $e->getMessage();
}
?>
