<?php
session_start();
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

$conn = new mysqli("localhost", "root", "", "meetingroom");
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

$userId = $_SESSION['user_id'];
$currentDateTime = new DateTime();
$currentDate = $currentDateTime->format('Y-m-d'); 
$currentTime = $currentDateTime->format('H:i:s'); 

$upcomingBookings = [];
$pastBookings = [];

$query = "SELECT * FROM bookings WHERE user_id = ? ORDER BY booking_date, booking_time";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $bookingDate = $row['booking_date'];
        $bookingTime = $row['booking_time'];

        if ($bookingDate < $currentDate) {
            $pastBookings[] = $row;
        } elseif ($bookingDate == $currentDate) {
            if ($bookingTime < $currentTime) {
                $pastBookings[] = $row; 
            } else {
                $upcomingBookings[] = $row; 
            }
        } else {
            $upcomingBookings[] = $row;
        }
    }

    $response = [
        "status" => "success",
        "upcomingBookings" => $upcomingBookings,
        "pastBookings" => $pastBookings
    ];
} else {
    $response = ["status" => "error", "message" => "Failed to fetch bookings: " . $stmt->error];
}

echo json_encode($response);

$stmt->close();
$conn->close();
?>







