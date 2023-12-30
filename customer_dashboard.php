<?php
// Assume you have a session started on login
session_start();

// Check if the user is logged in as a customer
if (!isset($_SESSION['username']) || $_SESSION['usertype'] !== 'customer') {
    // Redirect to the login page if not logged in as a customer
    header("Location: login.php");
    exit();
}

// Include your database connection file or establish a connection here
include('php/db_connection.php'); // Update with your actual file or code

// Retrieve customer-specific data from the database
$username = $_SESSION['username'];

// Retrieve the customer's current reservations
$reservationStmt = $pdo->prepare("SELECT * FROM reservations WHERE user_id = (SELECT id FROM users WHERE username = ?)");
$reservationStmt->execute([$username]);
$reservations = $reservationStmt->fetchAll(PDO::FETCH_ASSOC);

// Retrieve event spaces for the reservation form
$eventSpacesStmt = $pdo->query("SELECT * FROM event_spaces");
$eventSpaces = $eventSpacesStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
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
                <li><a href="index.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Section -->
    <main>
        <h2>Welcome to Your Customer Dashboard, <?php echo $_SESSION['username']; ?>!</h2>

        <!-- Display customer's current reservations -->
        <h3>Your Current Reservations:</h3>
        <?php if (empty($reservations)): ?>
            <p>No reservations found.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($reservations as $reservation): ?>
                    <li>
                        <?php echo $reservation['table_name']; ?> - <?php echo $reservation['reservation_date']; ?>
                        <!-- Edit and Delete options -->
                        <a href="edit_reservation_cus.php?id=<?php echo $reservation['id']; ?>">Edit</a> |
                        <a href="delete_reservation_cus.php?id=<?php echo $reservation['id']; ?>" onclick="return confirm('Are you sure you want to delete this reservation?')">Delete</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Reservation Form -->
        <section class="reservation-form">
            <h2>Make a Reservation</h2>
            <form action="customer_dashboard.php" method="post">
                <!-- Add form fields for creating a new reservation -->
                <label for="event_space">Select Event Space:</label>
                <select name="event_space" required>
                    <?php foreach ($eventSpaces as $eventSpace): ?>
                        <option value="<?php echo $eventSpace['id']; ?>"><?php echo $eventSpace['name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="table_name">Table Name:</label>
                <input type="text" name="table_name" required>

                <label for="reservation_date">Reservation Date:</label>
                <input type="datetime-local" name="reservation_date" required>

                <label for="customer_name">Your Name:</label>
                <input type="text" name="customer_name" required>

                <label for="customer_email">Your Email:</label>
                <input type="email" name="customer_email" required>

                <button type="submit">Submit Reservation</button>
            </form>
        </section>
    </main>

    <!-- Contact Section -->
    <section class="contact">
        <h2>Contact Us</h2>
        <p>For inquiries, please contact us:</p>
        <ul>
            <li>Phone: +1 (123) 456-7890</li>
            <li>Email: info@outerclove.com</li>
        </ul>
        
        <!-- Google Map -->
        <div class="google-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2591.652075422456!2d-117.29785302373405!3d49.49107885597503!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x537cb6a67b4952a1%3A0xe9628c94e2a00cb3!2sOuter%20Clove%20Restaurant!5e0!3m2!1sen!2slk!4v1703913421384!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2023 The Outer Clove Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
