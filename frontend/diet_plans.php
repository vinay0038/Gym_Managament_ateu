<?php
session_start();
require '../backend/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Plans</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Workout Plans</h1>
    <p>Coming soon...</p>
    <a href="dashboard.php">Go Back</a>
</body>
</html>
