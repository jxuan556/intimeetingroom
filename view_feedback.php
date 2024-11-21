<?php
$conn = new mysqli("localhost", "root", "", "meetingroom");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM feedback ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Feedback - INTI University</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                    <li class="nav-item"><a href="admin_manage_bookings.php" class="nav-link">Manage Bookings</a></li>
                    <li class="nav-item"><a href="user_profile2.php" class="nav-link">User</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container my-5 pt-5">
        <h1 class="text-center mb-4">Feedback and Replies</h1>
        
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Message</th>
                    <th>Submitted At</th>
                    <th>Reply</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row["id"]}</td>
                            <td>{$row["message"]}</td>
                            <td>{$row["submitted_at"]}</td>
                            <td>" . (!empty($row["reply"]) ? htmlspecialchars($row["reply"]) : "No reply yet") . "</td>
                            <td>";
                        if (empty($row["reply"])) {
                            echo "<form action='submit_reply.php' method='POST'>
                                    <input type='hidden' name='feedback_id' value='{$row["id"]}'>
                                    <textarea name='reply' class='form-control' required placeholder='Enter reply here'></textarea>
                                    <button type='submit' class='btn btn-primary mt-2'>Send Reply</button>
                                  </form>";
                        } else {
                            echo "<span class='badge badge-secondary'>Reply Sent</span>";
                        }
                        echo "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No feedback available.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer class="text-center py-4">
        <p>Recommended Browser: Google Chrome</p>
        <p>&copy; 2024 INTI International College Penang Library</p>
        <p>Tel: +604-6310138 | Fax: +604-6310193</p>
        <p>&copy; 2024 INTI University - All Rights Reserved</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
