<?php
session_start();
$conn = new mysqli("localhost", "root", "", "meetingroom");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM rooms WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$room = $result->fetch_assoc();

if ($room) {
    echo json_encode($room);
} else {
    echo json_encode(['error' => 'Room not found']);
}

$conn->close();
?>



