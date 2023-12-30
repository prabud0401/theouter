<?php
include_once("php/db_connection.php");

// Fetch all reservations from the database
$queryReservations = "SELECT * FROM reservations";
$resultReservations = $conn->query($queryReservations);

// Process the result
$reservations = $resultReservations->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Reservations - The Outer Clove Restaurant</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header Section -->
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
        <!-- Display Reservations Table for Admin -->
        <section class='admin-reservations'>
            <h2>Admin Reservations</h2>

            <!-- Display Reservations in a Table -->
            <table>
                <tr>
                    <th>ID</th>
                    <th>Event Space</th>
                    <th>Table</th>
                    <th>Date</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Approved</th>
                    <th>Action</th>
                </tr>
                <?php
                foreach ($reservations as $reservation) {
                    echo "<tr>";
                    echo "<td>{$reservation['id']}</td>";
                    echo "<td>{$reservation['event_space_id']}</td>";
                    echo "<td>{$reservation['table_name']}</td>";
                    echo "<td>{$reservation['reservation_date']}</td>";
                    echo "<td>{$reservation['customer_name']}</td>";
                    echo "<td>{$reservation['customer_email']}</td>";
                    echo "<td>" . ($reservation['is_approved'] ? 'Yes' : 'No') . "</td>";
                    echo "<td><a href='edit_reservation.php?id={$reservation['id']}'>Edit</a> | <a href='delete_reservation.php?id={$reservation['id']}'>Delete</a></td>";
                    echo "</tr>";
                }
                ?>
            </table>
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
