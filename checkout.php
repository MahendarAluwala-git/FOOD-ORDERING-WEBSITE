<?php
session_start();
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<p>Your cart is empty.</p>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $payment_method = $_POST['payment_method'];

  
    $conn = new mysqli('localhost', 'root', '', 'grocery_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO orders (name, address, phone, payment_method) 
            VALUES ('$name', '$address', '$phone', '$payment_method')";

    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id; 

        
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $sql = "INSERT INTO order_items (order_id, product_id, quantity) 
                    VALUES ('$order_id', '$product_id', '$quantity')";
            $conn->query($sql);
        }

      
        $_SESSION['cart'] = array();
        header("Location: order_confirmation.php?order_id=$order_id");
        exit();
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1 style="color:white;">Checkout</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            <a href="cart.php">Cart</a>
        </nav>
    </header><br>
    <h2>Enter Your Details</h2>
    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="address">Shipping Address:</label>
        <input type="text" id="address" name="address" required>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="payment_method">Payment Method:</label>
        <select id="payment_method" name="payment_method" required>
            <option value="Cash on Delivery">Cash on Delivery</option>
            <option value="PayPal">PayPal</option>
            <option value="Credit Card">Credit Card</option>
            <option value="Debit Card">Debit Card</option>
        </select>

        <button type="submit">Submit Order</button>
    </form>
</body>
</html>
