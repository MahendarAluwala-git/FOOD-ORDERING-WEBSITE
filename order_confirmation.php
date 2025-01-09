<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'grocery_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$order_id = $_GET['order_id'];
$sql = "SELECT * FROM orders WHERE id = '$order_id'";
$result = $conn->query($sql);
$order = $result->fetch_assoc();


$sql_items = "SELECT oi.quantity, p.name, p.price 
              FROM order_items oi 
              JOIN products p ON oi.product_id = p.id 
              WHERE oi.order_id = '$order_id'";
$result_items = $conn->query($sql_items);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1 style="color:white;">Order Confirmation</h1>
        <nav>
            <a href="index.php">Home</a>
        </nav>
    </header>

    <main><center>
        <h2>Thank you for your order, <?php echo htmlspecialchars($order['name']); ?>!</h2>
        <p>Your grocery items will be delivered to:</p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
        <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>

        <h3>Order Details:</h3>
        <ul>
            <?php while($item = $result_items->fetch_assoc()): ?>
                <li>
                    <?php echo htmlspecialchars($item['name']); ?> 
                    Quantity: <?php echo $item['quantity']; ?>
                    Total Price: <?php echo $item['quantity'] * $item['price']; ?> rs
                </li>
            <?php endwhile; ?>
        </ul>

        <p><strong>Your order is confirmed and will be delivered soon!</strong></p>
        <center><a href="index.php"><button>Back to Shop</button></a></center>
        </center>
    </main>
</body>
</html>
