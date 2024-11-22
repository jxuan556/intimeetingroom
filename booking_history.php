<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<p>You need to log in to view your booking history.</p>";
    exit();
}

$conn = new mysqli("localhost", "root", "", "meetingroom");
if ($conn->connect_error) {
    die("<p>Database connection failed: " . $conn->connect_error . "</p>");
}

$userId = $_SESSION['user_id'];
$currentDateTime = new DateTime();

$query = "SELECT * FROM bookings WHERE user_id = ? ORDER BY booking_date, booking_time";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$upcomingBookings = [];
$pastBookings = [];
$canceledBookings = [];

while ($row = $result->fetch_assoc()) {
    $bookingDateTime = new DateTime("{$row['booking_date']} {$row['booking_time']}");
    
    if ($bookingDateTime < $currentDateTime || !empty($row['cancellation_reason'])) {
        $pastBookings[] = $row;
        if (!empty($row['cancellation_reason'])) {
            $canceledBookings[] = $row;
        }
    } else {
        $upcomingBookings[] = $row;
    }
}

$stmt->close();
$conn->close();

$showNotification = !empty($canceledBookings) && !isset($_SESSION['notification_shown']);
if ($showNotification) {
    $_SESSION['notification_shown'] = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <a class="navbar-brand" href="#">
        <img src="img/INTI_Logo.png" alt="INTI University Logo" style="width: 300px; height: auto;">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item"><a href="student_dashboard.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="student_room_details.php" class="nav-link">Room Details</a></li>
            <li class="nav-item"><a href="Need_Help.html" class="nav-link">Need Help</a></li>
            <li class="nav-item"><a href="Feedback.html" class="nav-link">Feedback</a></li>
            <li class="nav-item"><a href="view_feedback_reply.php" class="nav-link">Feedback Reply</a></li>
            <li class="nav-item"><a href="Frequently_Asked_Questions.html" class="nav-link">FAQ</a></li>
            <li class="nav-item"><a href="The_Librarians.html" class="nav-link">The Librarians</a></li>
            <li class="nav-item"><a href="user_profile.php" class="nav-link">User</a></li>
        </ul>
    </div>
</nav>

<div class="container mt-5 pt-5">
    <h3 class="text-center mb-4">Booking History</h3>

    <?php if ($showNotification): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Some of your bookings have been canceled by the admin. Please check your booking history.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <h4 class="text-center">Upcoming Bookings</h4>
    <table class="table table-striped table-bordered text-center">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Room</th>
                <th>Duration</th>
                <th>Notes</th>
                <th>Cancel</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($upcomingBookings as $booking): ?>
                <tr>
                    <td><?= htmlspecialchars($booking['booking_date']); ?></td>
                    <td><?= htmlspecialchars($booking['booking_time']); ?></td>
                    <td><?= htmlspecialchars($booking['room_name']); ?></td>
                    <td><?= htmlspecialchars($booking['duration']); ?> hour(s)</td>
                    <td><?= htmlspecialchars($booking['notes'] ?: 'N/A'); ?></td>
                    <td>
                        <button class="btn btn-danger" onclick="cancelBooking(<?= $booking['booking_id']; ?>)">Cancel</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h4 class="text-center mt-5">Past Bookings</h4>
    <table class="table table-striped table-bordered text-center">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Room</th>
                <th>Duration</th>
                <th>Notes</th>
                <th>Cancellation Reason</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pastBookings as $booking): ?>
                <tr>
                    <td><?= htmlspecialchars($booking['booking_date']); ?></td>
                    <td><?= htmlspecialchars($booking['booking_time']); ?></td>
                    <td><?= htmlspecialchars($booking['room_name']); ?></td>
                    <td><?= htmlspecialchars($booking['duration']); ?> hour(s)</td>
                    <td><?= htmlspecialchars($booking['notes'] ?: 'N/A'); ?></td>
                    <td><?= htmlspecialchars($booking['cancellation_reason'] ?: 'N/A'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="javascript/Booking_History_script.js"></script>

<footer>
    <p>Recommended Browser: Google Chrome</p>
    <p>&copy; 2024 INTI International College Penang Library</p>
    <p>Tel: +604-6310138 | Fax: +604-6310193</p>
    <p>&copy; 2024 INTI University - All Rights Reserved</p>
</footer>
</body>
</html>




