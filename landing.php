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
            <a href="cart.php" class="cart-button">Cart</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <section class="food-list">
            <h2>Available Foods</h2>
            <div class="food-grid">
                <?php
                session_start();
                $conn = new mysqli("localhost", "root", "", "UserAuth");
                $query = "SELECT * FROM foods";
                $result = $conn->query($query);

                while ($row = $result->fetch_assoc()) :
                ?>
                    <div class="food-item">
                        <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>">
                        <h3><?php echo $row['name']; ?></h3>
                        <p>Price: $<?php echo $row['price']; ?></p>
                        <form class="add-to-cart-form">
                            <input type="hidden" name="food_id" value="<?php echo $row['id']; ?>">
                            <input type="number" name="quantity" value="1" min="1" required>
                            <button type="button" class="add-to-cart-button">Add to Cart</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Food Store. All rights reserved.</p>
    </footer>

    <script>
        // Handle Add to Cart button click
        document.querySelectorAll('.add-to-cart-button').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('.add-to-cart-form');
                const formData = new FormData(form);

                fetch('add_to_cart.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message); // Success message
                    } else {
                        alert(data.message); // Error message
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    </script>
</body>
</html>
