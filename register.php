<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "UserAuth";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }

    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $email, $password_hash);

    if ($stmt->execute()) {
        header("Location: login.html");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
