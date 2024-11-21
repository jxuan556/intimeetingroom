<?php
$conn = new mysqli("localhost", "root", "", "meetingroom");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM rooms");

while ($room = $result->fetch_assoc()) {
    echo "<div class='col-md-4 mb-4'>
            <div class='card'>
                <img src='{$room['image_path']}' alt='{$room['room_name']}' class='card-img-top'>
                <div class='card-body'>
                    <h5 class='card-title'>{$room['room_name']}</h5>
                    <p class='card-text'>Max {$room['max_users']} users. {$room['rules']}</p>
                    <button class='btn btn-primary btn-block' onclick=\"openBookingModal('{$room['room_name']}')\">Book Now</button>
                </div>
            </div>
          </div>";
}

$conn->close();
?>

