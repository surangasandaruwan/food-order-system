<?php
session_start();
$user_id = $_SESSION['user_id'];

$conn = new mysqli("localhost", "root", "", "UserAuth");

// Clear cart after checkout
$query = "DELETE FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Purchase</title>
    <link rel="stylesheet" href="checkout.css">
</head>
<body>
    <div class="thank-you-container">
        <header>
            <h1>Thank You for Your Purchase!</h1>
        </header>
        <main>
            <p>Your order has been successfully processed. We appreciate your business!</p>
            <p>We will notify you with the shipping details shortly.</p>
            <a href="store.php" class="back-btn">Back to Home</a>
        </main>
        <footer>
            <p>&copy; 2024 Food Store. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
