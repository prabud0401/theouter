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

// Handle user deletion
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $deleteStmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $deleteStmt->execute([$deleteId]);
    header("Location: manage_users.php");
    exit();
}

// Handle new user addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $newUsername = $_POST['username'];
    $newPassword = $_POST['password']; // No password_hash
    $newUsertype = $_POST['usertype'];

    $insertStmt = $pdo->prepare("INSERT INTO users (username, password, usertype) VALUES (?, ?, ?)");
    $insertStmt->execute([$newUsername, $newPassword, $newUsertype]);
}

// Retrieve users data from the database
$usersStmt = $pdo->query("SELECT * FROM users");
$users = $usersStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <h1>The Outer Clove Restaurant - Admin Dashboard</h1>
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
    <main>
        <h2>Welcome to the Admin Dashboard, <?php echo $_SESSION['username']; ?>!</h2>

        <!-- Display current users -->
        <h3>Current Users:</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Usertype</th>
                <th>Action</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['usertype']; ?></td>
                    <td><a href="manage_users.php?delete_id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <section>
        <h3>Add New User:</h3>
        <form method="post" action="manage_users.php">
            <label for="username">Username:</label>
            <input type="text" name="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="usertype">Usertype:</label>
            <select name="usertype" required>
                <option value="customer">Customer</option>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
            </select>

            <button type="submit" name="add_user">Add User</button>
        </form>
            <section>

        <!-- Add new user form -->
        
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2023 The Outer Clove Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
