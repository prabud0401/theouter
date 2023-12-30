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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Perform the insertion into the 'promotions' table
    $stmt = $pdo->prepare("INSERT INTO promotions (title, description, image_url, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $image_url, $start_date, $end_date]);

    // Redirect to the admin dashboard after adding the promotion
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!-- Your HTML form for adding a promotion goes here -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Promotion</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <h1>The Outer Clove Restaurant</h1>
        <!-- Navigation Bar -->
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="add_promotion.php">Add Promotion</a></li>
                <li><a href="delete_promotion.php">Delete Promotion</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Add your form for adding promotions here -->
    <Main>
    <form action="add_promotion.php" method="post">
        <label for="title">Title:</label>
        <input type="text" name="title" required>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea>

        <br>
        <label for="image_url">Image URL:</label>
        <input type="text" name="image_url" required>

        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" required>

        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" required>

        <button type="submit">Add Promotion</button>
    </form>
    </Main>
    


    
    <!-- Footer Section -->
    <footer>
        <p>&copy; 2023 The Outer Clove Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
