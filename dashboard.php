<?php
// Include the database connection file
include('db.php');

// Queries to fetch the required data
$newBookingsQuery = "SELECT COUNT(*) as totalNew FROM Bookings WHERE BookingStatus = 'New'";
$approvedBookingsQuery = "SELECT COUNT(*) as totalApproved FROM Bookings WHERE BookingStatus = 'Approved'";
$cancelledBookingsQuery = "SELECT COUNT(*) as totalCancelled FROM Bookings WHERE BookingStatus = 'Cancelled'";
$totalBookingsQuery = "SELECT COUNT(*) as totalBookings FROM Bookings";
$readInquiriesQuery = "SELECT COUNT(*) as totalRead FROM Inquiries WHERE IsRead = TRUE";
$unreadInquiriesQuery = "SELECT COUNT(*) as totalUnread FROM Inquiries WHERE IsRead = FALSE";
$totalInquiriesQuery = "SELECT COUNT(*) as totalInquiries FROM Inquiries";
$totalClassesQuery = "SELECT COUNT(*) as totalClasses FROM Classes";

// Fetch the data for each query
$newBookingsResult = $conn->query($newBookingsQuery);
$approvedBookingsResult = $conn->query($approvedBookingsQuery);
$cancelledBookingsResult = $conn->query($cancelledBookingsQuery);
$totalBookingsResult = $conn->query($totalBookingsQuery);
$readInquiriesResult = $conn->query($readInquiriesQuery);
$unreadInquiriesResult = $conn->query($unreadInquiriesQuery);
$totalInquiriesResult = $conn->query($totalInquiriesQuery);
$totalClassesResult = $conn->query($totalClassesQuery);

// Fetch the results as associative arrays
$newBookings = $newBookingsResult->fetch_assoc();
$approvedBookings = $approvedBookingsResult->fetch_assoc();
$cancelledBookings = $cancelledBookingsResult->fetch_assoc();
$totalBookings = $totalBookingsResult->fetch_assoc();
$readInquiries = $readInquiriesResult->fetch_assoc();
$unreadInquiries = $unreadInquiriesResult->fetch_assoc();
$totalInquiries = $totalInquiriesResult->fetch_assoc();
$totalClasses = $totalClassesResult->fetch_assoc();

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Management Dashboard</title>
    <link rel="stylesheet" href="styles.css">  <!-- Include your own CSS file -->
</head>
<body>

<div class="dashboard">
    <h1>Gym Management Dashboard</h1>

    <div class="stats">
        <div class="stat-item">
            <h3>Total New Bookings</h3>
            <p><?php echo $newBookings['totalNew']; ?></p>
        </div>
        <div class="stat-item">
            <h3>Total Approved Bookings</h3>
            <p><?php echo $approvedBookings['totalApproved']; ?></p>
        </div>
        <div class="stat-item">
            <h3>Total Cancelled Bookings</h3>
            <p><?php echo $cancelledBookings['totalCancelled']; ?></p>
        </div>
        <div class="stat-item">
            <h3>Total Bookings</h3>
            <p><?php echo $totalBookings['totalBookings']; ?></p>
        </div>
        <div class="stat-item">
            <h3>Total Read Inquiries</h3>
            <p><?php echo $readInquiries['totalRead']; ?></p>
        </div>
        <div class="stat-item">
            <h3>Total Unread Inquiries</h3>
            <p><?php echo $unreadInquiries['totalUnread']; ?></p>
        </div>
        <div class="stat-item">
            <h3>Total Inquiries</h3>
            <p><?php echo $totalInquiries['totalInquiries']; ?></p>
        </div>
        <div class="stat-item">
            <h3>Total Classes</h3>
            <p><?php echo $totalClasses['totalClasses']; ?></p>
        </div>
    </div>
</div>

</body>
</html>
