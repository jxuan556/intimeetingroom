<?php
$conn = new mysqli("localhost", "root", "", "meetingroom");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM rooms WHERE id=$id";
    $result = $conn->query($sql);
    $room = $result->fetch_assoc();
}

if (isset($_POST['update_room'])) {
    $room_name = $_POST['room_name'];
    $max_users = $_POST['max_users'];
    $rules = $_POST['rules'];

    if ($_FILES['image']['name']) {
        $image_path = 'images/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    } else {
        $image_path = $room['image_path'];
    }

    $sql = "UPDATE rooms SET room_name='$room_name', max_users=$max_users, rules='$rules', image_path='$image_path' WHERE id=$id";
    $conn->query($sql);
    header("Location: admin_manage_rooms.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room - INTI University</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mt-5">Edit Room</h1>

        <div class="card mt-4 card-custom">
            <div class="card-header bg-transparent text-white">
                Edit Room Details
            </div>
            <div class="card-body">
                <form action="edit_room.php?id=<?php echo $room['id']; ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="room_name">Room Name</label>
                        <input type="text" name="room_name" class="form-control" value="<?php echo $room['room_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="max_users">Max Users</label>
                        <input type="number" name="max_users" class="form-control" value="<?php echo $room['max_users']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="rules">Rules</label>
                        <textarea name="rules" class="form-control" required><?php echo $room['rules']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Room Image</label>
                        <input type="file" name="image" class="form-control-file">
                        <br>
                        <img src="<?php echo $room['image_path']; ?>" alt="Room Image" width="150" class="img-thumbnail mt-3">
                    </div>
                    <button type="submit" name="update_room" class="btn btn-custom mt-3">Update Room</button>
                    <a href="admin_manage_rooms.php" class="btn btn-outline-custom mt-3">Back to Manage Rooms</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

