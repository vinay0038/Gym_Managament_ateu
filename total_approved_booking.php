<?php
// Start session to handle user data if needed
session_start();

// Include the database connection file
include('db.php');  // Make sure db.php contains the database connection

// Query to get the total approved bookings
$sql = "SELECT COUNT(*) as totalApproved FROM Bookings WHERE BookingStatus = 'Approved'";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful and fetch the result
if ($result) {
    $row = $result->fetch_assoc();  // Fetch the row as an associative array
    $totalApproved = $row['totalApproved'];  // Get the total approved bookings count
} else {
    // If the query fails, set the total approved bookings to 0
    $totalApproved = 0;
}

// Close the database connection
$conn->close();

// Display the total approved bookings count
echo "Total Approved Bookings: " . $totalApproved;
?>
