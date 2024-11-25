<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
    $food_id = $_POST['food_id'];
    $quantity = $_POST['quantity'];

    $conn = new mysqli("localhost", "root", "", "UserAuth");

    // Add item to cart
    $query = "INSERT INTO cart (user_id, food_id, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $user_id, $food_id, $quantity);
    $stmt->execute();

    header("Location: cart.php");
    exit();
}
?>
