<?php
include "db.php";

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=booking_report.xls");

$result = $conn->query("SELECT bookings.id, users.name, users.email, users.phone, bookings.service, bookings.booking_date, bookings.status 
                        FROM bookings 
                        JOIN users ON bookings.user_id = users.id");

echo "ID\tName\tEmail\tPhone\tService\tDate\tStatus\n";

while ($row = $result->fetch_assoc()) {
    echo "{$row['id']}\t{$row['name']}\t{$row['email']}\t{$row['phone']}\t{$row['service']}\t{$row['booking_date']}\t{$row['status']}\n";
}
?>