<?php
// Connect to the database
include "db.php";

// Get the review ID from the URL and cast to int to prevent SQL injection
$id = (int)($_GET["id"] ?? 0);

// If no valid ID was provided, redirect to admin
if ($id <= 0) {
    header("Location: admin.php");
    exit;
}

// Use a prepared statement to safely delete the review by ID
$stmt = $pdo->prepare("DELETE FROM reviews WHERE id = :id");
$stmt->execute([":id" => $id]);

// Redirect to admin with a success flag in the URL
header("Location: admin.php?deleted=1");
exit;
?>