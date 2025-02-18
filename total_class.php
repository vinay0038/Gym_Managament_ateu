<?php
// Start session to handle user data if needed
session_start();

// Include the database connection file
include('db.php');  // Ensure db.php contains the correct database connection

// Query to get the total number of classes
$sql = "SELECT COUNT(*) as totalClasses FROM Classes";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful and fetch the result
if ($result) {
    $row = $result->fetch_assoc();  // Fetch the row as an associative array
    $totalClasses = $row['totalClasses'];  // Get the total classes count
} else {
    // If the query fails, set the total classes to 0
    $totalClasses = 0;
}

// Close the database connection
$conn->close();

// Display the total classes count
echo "Total Classes: " . $totalClasses;
?>
