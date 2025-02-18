<?php
session_start();
require '../backend/db.php'; // Include database connection

// If the user is not logged in, redirect them to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome, <?php echo $user['name']; ?>!</h1>
        
        <div class="profile-section">
            <h2>Profile Overview</h2>
            <p><strong>Name:</strong> <?php echo $user['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Height:</strong> <?php echo $user['height']; ?> cm</p>
            <p><strong>Weight:</strong> <?php echo $user['weight']; ?> kg</p>
            <p><strong>Fitness Goal:</strong> <?php echo $user['fitness_goal']; ?></p>
            <a href="edit_profile.php">Edit Profile</a>
        </div>

        <div class="quick-access">
            <h2>Quick Access</h2>
            <a href="classes.php">Book Classes</a> <!-- Updated if booking is handled in classes.php -->
            <a href="workout_plans.php">View Workout Plans</a>
            <a href="diet_plans.php">View Diet Plans</a>
            <a href="progress_tracker.php">Track Progress</a>
            <a href="profile.php">Profile Management</a>
        </div>


        <div class="upcoming-classes">
                <h2>Upcoming Classes</h2>
                <?php
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT c.class_name, c.schedule FROM bookings b 
                        JOIN classes c ON b.class_id = c.id 
                        WHERE b.user_id = '$user_id' ORDER BY c.schedule ASC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0): ?>
                    <ul>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <li><?php echo $row['class_name'] . " - " . date('d M Y, h:i A', strtotime($row['schedule'])); ?></li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>No upcoming classes booked.</p>
                <?php endif; ?>
        </div>


        <div class="membership-status">
            <h2>Membership Status</h2>
            <!-- Display the membership status (Active, Expired, Due for Renewal) -->
            <!-- Query and display the membership status -->
        </div>

        <div class="notifications">
            <h2>Notifications</h2>
            <!-- Display any notifications like payment reminders, class reminders, etc. -->
            <!-- You can query for notifications here -->
        </div>

        <a href="../backend/logout.php">Logout</a>
    </div>
</body>
</html>
