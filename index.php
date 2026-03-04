<?php
// Connect to the database
include "db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Review Submission</title>
    <!-- Bootstrap CSS: https://getbootstrap.com/docs/5.3/getting-started/download/ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

    <!-- Bootstrap elements were directly taken and used the same way as in my phase one course project. -->
    <div class="container mt-5">
        <h1 class="mb-4">Submit a Book Review</h1>

        <?php if (isset($_GET["success"])): ?>
            <!-- Show a success message after a review is submitted -->
            <div class="alert alert-success">Your review was submitted successfully!</div>
        <?php endif; ?>

        <form action="process.php" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Book Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Author:</label>
                <input type="text" class="form-control" id="author" name="author" required>
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Rating (1 to 5):</label>
                <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
            </div>
            <div class="mb-3">
                <label for="review_text" class="form-label">Review:</label>
                <textarea id="review_text" class="form-control" name="review_text" rows="6" cols="40"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>

        <p class="mt-3">
            <a href="admin.php" class="btn btn-secondary">Go to Admin Page</a>
        </p>

    </div>

    <!-- Bootstrap JS: https://getbootstrap.com/docs/5.3/getting-started/download/ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>