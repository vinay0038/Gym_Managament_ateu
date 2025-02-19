<?php
// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$host = 'localhost';
$dbname = 'gym_management';
$username = 'root';
$password = '';
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize messages
$success_message = "";
$error_message = "";

// Handle diet plan submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_diet_plan'])) {
    $user_id = $_POST['user_id'];
    $diet_type = $_POST['diet_type'];
    $meal_plan = $_POST['meal_plan'];
    $recommended_by = $_POST['recommended_by'];

    if (!empty($user_id) && !empty($diet_type) && !empty($meal_plan)) {
        // Prepare and execute the query to insert diet plan
        $query = "INSERT INTO diet_plans (user_id, diet_type, meal_plan, recommended_by) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            $error_message = "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param("isss", $user_id, $diet_type, $meal_plan, $recommended_by);
            if ($stmt->execute()) {
                $success_message = "Diet plan added successfully!";
            } else {
                $error_message = "Error executing query: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        $error_message = "Please fill in all the fields.";
    }
}

// Fetch users (outside the POST handling)
$sql = "SELECT id, username FROM users ORDER BY username ASC";
$result = $conn->query($sql);

// Available diet types for the dropdown
$diet_types = ['Vegetarian', 'Keto', 'Vegan', 'Paleo', 'Mediterranean'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Diet Plan</title>
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
    <h2>Create Diet Plan</h2>

    <?php if (!empty($success_message)): ?>
        <div class="message success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
        <div class="message error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <table>
            <tr>
                <th>Select User</th>
                <th>User ID</th>
                <th>Username</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <input type="radio" name="user_id" value="<?php echo htmlspecialchars($row['id']); ?>" required>
                        </td>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3">No users found.</td></tr>
            <?php endif; ?>
        </table>

        <h3>Diet Plan Details</h3>
        <label for="diet_type">Diet Type:</label><br>
        <select id="diet_type" name="diet_type" required>
            <option value="">Select Diet Type</option>
            <?php foreach ($diet_types as $diet): ?>
                <option value="<?php echo htmlspecialchars($diet); ?>"><?php echo htmlspecialchars($diet); ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="meal_plan">Meal Plan:</label><br>
        <textarea id="meal_plan" name="meal_plan" rows="5" required></textarea><br><br>

        <label for="recommended_by">Recommended By (Optional):</label><br>
        <input type="text" id="recommended_by" name="recommended_by"><br><br>

        <button type="submit" name="submit_diet_plan">Save Diet Plan</button>
    </form>

    <?php $conn->close(); ?>
</body>
</html>
