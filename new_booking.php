<?php
$conn = new mysqli("localhost", "root", "", "meetingroom");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

$bookingDate = $_POST['booking_date'];
$bookingTime = $_POST['booking_time'];
$duration = $_POST['duration'];

$bookingDateTime = new DateTime("$bookingDate $bookingTime");
$currentDateTime = new DateTime();

if ($bookingDateTime <= $currentDateTime) {
    echo json_encode(["status" => "error", "message" => "You cannot book a past time."]);
    exit();
}
echo json_encode(["status" => "success", "message" => "Booking successful."]);
?>
