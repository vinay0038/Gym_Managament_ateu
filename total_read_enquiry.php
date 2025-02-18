<?php
// Start session to handle user data if needed
session_start();

// Include the database connection file
include('db.php');  // Ensure db.php contains the correct database connection

// Query to get the total read enquiries
$sql = "SELECT COUNT(*) as totalReadEnquiries FROM Enquiries WHERE EnquiryStatus = 'Read'";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful and fetch the result
if ($result) {
    $row = $result->fetch_assoc();  // Fetch the row as an associative array
    $totalReadEnquiries = $row['totalReadEnquiries'];  // Get the total read enquiries count
} else {
    // If the query fails, set the total read enquiries to 0
    $totalReadEnquiries = 0;
}

// Close the database connection
$conn->close();

// Display the total read enquiries count
echo "Total Read Enquiries: " . $totalReadEnquiries;
?>
