<?php
include_once("php/db_connection.php");

// Get reservation ID from the URL parameter
$reservationId = $_GET['id'];

// Perform deletion from the database
$queryDelete = "DELETE FROM reservations WHERE id = $reservationId";
$conn->query($queryDelete);

// Redirect to admin_reservations.php after deletion
header("Location: admin_reservations.php");
exit;
?>
