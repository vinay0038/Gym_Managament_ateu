<?php
session_start();
require '../backend/db.php'; // Include database connection

// If the user is not logged in, redirect them to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get current user information
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get updated user information from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $fitness_goal = $_POST['fitness_goal'];

    // Update user information in the database
    $sql = "UPDATE users SET name='$name', email='$email', height='$height', weight='$weight', fitness_goal='$fitness_goal' WHERE id='$user_id'";

    if ($conn->query($sql) === TRUE) {
        // Successfully updated, redirect to dashboard in frontend
        header("Location: ../frontend/dashboard.php");
        exit();
    } else {
        // Handle any errors
        echo "Error updating profile: " . $conn->error;
    }
} else {
    // If the form is not submitted yet, fetch user info
    $sql = "SELECT * FROM users WHERE id='$user_id'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="profile-container">
        <h1>Profile Management</h1>
        
        <!-- Display current user info -->
        <form method="POST" action="../backend/update_profile.php">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>

            <label for="height">Height (cm)</label>
            <input type="number" id="height" name="height" value="<?php echo $user['height']; ?>" required>

            <label for="weight">Weight (kg)</label>
            <input type="number" id="weight" name="weight" value="<?php echo $user['weight']; ?>" required>

            <label for="fitness_goal">Fitness Goal</label>
            <input type="text" id="fitness_goal" name="fitness_goal" value="<?php echo $user['fitness_goal']; ?>" required>

            <button type="submit">Update Profile</button>
        </form>

        <a href="../frontend/dashboard.php">Go Back to Dashboard</a>
    </div>
</body>
</html>
