<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - INTI University</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <a class="navbar-brand" href="#">
            <img src="img/INTI_Logo.png" alt="INTI University Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <section class="welcome-section">
        <div class="container">
            <img src="https://studypenang.gov.my/wp-content/uploads/2019/04/new.png" alt="INTI University" class="img-fluid mb-4">
            <h1>Welcome, Admin</h1>
            <p>to the INTI Meeting Room Management Dashboard</p>
        </div>
    </section>
    <div class="container dashboard-content">
        <div class="row text-center mt-5">
            <div class="col-md-4 mb-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <h5 class="card-title">Manage Rooms</h5>
                        <p class="card-text">Add, edit, and delete meeting rooms for reservation.</p>
                        <a href="admin_manage_rooms.php" class="btn btn-custom">Go to Rooms</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <h5 class="card-title">Manage Bookings</h5>
                        <p class="card-text">Manage student's bookings for accidentally uses.</p>
                        <a href="admin_manage_bookings.php" class="btn btn-custom">Go to Bookings</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <h5 class="card-title">View Feedback</h5>
                        <p class="card-text">Review feedback and comments from users.</p>
                        <a href="view_feedback.php" class="btn btn-custom">Go to Feedback</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <h5 class="card-title">User Profiles</h5>
                        <p class="card-text">Manage and view user profile information.</p>
                        <a href="user_profile2.php" class="btn btn-custom">Go to Users</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <footer class="text-center py-4">
        <p>Recommended Browser: Google Chrome</p>
        <p>&copy; 2024 INTI International College Penang Library</p>
        <p>Tel: +604-6310138 | Fax: +604-6310193</p>
        <p>&copy; 2024 INTI University - All Rights Reserved</p>
    </footer>
</body>
</html>
