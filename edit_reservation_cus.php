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

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate and update reservation date
        $newReservationDate = $_POST['reservation_date'];

        // Perform validation (you can add more validation logic as needed)

        // Update reservation date in the database
        $updateStmt = $pdo->prepare("UPDATE reservations SET reservation_date = ? WHERE id = ?");
        $updateStmt->execute([$newReservationDate, $reservationId]);

        // Redirect back to the reservations page after editing
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
    <title>Edit Reservation</title>
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
        <h2>Edit Reservation</h2>
        <form method="post">
            <label for="reservation_date">New Reservation Date:</label>
            <input type="date" id="reservation_date" name="reservation_date" value="<?php echo $reservation['reservation_date']; ?>" required>

            <button type="submit">Save Changes</button>
        </form>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2023 The Outer Clove Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
