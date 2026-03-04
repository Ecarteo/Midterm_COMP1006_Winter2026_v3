<?php
// Connect to the database
include "db.php";

// Retrieve all reviews from the database, ordered by most recent first
$stmt = $pdo->query("SELECT * FROM reviews ORDER BY created_at DESC");
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Review ADMIN</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">ADMIN: Book Reviews</h1>

    <?php if (isset($_GET["deleted"])): ?>
        <!-- Show confirmation message after a successful delete -->
        <div class="alert alert-success">Review deleted successfully.</div>
    <?php endif; ?>

    <?php if (isset($_GET["updated"])): ?>
        <!-- Show confirmation message after a successful update -->
        <div class="alert alert-success">Review updated successfully.</div>
    <?php endif; ?>

    <?php if (empty($reviews)): ?>
        <!-- If no reviews exist yet, show a friendly message -->
        <p class="text-muted">No reviews found.</p>
    <?php else: ?>
        <!-- Dynamically generate a table row for each review -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $review): ?>
                <tr>
                    <td><?= $review["id"] ?></td>
                    <td><?= htmlspecialchars($review["title"]) ?></td>
                    <td><?= htmlspecialchars($review["author"]) ?></td>
                    <td><?= $review["rating"] ?>/5</td>
                    <td><?= htmlspecialchars($review["review_text"]) ?></td>
                    <td><?= $review["created_at"] ?></td>
                    <td>
                        <!-- Edit button passes the review ID to edit.php -->
                        <a href="edit.php?id=<?= $review['id'] ?>" class="btn btn-warning btn-sm">Edit</a>

                        <!-- Delete button passes the review ID to delete.php -->
                        <a href="delete.php?id=<?= $review['id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this review?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="index.php" class="btn btn-primary mb-3">Go to Main Page</a>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>