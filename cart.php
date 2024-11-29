<?php
session_start();
$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

$conn = new mysqli("localhost", "root", "", "UserAuth");

// Fetch cart items for the user
$query = "
    SELECT c.id, f.name, f.price, c.quantity, (f.price * c.quantity) AS total
    FROM cart c
    JOIN foods f ON c.food_id = f.id
    WHERE c.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <header>
        <h1>Your Cart</h1>
        <nav>
            <a href="store.php">Home</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <section>
            <h2>Cart Items</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td>$<?php echo $row['price']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td>$<?php echo $row['total']; ?></td>
                            <td>
                                <form action="remove_from_cart.php" method="POST">
                                    <input type="hidden" name="cart_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <a href="checkout.php">Checkout</a>
        </section>
    </main>
</body>
</html>
