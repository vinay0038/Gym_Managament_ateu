<?php
session_start();
require '../backend/db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch available classes from database
$sql = "SELECT * FROM classes WHERE available_slots > 0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Classes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="class-container">
        <h1>Available Classes</h1>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Class Name</th>
                    <th>Description</th>
                    <th>Schedule</th>
                    <th>Available Slots</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['class_name']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo date('d M Y, h:i A', strtotime($row['schedule'])); ?></td>
                        <td><?php echo $row['available_slots']; ?></td>
                        <td>
                            <form action="../backend/process_booking.php" method="POST">
                                <input type="hidden" name="class_id" value="<?php echo $row['id']; ?>">
                                <button type="submit">Book Now</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No available classes at the moment.</p>
        <?php endif; ?>
        <a href="dashboard.php">Go Back</a>
    </div>
</body>
</html>
