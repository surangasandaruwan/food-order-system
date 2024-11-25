<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "UserAuth");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch foods from the database
$query = "SELECT * FROM foods";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Store</title>
    <link rel="stylesheet" href="landing.css">
</head>
<body>
    <header>
        <h1>Welcome to the Food Store</h1>
        <nav>
            <a href="cart.php">Cart</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <section class="food-list">
            <h2>Available Foods</h2>
            <div class="food-grid">
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <div class="food-item">
                        <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>">
                        <h3><?php echo $row['name']; ?></h3>
                        <p>Price: $<?php echo $row['price']; ?></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="food_id" value="<?php echo $row['id']; ?>">
                            <input type="number" name="quantity" value="1" min="1" required>
                            <button type="submit">Add to Cart</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Food Store. All rights reserved.</p>
    </footer>
</body>
</html>
