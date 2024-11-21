<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "meetingroom");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT email, profile_icon FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $email = $user['email'];
    $profile_icon = $user['profile_icon'] ? $user['profile_icon'] : "default-profile-icon.png";
} else {
    echo "User not found";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['newIcon'])) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["newIcon"]["name"]);

    if ($_FILES["newIcon"]["error"] === UPLOAD_ERR_OK) {
        if (move_uploaded_file($_FILES["newIcon"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("UPDATE users SET profile_icon = ? WHERE id = ?");
            $stmt->bind_param("si", $target_file, $user_id);
            $stmt->execute();
            header("Location: user_profile2.php"); 
            exit();
        } else {
            echo "<p style='color:red;'>Failed to upload image. Check directory permissions.</p>";
        }
    } else {
        echo "<p style='color:red;'>File upload error code: " . $_FILES["newIcon"]["error"] . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <a class="navbar-brand" href="#">
            <img src="img/INTI_Logo.png" alt="INTI University Logo" style="width: 300px; height: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a href="admin_dashboard.php" class="nav-link">Admin Dashboard</a></li>
                <li class="nav-item"><a href="admin_manage_rooms.php" class="nav-link">Manage Rooms</a></li>
                <li class="nav-item"><a href="admin_manage_bookings.php" class="nav-link">Manage Bookings</a></li>
                <li class="nav-item"><a href="view_feedback.php" class="nav-link">View Feedback</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <div class="profile-info text-center mb-4">
            <img id="profileIcon" src="<?php echo htmlspecialchars($profile_icon); ?>" alt="Profile Icon" class="img-fluid rounded-circle" width="150">
            <p>Email: <span id="email"><?php echo htmlspecialchars($email); ?></span></p>
        </div>

        <div id="notification" class="alert alert-success" style="display: none;"></div>

        <div class="container mb-4 text-center">
            <h2 class="mb-4">Update Profile</h2>
            <div class="card mx-auto" style="max-width: 400px;">
                <div class="card-body">
                    <form method="POST" action="user_profile.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="newIcon" class="d-block">New Profile Icon:</label>
                            <input type="file" id="newIcon" name="newIcon" accept="image/*" class="form-control-file">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button class="btn btn-secondary" data-toggle="modal" data-target="#logoutModal">Log Out</button>
        </div>
    </div>

    <footer class="text-center mt-5">
        <p>Recommended Browser: Google Chrome</p>
        <p>Copyright © 2024 INTI International College Penang Library</p>
        <p>Tel: +604-6310138 | Fax: +604-6310193</p>
        <p>&copy; 2024 INTI University - All Rights Reserved</p>
    </footer>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Logout Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to log out?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='logout.php'">Yes, Log Out</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
