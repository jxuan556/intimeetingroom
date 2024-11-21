<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "meetingroom");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$image_directory = __DIR__ . '/images/';
if (!is_dir($image_directory)) {
    mkdir($image_directory, 0777, true);  
}

if (isset($_POST['add_room'])) {
    $room_name = $_POST['room_name'];
    $max_users = $_POST['max_users'];
    $rules = $_POST['rules'];
    $image_path = 'images/' . basename($_FILES['image']['name']);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $image_directory . basename($_FILES['image']['name']))) {
        $sql = "INSERT INTO rooms (room_name, max_users, rules, image_path) VALUES ('$room_name', $max_users, '$rules', '$image_path')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<p style='color: green;'>New room added successfully!</p>";
            header("Location: admin_manage_rooms.php");
            exit();
        } else {
            echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Failed to upload image. Please check the file permissions.</p>";
    }
}

if (isset($_POST['delete_room'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM rooms WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Room deleted successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error deleting room: " . $conn->error . "</p>";
    }
    header("Location: admin_manage_rooms.php");
    exit();
}
$rooms = $conn->query("SELECT * FROM rooms");
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
    <script>
        function confirmDelete(roomName) {
            return confirm("Are you sure you want to delete " + roomName + "?");
        }
    </script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <a class="navbar-brand" href="#">
            <img src="img/INTI_Logo.png" alt="INTI University Logo" style="width: 300px; height: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a href="admin_dashboard.php" class="nav-link">Admin Dashboard</a></li>
                <li class="nav-item"><a href="admin_manage_bookings.php" class="nav-link">Manage Bookings</a></li>
                <li class="nav-item"><a href="view_feedback.php" class="nav-link">View Feedback</a></li>
                <li class="nav-item"><a href="user_profile2.php" class="nav-link">User</a></li> 
            </ul>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <h1 class="text-center mt-4">Manage Rooms</h1>

        <div class="card mt-4 mb-5">
            <div class="card-header">Add New Room</div>
            <div class="card-body">
                <form action="admin_manage_rooms.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="room_name">Room Name</label>
                        <input type="text" name="room_name" class="form-control" placeholder="Room Name" required>
                    </div>
                    <div class="form-group">
                        <label for="max_users">Max Users</label>
                        <input type="number" name="max_users" class="form-control" placeholder="Max Users" required>
                    </div>
                    <div class="form-group">
                        <label for="rules">Rules</label>
                        <textarea name="rules" class="form-control" placeholder="Enter room rules" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="form-control-file" required>
                    </div>
                    <button type="submit" name="add_room" class="btn btn-custom mt-3">Add Room</button>
                </form>
            </div>
        </div>

        <h2 class="text-center mb-3">Existing Rooms</h2>
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Room Name</th>
                    <th>Max Users</th>
                    <th>Rules</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($room = $rooms->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $room['id']; ?></td>
                        <td><?php echo $room['room_name']; ?></td>
                        <td><?php echo $room['max_users']; ?></td>
                        <td><?php echo $room['rules']; ?></td>
                        <td><img src="<?php echo $room['image_path']; ?>" alt="Room Image" width="50"></td>
                        <td>
                            <form action="edit_room.php?id=<?php echo $room['id']; ?>" method="POST" style="display:inline;">
                                <button type="submit" class="btn btn-sm btn-custom">Edit</button>
                            </form>
                            <form action="admin_manage_rooms.php" method="POST" style="display:inline;" onsubmit="return confirmDelete('<?php echo $room['room_name']; ?>')">
                                <input type="hidden" name="id" value="<?php echo $room['id']; ?>">
                                <button type="submit" name="delete_room" class="btn btn-sm btn-outline-custom">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
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

<?php $conn->close(); ?>

