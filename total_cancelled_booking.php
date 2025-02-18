<?php
// Assuming you have a database connection already established
include("db_connect.php");

// Fetching the total number of cancelled bookings
$sql = "SELECT COUNT(*) AS totalCancelledBookings FROM bookings WHERE status = 'cancelled'";
$result = mysqli_query($conn, $sql);

// Fetch the result and display the total
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalCancelledBookings = $row['totalCancelledBookings'];
} else {
    $totalCancelledBookings = 0; // If the query fails, set it to 0
}

// Display the result
echo "Total Cancelled Bookings: " . $totalCancelledBookings;
?>
