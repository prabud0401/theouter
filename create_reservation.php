<?php
include_once("php/db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $eventSpaceId = $_POST['event_space'];
    $tableName = $_POST['table_name'];
    $reservationDate = $_POST['reservation_date'];
    $customerName = $_POST['customer_name'];
    $customerEmail = $_POST['customer_email'];

    // Insert reservation into the database
    $queryInsertReservation = "INSERT INTO reservations (event_space_id, table_name, reservation_date, customer_name, customer_email)
                               VALUES ($eventSpaceId, '$tableName', '$reservationDate', '$customerName', '$customerEmail')";

    if ($conn->query($queryInsertReservation) === TRUE) {
        // Successful insertion, redirect to reservation.php
        header("Location: reservation.php");
        exit();
    } else {
        // Handle the case where the insertion fails
        echo "Error: " . $queryInsertReservation . "<br>" . $conn->error;
    }
} else {
    // Handle the case where the form was not submitted properly
    echo "Invalid request.";
}
?>
