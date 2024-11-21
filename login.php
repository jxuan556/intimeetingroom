<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "meetingroom");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } elseif ($user['role'] === 'student') {
                header("Location: student_dashboard.php");
                exit();
            }
        } else {
            echo "<p style='color:red; text-align:center;'>Incorrect password. Please try again.</p>";
        }
    } else {
        echo "<p style='color:red; text-align:center;'>No user found with that email.</p>";
    }
    $stmt->close();
}
$conn->close();
?>
