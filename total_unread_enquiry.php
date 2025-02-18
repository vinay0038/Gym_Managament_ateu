<?php
// Assuming you have a database connection already established
include("db_connect.php");

// Fetching the total number of unread enquiries
$sql = "SELECT COUNT(*) AS totalUnreadEnquiries FROM enquiries WHERE status = 'unread'";
$result = mysqli_query($conn, $sql);

// Fetch the result and display the total
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalUnreadEnquiries = $row['totalUnreadEnquiries'];
} else {
    $totalUnreadEnquiries = 0; // If the query fails, set it to 0
}

// Display the result
echo "Total Unread Enquiries: " . $totalUnreadEnquiries;
?>
