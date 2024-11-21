<?php
session_start();
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "meetingroom");

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $_SESSION['user_id'];
$room_name = $data['room_name'];
$booking_date = $data['booking_date'];
$booking_time = $data['booking_time'];
$duration = $data['duration'];
$notes = $data['notes'];

$currentDateTime = new DateTime();
$bookingDateTime = new DateTime("$booking_date $booking_time");

$dayOfWeek = $bookingDateTime->format('N');  
if ($dayOfWeek >= 6) { 
    echo json_encode(["status" => "error", "message" => "Booking is not allowed on weekends. Please choose a weekday."]);
    exit();
}

if ($bookingDateTime <= $currentDateTime) {
    echo json_encode(["status" => "error", "message" => "You cannot book a room in the past."]);
    exit();
}

$checkUserBookingQuery = "SELECT * FROM bookings WHERE user_id = ? AND booking_date = ?";
$stmt = $conn->prepare($checkUserBookingQuery);
$stmt->bind_param("is", $user_id, $booking_date);
$stmt->execute();
$userBookingResult = $stmt->get_result();

if ($userBookingResult->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "You can only book one room per day."]);
    exit();
}

$checkRoomAvailabilityQuery = "SELECT * FROM bookings WHERE room_name = ? AND booking_date = ? AND (
    (booking_time <= ? AND DATE_ADD(booking_time, INTERVAL duration HOUR) > ?) OR
    (? <= booking_time AND ? > booking_time)
)";
$stmt = $conn->prepare($checkRoomAvailabilityQuery);
$stmt->bind_param("ssssss", $room_name, $booking_date, $booking_time, $booking_time, $booking_time, $booking_time);
$stmt->execute();
$roomAvailabilityResult = $stmt->get_result();

if ($roomAvailabilityResult->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "This room is already booked at the selected time. Please choose a different time."]);
    exit();
}

$insertQuery = "INSERT INTO bookings (user_id, room_name, booking_date, booking_time, duration, notes) 
                VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insertQuery);
$stmt->bind_param("isssis", $user_id, $room_name, $booking_date, $booking_time, $duration, $notes);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Room booked successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to book room. Please try again later."]);
}

$stmt->close();
$conn->close();
?>







