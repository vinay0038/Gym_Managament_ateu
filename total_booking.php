<?php
// Assuming you have a database connection already established
include("db_connect.php");

// Fetching the total number of bookings
$sql = "SELECT COUNT(*) AS totalBookings FROM bookings";
$result = mysqli_query($conn, $sql);

// Fetch the result and display the total
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalBookings = $row['totalBookings'];
} else {
    $totalBookings = 0; // If the query fails, set it to 0
}

// Display the result
echo "Total Bookings: " . $totalBookings;
?>
