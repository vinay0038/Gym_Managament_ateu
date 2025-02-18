<?php
// Include the database connection
include("db.php");

// Fetch all users and their details
$stmt = $conn->prepare("SELECT id, username, email, height, weight, fitness_goals, role, created_at FROM users");
$stmt->execute();
$result = $stmt->get_result();

// Fetch total counts for statistics
$total_users_query = "SELECT COUNT(*) AS total_users FROM users";
$total_users_result = $conn->query($total_users_query);
$total_users = $total_users_result->fetch_assoc()['total_users'];

$total_admins_query = "SELECT COUNT(*) AS total_admins FROM users WHERE role = 'admin'";
$total_admins_result = $conn->query($total_admins_query);
$total_admins = $total_admins_result->fetch_assoc()['total_admins'];

$total_memberships_query = "SELECT COUNT(*) AS total_memberships FROM memberships";
$total_memberships_result = $conn->query($total_memberships_query);
$total_memberships = $total_memberships_result->fetch_assoc()['total_memberships'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Report</title>
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
        .stats {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2>Admin Report</h2>

    <!-- Statistics Section -->
    <div class="stats">
        <h3>Statistics</h3>
        <p>Total Users: <?php echo $total_users; ?></p>
        <p>Total Admins: <?php echo $total_admins; ?></p>
        <p>Total Memberships: <?php echo $total_memberships; ?></p>
    </div>

    <!-- User Details Table -->
    <h3>User Details</h3>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Height</th>
                <th>Weight</th>
                <th>Fitness Goals</th>
                <th>Role</th>
                <th>Created At</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['height']); ?></td>
                    <td><?php echo htmlspecialchars($row['weight']); ?></td>
                    <td><?php echo htmlspecialchars($row['fitness_goals']); ?></td>
                    <td><?php echo htmlspecialchars($row['role']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>

    <?php
    // Close the statement and connection
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
