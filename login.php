<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "UserAuth";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to find the user by username
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the hashed password
        if (password_verify($password, $user['password_hash'])) {
            // Login successful, set session variables
            $_SESSION['user_id'] = $user['id'];  // Store user ID in session
            $_SESSION['username'] = $user['username'];  // Store username in session
            header("Location: store.php");  // Redirect to landing.php
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}
?>
