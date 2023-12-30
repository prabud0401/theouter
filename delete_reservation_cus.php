<?php
// Include your database connection file or establish a connection here
include('php/db_connection.php'); // Update with your actual file or code

// Check if the reservation ID is provided in the URL
if (isset($_GET['id'])) {
    $reservationId = $_GET['id'];

    // Retrieve reservation details from the database
    $stmt = $pdo->prepare("SELECT * FROM reservations WHERE id = ?");
    $stmt->execute([$reservationId]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the reservation exists
    if (!$reservation) {
        die("Reservation not found.");
    }

    // Check if the user is the owner of the reservation (additional security check)
    session_start();
    $username = $_SESSION['username'];
    $userId = $reservation['user_id'];

    if ($userId !== getUserIdByUsername($pdo, $username)) {
        die("Unauthorized access.");
    }

    // Handle reservation deletion
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Perform additional validation or checks if needed

        // Delete the reservation from the database
        $deleteStmt = $pdo->prepare("DELETE FROM reservations WHERE id = ?");
        $deleteStmt->execute([$reservationId]);

        // Redirect back to the reservations page after deletion
        header("Location: ustomer_dashboard.php");
        exit();
    }
} else {
    die("Reservation ID not provided.");
}

// Function to get user ID by username
function getUserIdByUsername($pdo, $username)
{
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ? $user['id'] : null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Reservation</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <h1>The Outer Clove Restaurant</h1>
        <!-- Navigation Bar -->
        <nav>
            <ul>
                <li><a href="customer_dashboard.php">Dashboard</a></li>
                <li><a href="customer_reservations.php">Reservations</a></li>
                <li><a href="customer_profile.php">Profile</a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Section -->
    <main>
        <h2>Delete Reservation</h2>
        <p>Are you sure you want to delete the reservation for <?php echo $reservation['table_name']; ?> on <?php echo $reservation['reservation_date']; ?>?</p>

        <form method="post">
            <button type="submit">Yes, Delete Reservation</button>
        </form>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2023 The Outer Clove Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
