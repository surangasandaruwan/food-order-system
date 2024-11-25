<?php
session_start();
$user_id = $_SESSION['user_id'];

$conn = new mysqli("localhost", "root", "", "UserAuth");

// Clear cart after checkout
$query = "DELETE FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();

echo "Thank you for your purchase!";
?>
<a href="landing.php">Back to Home</a>
