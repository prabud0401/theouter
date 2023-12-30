<?php
// Start the session
session_start();

include_once("php/db_connection.php");

// Initialize the error variable
$error = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input
    $username = $_POST['username'];
    $password = $_POST['password'];
    $usertype = $_POST['usertype'];

    // Query the database
    $query = "SELECT * FROM users WHERE username = '$username' AND usertype = '$usertype'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $storedPassword = $user['password'];

        // Compare passwords
        if ($password === $storedPassword) {
            // Login successful

            // Set session variables
            $_SESSION['username'] = $username;
            $_SESSION['usertype'] = $usertype;

            // Redirect to the appropriate dashboard
            switch ($usertype) {
                case 'customer':
                    header("Location: customer_dashboard.php");
                    break;
                case 'staff':
                    header("Location: staff_dashboard.php");
                    break;
                case 'admin':
                    header("Location: admin_dashboard.php");
                    break;
                default:
                    echo "Invalid user type";
                    break;
            }

            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "Invalid username, password, or user type.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
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
                <li><a href="index.php">Login</a></li>

            </ul>
        </nav>
    </header>
    <main>
        <section class="login-form">
            <h2>Login</h2>
            <?php
            if (isset($error)) {
                echo "<p class='error'>$error</p>";
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="usertype">User Type:</label>
                <select id="usertype" name="usertype" required>
                    <option value="customer">Customer</option>
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                </select>

                <button type="submit">Login</button>
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
