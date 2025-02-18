<?php
session_start();
require 'db.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: ../frontend/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$class_id = $_POST['class_id'];


$check_booking = "SELECT * FROM bookings WHERE user_id='$user_id' AND class_id='$class_id'";
$result = $conn->query($check_booking);

if ($result->num_rows > 0) {
    echo "<script>alert('You have already booked this class!'); window.location.href='../frontend/classes.php';</script>";
    exit();
}


$sql = "INSERT INTO bookings (user_id, class_id) VALUES ('$user_id', '$class_id')";
if ($conn->query($sql)) {
   
    $update_slots = "UPDATE classes SET available_slots = available_slots - 1 WHERE id='$class_id'";
    $conn->query($update_slots);

    echo "<script>alert('Class booked successfully!'); window.location.href='../frontend/classes.php';</script>";
} else {
    echo "<script>alert('Booking failed! Try again.'); window.location.href='../frontend/classes.php';</script>";
}
?>
