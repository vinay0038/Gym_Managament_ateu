<?php
// Start the session to get the logged-in admin details
session_start();

// Include the database connection file
include('db.php');  // Ensure this file contains the correct database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input values from the form
    $oldPassword = $_POST['oldPassword'];  // The old password entered by the admin
    $newPassword = $_POST['newPassword'];  // The new password entered by the admin
    $confirmPassword = $_POST['confirmPassword'];  // Confirm new password

    // Check if new password and confirm password match
    if ($newPassword !== $confirmPassword) {
        echo "New password and confirm password do not match!";
    } else {
        // Get the admin ID from session or specify manually (assuming it's in session)
        $adminID = $_SESSION['adminID'];

        // Query to get the current password for the logged-in admin
        $sql = "SELECT adminPassword FROM Admin WHERE adminID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $adminID);  // Bind the admin ID to the query
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the admin exists
        if ($result->num_rows > 0) {
            // Fetch the current password from the result
            $row = $result->fetch_assoc();
            $currentPassword = $row['adminPassword'];  // The current hashed password in the database

            // Verify the old password with the stored hashed password
            if (password_verify($oldPassword, $currentPassword)) {
                // Hash the new password before storing it
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update query to change the admin password
                $updateSql = "UPDATE Admin SET adminPassword = ? WHERE adminID = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("si", $hashedNewPassword, $adminID);  // Bind new password and admin ID
                $updateStmt->execute();

                // Check if the update was successful
                if ($updateStmt->affected_rows > 0) {
                    echo "Password updated successfully.";
                } else {
                    echo "Error updating the password. Please try again.";
                }
            } else {
                echo "The old password is incorrect.";
            }
        } else {
            echo "Admin not found.";
        }
    }
    // Close the database connection
    $conn->close();
}
?>

<!-- HTML Form for Admin to Update Password -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Admin Password</title>
</head>
<body>
    <h2>Update Password</h2>
    <form method="POST" action="">
        <label for="oldPassword">Old Password:</label>
        <input type="password" id="oldPassword" name="oldPassword" required><br><br>

        <label for="newPassword">New Password:</label>
        <input type="password" id="newPassword" name="newPassword" required><br><br>

        <label for="confirmPassword">Confirm New Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required><br><br>

        <input type="submit" value="Update Password">
    </form>
</body>
</html>
