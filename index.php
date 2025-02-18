<?php
session_start();

// Include database connection file
include('config.php');

// Check if form is submitted
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email and password are valid
    $query = "SELECT * FROM Admins WHERE Email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $admin['PasswordHash'])) {
            $_SESSION['admin_id'] = $admin['AdminID']; // Store session data for admin
            $_SESSION['admin_name'] = $admin['FullName'];
            header('Location: admin_dashboard.php'); // Redirect to the dashboard
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Admin not found with this email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
    <h2>Admin Login</h2>
    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
    
    <form method="POST" action="">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit" name="login">Login</button>
    </form>
</div>

</body>
</html>
