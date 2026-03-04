<?php
// Connect to the database
include "db.php";

// Only process if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // --- Sanitize inputs ---
    // htmlspecialchars removes dangerous characters to prevent XSS attacks
    // trim removes leading/trailing whitespace
    $title       = trim(htmlspecialchars($_POST["title"] ?? ""));
    $author      = trim(htmlspecialchars($_POST["author"] ?? ""));
    $rating      = trim($_POST["rating"] ?? "");
    $review_text = trim(htmlspecialchars($_POST["review_text"] ?? ""));

    // --- Validate inputs ---
    $errors = [];

    // Title must not be empty
    if (empty($title)) {
        $errors[] = "Book title is required.";
    }

    // Author must not be empty
    if (empty($author)) {
        $errors[] = "Author is required.";
    }

    // Rating must be a number between 1 and 5
    if (!is_numeric($rating) || (int)$rating < 1 || (int)$rating > 5) {
        $errors[] = "Rating must be a number between 1 and 5.";
    }

    // Review text must not be empty
    if (empty($review_text)) {
        $errors[] = "Review text is required.";
    }

    // --- If there are errors, show them and stop ---
    if (!empty($errors)) {
        echo "<!DOCTYPE html><html lang='en'><head>
            <meta charset='UTF-8'>
            <title>Error</title>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css' rel='stylesheet'>
        </head><body><div class='container mt-5'>";
        echo "<div class='alert alert-danger'><strong>Please fix the following errors:</strong><ul>";
        foreach ($errors as $error) {
            echo "<li>" . $error . "</li>";
        }
        echo "</ul></div>";
        echo "<a href='index.php' class='btn btn-secondary'>Go Back</a>";
        echo "</div></body></html>";
        exit;
    }

    // --- Insert into database using a prepared statement ---
    // Prepared statements prevent SQL injection by separating SQL from user data
    $sql = "INSERT INTO reviews (title, author, rating, review_text, created_at)
            VALUES (:title, :author, :rating, :review_text, NOW())";

    $stmt = $pdo->prepare($sql);

    // Bind sanitized values to the named placeholders
    $stmt->execute([
        ":title"       => $title,
        ":author"      => $author,
        ":rating"      => (int)$rating,
        ":review_text" => $review_text
    ]);

    // Redirect to index with a success message
    header("Location: index.php?success=1");
    exit;

} else {
    // If someone accesses this file directly without POST, redirect them
    header("Location: index.php");
    exit;
}
?>