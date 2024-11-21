<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "meetingroom");
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$booking_id = $data['booking_id'];
$cancellation_reason = $data['cancellation_reason'] ?? '';

if (empty($cancellation_reason)) {
    echo json_encode(["status" => "error", "message" => "Cancellation reason is required."]);
    exit();
}

$query = "SELECT booking_date, booking_time FROM bookings WHERE booking_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $booking_id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "Booking not found."]);
        exit();
    }

    $row = $result->fetch_assoc();
    $bookingDateTime = new DateTime("{$row['booking_date']} {$row['booking_time']}");
    $currentDateTime = new DateTime();

    if ($bookingDateTime <= $currentDateTime) {
        echo json_encode(["status" => "error", "message" => "Cannot cancel past bookings."]);
        exit();
    }

    $updateQuery = "UPDATE bookings SET cancellation_reason = ? WHERE booking_id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("si", $cancellation_reason, $booking_id);

    if ($updateStmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Booking successfully canceled with reason provided."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to cancel booking."]);
    }

    $updateStmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Failed to execute query."]);
}

$stmt->close();
$conn->close();
?>

