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

// Check if the promotion ID is provided in the URL
if (isset($_GET['id'])) {
    // Retrieve the promotion ID from the URL
    $promotionId = $_GET['id'];

    // Perform the deletion from the 'promotions' table
    $stmt = $pdo->prepare("DELETE FROM promotions WHERE id = ?");
    $stmt->execute([$promotionId]);

    // Redirect to the admin dashboard after deleting the promotion
    header("Location: admin_dashboard.php");
    exit();
} else {
    // If promotion ID is not provided, redirect to the admin dashboard
    header("Location: admin_dashboard.php");
    exit();
}
?>
