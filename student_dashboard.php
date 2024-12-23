<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - INTI University</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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
                <li class="nav-item"><a href="student_room_details.php" class="nav-link">Room Details</a></li>
                <li class="nav-item"><a href="booking_history.php" class="nav-link">Booking History</a></li>
                <li class="nav-item"><a href="Need_Help.html" class="nav-link">Need Help</a></li>
                <li class="nav-item"><a href="Feedback.html" class="nav-link">Feedback</a></li>
                <li class="nav-item"><a href="view_feedback_reply.php" class="nav-link">Feedback Reply</a></li>
                <li class="nav-item"><a href="Frequently_Asked_Questions.html" class="nav-link">FAQ</a></li>
                <li class="nav-item"><a href="The_Librarians.html" class="nav-link">The Librarians</a></li>
                <li class="nav-item"><a href="user_profile.php" class="nav-link">User</a></li>
            </ul>
        </div>
    </nav>
    <div class="content container mt-5 pt-5">
        <div class="callout">
            <h2>Welcome to INTI University Discussion Room Booking</h2>
            <p>Reserve your discussion room today and make the most of your study time!</p>
            <a href="student_room_details.php" class="btn btn-custom">Reserve Now</a>
        </div>

        <div class="opening-hours section">
            <div class="card">
                <div class="card-body">
                    <h2>Opening Hours</h2>
                    <p>Monday - Friday: 8.00am - 6.00pm</p>
                    <p>Saturdays, Sundays, Public Holidays: Closed</p>
                </div>
            </div>
        </div>

        <div class="rules section">
            <div class="card">
                <div class="card-header">
                    <h2>Discussion Rooms</h2>
                </div>
                <img src="img/discussionroom.png" alt="Discussion Rooms" class="img-fluid">
                <h2>Rules and Regulations</h2>
                <ol>
                    <li>Maximum usage of the room is two hours for each group.</li>
                    <li>Reservations must be made on the day itself.</li>
                    <li>Follow the maximum seating allowed in each room.</li>
                    <li>No sleeping in the discussion rooms.</li>
                    <li>All rooms are monitored by CCTV.</li>
                    <li>Report any issues with library properties immediately.</li>
                    <li>Keep the rooms clean at all times.</li>
                </ol>
            </div>
        </div>

        <div class="features section">
            <h2>Features of Our Discussion Room</h2>
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <h3>Table, Chair, and Whiteboard</h3>
                    <p>Table and chairs suitable for group discussions. Whiteboard with markers and erasers for brainstorming sessions or presentations.</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <h3>Electric Power Source & Wi-Fi</h3>
                    <p>Power outlets for charging laptops and devices. Internet access for online collaboration.</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <h3>Projector & Audio-Visual System</h3>
                    <p>High-quality projector and screen for presentations. Integrated audio-visual system for meetings.</p>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>Recommended Browser: Google Chrome</p>
        <p>Copyright © 2024 INTI International College Penang Library</p>
        <p>Tel: +604-6310138 | Fax: +604-6310193</p>
        <p>&copy; 2024 INTI University - All Rights Reserved</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
