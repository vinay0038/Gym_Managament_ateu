<?php
// Include database connection
include("db.php");

// Initialize message variables
$success_message = "";
$error_message = "";

// Handle user deletion
if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        $success_message = "User deleted successfully!";
    } else {
        $error_message = "Error deleting user: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch all users from the database
$stmt = $conn->prepare("SELECT id, username, email, height, weight, fitness_goals, role, created_at FROM users");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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
        .message {
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h2>User Management</h2>

    <!-- Success or Error Message -->
    <?php if (!empty($success_message)): ?>
        <div class="message success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
        <div class="message error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <h3>All Users</h3>

    <!-- Users Table -->
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
                <th>Actions</th>
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
                    <td>
                        <a href="?delete_user=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
</body>
</html>
