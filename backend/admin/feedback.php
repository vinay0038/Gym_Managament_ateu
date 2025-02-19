<?php
// Include database connection
include 'db.php';

// Query to fetch feedbacks along with user details
$sql = "SELECT feedback.id, users.username, feedback.trainer_name, feedback.rating, feedback.comments, feedback.submitted_at 
        FROM feedback 
        JOIN users ON feedback.user_id = users.id
        ORDER BY feedback.submitted_at DESC";

// Execute the query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Feedbacks</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>User Feedbacks</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Trainer Name</th>
            <th>Rating</th>
            <th>Comments</th>
            <th>Submitted At</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['trainer_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['rating']); ?></td>
                    <td><?php echo htmlspecialchars($row['comments']); ?></td>
                    <td><?php echo htmlspecialchars($row['submitted_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">No feedbacks found.</td></tr>
        <?php endif; ?>
    </table>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>
