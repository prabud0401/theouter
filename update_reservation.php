<?php
include_once("php/db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $reservationId = $_POST['reservation_id'];
    $eventSpaceId = $_POST['event_space'];
    $tableName = $_POST['table_name'];
    $reservationDate = $_POST['reservation_date'];
    $customerName = $_POST['customer_name'];
    $customerEmail = $_POST['customer_email'];
    $isApproved = isset($_POST['is_approved']) ? 1 : 0;

    // Update reservation in the database
    $queryUpdate = "UPDATE reservations SET
                    event_space_id = '$eventSpaceId',
                    table_name = '$tableName',
                    reservation_date = '$reservationDate',
                    customer_name = '$customerName',
                    customer_email = '$customerEmail',
                    is_approved = $isApproved
                    WHERE id = $reservationId";

    if ($conn->query($queryUpdate) === TRUE) {
        // Redirect back to admin_reservations.php after successful update
        header("Location: admin_reservations.php");
        exit;
    } else {
        echo "Error updating reservation: " . $conn->error;
    }
} else {
    // If the form is not submitted through POST method, redirect to the home page
    header("Location: index.php");
    exit;
}
?>
