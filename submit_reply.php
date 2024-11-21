<?php
$conn = new mysqli("localhost", "root", "", "meetingroom");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback_id = intval($_POST['feedback_id']);
    $reply = $conn->real_escape_string($_POST['reply']);

    $sql = "UPDATE feedback SET reply='$reply' WHERE id=$feedback_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Reply sent successfully!');
            window.location.href = 'view_feedback.php';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
