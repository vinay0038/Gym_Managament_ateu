<?php
// Start the session to access session variables
session_start();

// Destroy all session data (logs the user out)
session_unset();  // This will remove all session variables
session_destroy(); // This will destroy the session itself

// Redirect the user to the login page or home page after logout
header("Location: login.php");
exit();
?>
