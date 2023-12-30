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

// Retrieve promotions data from the database
$promotionsStmt = $pdo->query("SELECT * FROM promotions");
$promotions = $promotionsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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

    <!-- Main Section -->
    <h2>Welcome to the Admin Dashboard, <?php echo $_SESSION['username']; ?>!</h2>
    <main>
        

        <!-- Display promotions -->
        <h3>Current Promotions:</h3>
        <?php if (empty($promotions)): ?>
            <p>No promotions found.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($promotions as $promotion): ?>
                    <li>
                        <strong><?php echo $promotion['title']; ?></strong>
                        <p><?php echo $promotion['description']; ?></p>
                        <p>Start Date: <?php echo $promotion['start_date']; ?> - End Date: <?php echo $promotion['end_date']; ?></p>
                        <!-- Edit and Delete options -->
                        <a href="edit_promotion.php?id=<?php echo $promotion['id']; ?>">Edit</a> |
                        <a href="delete_promotion.php?id=<?php echo $promotion['id']; ?>" onclick="return confirm('Are you sure you want to delete this promotion?')">Delete</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2023 The Outer Clove Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
