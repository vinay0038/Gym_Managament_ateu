<?php
// Start session to handle user data if needed
session_start();

// Include the database connection file
include('db.php');  // Ensure db.php contains the correct database connection

// Query to get the total new bookings
$sql = "SELECT COUNT(*) as totalNewBookings FROM Bookings WHERE BookingStatus = 'New'";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful and fetch the result
if ($result) {
    $row = $result->fetch_assoc();  // Fetch the row as an associative array
    $totalNewBookings = $row['totalNewBookings'];  // Get the total new bookings count
} else {
    // If the query fails, set the total new bookings to 0
    $totalNewBookings = 0;
}

// Close the database connection
$conn->close();

// Display the total new bookings count
echo "Total New Bookings: " . $totalNewBookings;
?>
