<?php
// Connect to the database
include "db.php";

// Get the review ID from the URL and cast to int to prevent injection
$id = (int)($_GET["id"] ?? 0);

// If no valid ID was provided, redirect to admin
if ($id <= 0) {
    header("Location: admin.php");
    exit;
}

// --- Handle form submission (UPDATE) ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize inputs to prevent XSS
    $title       = trim(htmlspecialchars($_POST["title"] ?? ""));
    $author      = trim(htmlspecialchars($_POST["author"] ?? ""));
    $rating      = trim($_POST["rating"] ?? "");
    $review_text = trim(htmlspecialchars($_POST["review_text"] ?? ""));

    // Validate inputs
    $errors = [];

    if (empty($title)) {
        $errors[] = "Book title is required.";
    }

    if (empty($author)) {
        $errors[] = "Author is required.";
    }

    if (!is_numeric($rating) || (int)$rating < 1 || (int)$rating > 5) {
        $errors[] = "Rating must be a number between 1 and 5.";
    }

    if (empty($review_text)) {
        $errors[] = "Review text is required.";
    }

    // If validation passes, update the record in the database
    if (empty($errors)) {
        // Use a prepared statement to safely update the review
        $sql = "UPDATE reviews SET title = :title, author = :author, rating = :rating, review_text = :review_text WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":title"       => $title,
            ":author"      => $author,
            ":rating"      => (int)$rating,
            ":review_text" => $review_text,
            ":id"          => $id
        ]);

        // Redirect to admin with success message
        header("Location: admin.php?updated=1");
        exit;
    }
}

// --- Load existing review data to pre-fill the form ---
// Use a prepared statement to safely fetch the record by ID
$stmt = $pdo->prepare("SELECT * FROM reviews WHERE id = :id");
$stmt->execute([":id" => $id]);
$review = $stmt->fetch(PDO::FETCH_ASSOC);

// If no review found with that ID, redirect to admin
if (!$review) {
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Review</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Edit Review</h1>

    <?php if (!empty($errors)): ?>
        <!-- Display validation errors if any -->
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Form posts back to this same page with the review ID in the URL -->
    <form action="edit.php?id=<?= $id ?>" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Book Title:</label>
            <!-- Pre-fill the field with the existing value from the database -->
            <input type="text" class="form-control" id="title" name="title"
                   value="<?= htmlspecialchars($review["title"]) ?>" required>
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Author:</label>
            <input type="text" class="form-control" id="author" name="author"
                   value="<?= htmlspecialchars($review["author"]) ?>" required>
        </div>
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1 to 5):</label>
            <input type="number" class="form-control" id="rating" name="rating"
                   min="1" max="5" value="<?= $review["rating"] ?>" required>
        </div>
        <div class="mb-3">
            <label for="review_text" class="form-label">Review:</label>
            <textarea class="form-control" id="review_text" name="review_text" rows="6"><?= htmlspecialchars($review["review_text"]) ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="admin.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>