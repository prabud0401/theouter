<?php
// Include your database connection file or establish a connection here
include('php/db_connection.php'); // Update with your actual file or code

// Check if the user is logged in as an admin
session_start();
if (!isset($_SESSION['username']) || $_SESSION['usertype'] !== 'admin') {
    // Redirect to the login page if not logged in as an admin
    header("Location: login.php");
    exit();
}

// Handle form submission for editing promotion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_promotion'])) {
    $promotionId = $_POST['promotion_id'];
    $newTitle = $_POST['new_title'];
    $newDescription = $_POST['new_description'];
    $newStartDate = $_POST['new_start_date'];
    $newEndDate = $_POST['new_end_date'];

    // Update the promotion details in the database
    $updateStmt = $pdo->prepare("UPDATE promotions SET title = ?, description = ?, start_date = ?, end_date = ? WHERE id = ?");
    $updateStmt->execute([$newTitle, $newDescription, $newStartDate, $newEndDate, $promotionId]);

    // Redirect to the admin dashboard after editing a promotion
    header("Location: admin_dashboard.php");
    exit();
}

// Fetch the promotion details for editing
if (isset($_GET['id'])) {
    $promotionId = $_GET['id'];
    $selectStmt = $pdo->prepare("SELECT * FROM promotions WHERE id = ?");
    $selectStmt->execute([$promotionId]);
    $promotionData = $selectStmt->fetch();
} else {
    // Redirect to the admin dashboard if no promotion ID is provided
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Promotion</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <h1>The Outer Clove Restaurant - Edit Promotion</h1>
        <!-- Navigation Bar -->
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="add_promotion.php">Add Promotion</a></li>
                <li><a href="delete_promotion.php">Delete Promotion</a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Section -->
    <main>
        <h2>Edit Promotion</h2>

        <!-- Display the current promotion details and provide a form for editing -->
        <form action="edit_promotion.php" method="post">
            <input type="hidden" name="promotion_id" value="<?php echo $promotionId; ?>">
            
            <label for="new_title">Title:</label>
            <input type="text" id="new_title" name="new_title" value="<?php echo $promotionData['title']; ?>" required>

            <label for="new_description">Description:</label>
            <textarea id="new_description" name="new_description" rows="4" required><?php echo $promotionData['description']; ?></textarea>

            <label for="new_start_date">Start Date:</label>
            <input type="date" id="new_start_date" name="new_start_date" value="<?php echo $promotionData['start_date']; ?>" required>

            <label for="new_end_date">End Date:</label>
            <input type="date" id="new_end_date" name="new_end_date" value="<?php echo $promotionData['end_date']; ?>" required>

            <button type="submit" name="edit_promotion">Save Changes</button>
        </form>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2023 The Outer Clove Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
