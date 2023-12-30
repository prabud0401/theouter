<?php
include_once("php/db_connection.php");

// Fetch menu items from the database
$query = "SELECT * FROM menu_items";
$result = $conn->query($query);

// Process the result
$menuItems = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - The Outer Clove Restaurant</title>
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
                <li><a href="about.php">About Us</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="facilities.php">Facilities</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Section -->
    <main>
        <!-- Display Menu Items -->
        <section class="menu">
            <h2>Our Menu</h2>
            <?php
                // Display menu items
                foreach ($menuItems as $menuItem) {
                    echo "<div class='menu-item'>";
                    echo "<img src='{$menuItem['image_url']}' alt='{$menuItem['name']}'>";
                    echo "<h3>{$menuItem['name']}</h3>";
                    echo "<p>{$menuItem['description']}</p>";
                    echo "<p class='price'>$ {$menuItem['price']}</p>";
                    echo "</div>";
                }
            ?>
        </section>

        <!-- Other Sections as Needed -->

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
