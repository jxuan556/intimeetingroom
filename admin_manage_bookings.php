<?php
$conn = new mysqli("localhost", "root", "", "meetingroom");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM bookings WHERE booking_date >= CURDATE() ORDER BY booking_date, booking_time";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - INTI University</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="img/INTI_Logo.png" alt="INTI University Logo" style="width: 300px; height: auto;">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="admin_dashboard.php" class="nav-link">Admin Dashboard</a></li>
                    <li class="nav-item"><a href="admin_manage_rooms.php" class="nav-link">Manage Rooms</a></li>
                    <li class="nav-item"><a href="view_feedback.php" class="nav-link">View Feedback</a></li>
                    <li class="nav-item"><a href="user_profile2.php" class="nav-link">User</a></li> 
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <h2 class="text-center my-4">Manage Student Bookings</h2>

        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Booking ID</th>
                    <th>Room</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Duration</th>
                    <th>Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['booking_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['room_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['booking_time']); ?></td>
                        <td><?php echo htmlspecialchars($row['duration']); ?> hour(s)</td>
                        <td><?php echo htmlspecialchars($row['notes'] ?: 'N/A'); ?></td>
                        <td>
                            <?php if (empty($row['cancellation_reason'])): ?>
                                <button class="btn btn-danger" onclick="openCancelModal(<?php echo $row['booking_id']; ?>)">Cancel</button>
                            <?php else: ?>
                                <span class="badge badge-secondary">Cancelled</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php $conn->close(); ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel">Cancel Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel this booking?</p>
                    <textarea id="cancellationReason" class="form-control" placeholder="Enter cancellation reason" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" onclick="confirmCancel()">Yes, Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="javascript/manage_booking.js"></script>

    <footer class="text-center py-4">
        <p>Recommended Browser: Google Chrome</p>
        <p>&copy; 2024 INTI International College Penang Library</p>
        <p>Tel: +604-6310138 | Fax: +604-6310193</p>
        <p>&copy; 2024 INTI University - All Rights Reserved</p>
    </footer>
</body>
</html>
