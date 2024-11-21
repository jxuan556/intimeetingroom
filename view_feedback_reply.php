<?php
$conn = new mysqli("localhost", "root", "", "meetingroom");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM feedback WHERE reply IS NOT NULL ORDER BY submitted_at DESC";
$result = $conn->query($sql);
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
            <li class="nav-item"><a href="student_dashboard.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="student_room_details.php" class="nav-link">Room Details</a></li>
                <li class="nav-item"><a href="booking_history.php" class="nav-link">Booking History</a></li>
                <li class="nav-item"><a href="Need_Help.html" class="nav-link">Need Help</a></li>
                <li class="nav-item"><a href="Feedback.html" class="nav-link">Feedback</a></li>
                <li class="nav-item"><a href="Frequently_Asked_Questions.html" class="nav-link">FAQ</a></li>
                <li class="nav-item"><a href="The_Librarians.html" class="nav-link">The Librarians</a></li>
                <li class="nav-item"><a href="user_profile.php" class="nav-link">User</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container my-5 pt-5">
        <h1 class="text-center mb-4">Feedback Replies</h1>
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>Feedback Message</th>
                    <th>Admin Reply</th>
                    <th>Submitted At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row["message"]}</td>
                            <td>{$row["reply"]}</td>
                            <td>{$row["submitted_at"]}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No feedback replies available.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>Recommended Browser: Google Chrome</p>
        <p>Copyright © 2024 INTI International College Penang Library</p>
        <p>Tel: +604-6310138 | Fax: +604-6310193</p>
        <p>&copy; 2024 INTI University - All Rights Reserved</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
