<?php
include_once("php/db_connection.php");

// Get reservation ID from the URL parameter
$reservationId = $_GET['id'];

// Fetch reservation details from the database
$queryReservation = "SELECT * FROM reservations WHERE id = $reservationId";
$resultReservation = $conn->query($queryReservation);

// Process the result
$reservation = $resultReservation->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation - The Outer Clove Restaurant</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <h1>The Outer Clove Restaurant</h1>
        <!-- Navigation Bar -->
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <!-- Add links to other pages as needed -->
                <li><a href="about.php">About Us</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="facilities.php">Facilities</a></li>
                <li><a href="reservation.php">Reservation</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Section -->
    <main>
        <!-- Reservation Edit Form -->
        <section class='reservation-edit-form'>
            <h2>Edit Reservation</h2>

            <!-- Form for Editing Reservation Details -->
            <form action="update_reservation.php" method="post">
                <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">

                <!-- Add form fields for editing reservation details -->
                <label for="event_space">Event Space:</label>
                <input type="text" name="event_space" value="<?php echo $reservation['event_space_id']; ?>" required>

                <label for="table_name">Table Name:</label>
                <input type="text" name="table_name" value="<?php echo $reservation['table_name']; ?>" required>

                <label for="reservation_date">Reservation Date:</label>
                <input type="datetime-local" name="reservation_date" value="<?php echo date('Y-m-d\TH:i', strtotime($reservation['reservation_date'])); ?>" required>

                <label for="customer_name">Customer Name:</label>
                <input type="text" name="customer_name" value="<?php echo $reservation['customer_name']; ?>" required>

                <label for="customer_email">Customer Email:</label>
                <input type="email" name="customer_email" value="<?php echo $reservation['customer_email']; ?>" required>

                <label for="is_approved">Approved:</label>
                <input type="checkbox" name="is_approved" <?php echo $reservation['is_approved'] ? 'checked' : ''; ?>>

                <button type="submit">Update Reservation</button>
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
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2591.652075422456!2d-117.29785302373405!3d49.49107885597503!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x537cb6a67b4952a1%3A0xe9628c94e2a00cb3!2sOuter%20Clove%20Restaurant!5e0!3m2!1sen!2slk!4v1703913421384!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>            </div>
        </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2023 The Outer Clove Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
