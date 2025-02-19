<?php
// Include the database connection
include("db.php");

// Fetch all memberships and user details
$query = "
    SELECT u.id AS user_id, u.username, m.membership_type, m.start_date, m.end_date, m.payment_status
    FROM users u
    LEFT JOIN memberships m ON u.id = m.user_id
    ORDER BY u.username;
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Monitoring</title>
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
        .no-membership {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Membership Monitoring</h2>
    
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Membership Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Payment Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td>
                        <?php echo $row['membership_type'] ? htmlspecialchars($row['membership_type']) : '<span class="no-membership">No membership</span>'; ?>
                    </td>
                    <td>
                        <?php echo $row['start_date'] ? htmlspecialchars($row['start_date']) : 'N/A'; ?>
                    </td>
                    <td>
                        <?php echo $row['end_date'] ? htmlspecialchars($row['end_date']) : 'N/A'; ?>
                    </td>
                    <td>
                        <?php echo $row['payment_status'] ? htmlspecialchars($row['payment_status']) : 'N/A'; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No memberships found.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
</body>
</html>
