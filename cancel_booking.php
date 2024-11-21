<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

$conn = new mysqli("localhost", "root", "", "meetingroom");
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$booking_id = $data['booking_id'];
$user_id = $_SESSION['user_id'];

$query = "SELECT booking_date, booking_time FROM bookings WHERE booking_id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Booking not found or unauthorized access."]);
    exit();
}

$row = $result->fetch_assoc();
$bookingDateTime = new DateTime("{$row['booking_date']} {$row['booking_time']}");
$currentDateTime = new DateTime();

if ($bookingDateTime <= $currentDateTime) {
    echo json_encode(["status" => "error", "message" => "Cannot cancel past bookings."]);
    exit();
}

$deleteQuery = "DELETE FROM bookings WHERE booking_id = ? AND user_id = ?";
$deleteStmt = $conn->prepare($deleteQuery);
$deleteStmt->bind_param("ii", $booking_id, $user_id);

if ($deleteStmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Booking successfully canceled."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to cancel booking."]);
}

$deleteStmt->close();
$stmt->close();
$conn->close();
?>










