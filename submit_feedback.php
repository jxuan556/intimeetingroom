<?php
 $conn = new mysqli("localhost", "root", "", "meetingroom");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO feedback (message) VALUES ('$message')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Feedback submitted successfully!');
            window.location.href = 'Feedback.html';  // Redirect to feedback page
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
