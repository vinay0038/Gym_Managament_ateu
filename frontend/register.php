<?php
require '../backend/db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $fitness_goal = $_POST['fitness_goal'];

    // Insert user data into database
    $sql = "INSERT INTO users (name, email, password, height, weight, fitness_goal) 
            VALUES ('$name', '$email', '$password', '$height', '$weight', '$fitness_goal')";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Registration successful! <a href='login.php'>Login here</a>";
    } else {
        echo "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>User Registration</h2>
    <form method="post">
        <input type="text" name="name" placeholder="Full Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="number" name="height" placeholder="Height (cm)" required><br>
        <input type="number" name="weight" placeholder="Weight (kg)" required><br>
        <textarea name="fitness_goal" placeholder="Your Fitness Goal" required></textarea><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
