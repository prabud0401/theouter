<?php
include_once("php/db_connection.php");

// Fetch event spaces from the database
$queryEventSpaces = "SELECT * FROM event_spaces";
$resultEventSpaces = $conn->query($queryEventSpaces);

// Process the result
$eventSpaces = $resultEventSpaces->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation - The Outer Clove Restaurant</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/calendar.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <h1>The Outer Clove Restaurant</h1>
        <!-- Navigation Bar -->
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="facilities.php">Facilities</a></li>
                <li><a href="reservation.php">Reservation</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="admin_reservations.php">Admin Reservations</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Section -->
    <main>
        <!-- Display Reservation Calendar for Each Event Space -->
        <?php
            foreach ($eventSpaces as $eventSpace) {
                echo "<section class='reservation-calendar'>";
                echo "<h2>{$eventSpace['name']} Reservation Calendar</h2>";

                // Fetch reservations for the current event space
                $queryReservations = "SELECT * FROM reservations WHERE event_space_id = {$eventSpace['id']}";
                $resultReservations = $conn->query($queryReservations);
                $reservations = $resultReservations->fetch_all(MYSQLI_ASSOC);

                // Display reservation calendar
                echo "<table>";
                echo "<tr><th>Table</th><th>Date</th><th>Customer Name</th><th>Customer Email</th></tr>";
                foreach ($reservations as $reservation) {
                    echo "<tr>";
                    echo "<td>{$reservation['table_name']}</td>";
                    echo "<td>{$reservation['reservation_date']}</td>";
                    echo "<td>{$reservation['customer_name']}</td>";
                    echo "<td>{$reservation['customer_email']}</td>";
                    echo "</tr>";
                }
                echo "</table>";

                echo "</section>";
            }
        ?>

        <!-- Reservation Form -->
        <section class="reservation-form">
            <h2>Make a Reservation</h2>
            <form action="create_reservation.php" method="post">
                <!-- Add form fields for creating a new reservation -->
                <label for="event_space">Select Event Space:</label>
                <select name="event_space" required>
                    <?php
                        foreach ($eventSpaces as $eventSpace) {
                            echo "<option value='{$eventSpace['id']}'>{$eventSpace['name']}</option>";
                        }
                    ?>
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
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2591.652075422456!2d-117.29785302373405!3d49.49107885597503!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x537cb6a67b4952a1%3A0xe9628c94e2a00cb3!2sOuter%20Clove%20Restaurant!5e0!3m2!1sen!2slk!4v1703913421384!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>            </div>
        </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2023 The Outer Clove Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
