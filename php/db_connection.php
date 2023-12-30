<?php
$host = "localhost:3307"; // Specify the port after the hostname
$username = "root";
$password = "";
$database = "outer_clove_db"; // Change this to your actual database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to utf8
if (!$conn->set_charset("utf8")) {
    die("Error setting character set to utf8: " . $conn->error);
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

