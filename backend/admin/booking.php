<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $service = $_POST["service"];
    $date = $_POST["booking_date"];

    // Check if user exists, else insert
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $phone);
        $stmt->execute();
        $user_id = $stmt->insert_id;
    } else {
        $stmt->bind_result($user_id);
        $stmt->fetch();
    }   
    // Insert booking record
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, service, booking_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $service, $date);
    
    if ($stmt->execute()) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<form method="POST">
    <input type="text" name="name" placeholder="Your Name" required><br>
    <input type="email" name="email" placeholder="Your Email" required><br>
    <input type="text" name="phone" placeholder="Your Phone" required><br>
    <select name="service" required>
        <option value="Yoga">Yoga</option>
        <option value="Massage Therapy">Massage Therapy</option>
        <option value="Personal Training">Personal Training</option>
    </select><br>
    <input type="date" name="booking_date" required><br>
    <button type="submit">Book Now</button>
</form>