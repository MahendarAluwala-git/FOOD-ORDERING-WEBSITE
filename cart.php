<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['products'])) {
        echo "<script>alert('Please select a product first'); window.location.href='index.php';</script>";
        exit();
    }
    
    $products = $_POST['products'];
    $quantities = $_POST['quantities'];

    foreach ($products as $product_id) {
        $quantity = $quantities[$product_id];
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }
}


$conn = new mysqli('localhost', 'root', '', 'grocery_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_ids = array_keys($_SESSION['cart']);
if (count($product_ids) > 0) {
    $ids = implode(',', $product_ids);
    $sql = "SELECT * FROM products WHERE id IN ($ids)";
    $result = $conn->query($sql);
}

$totalAmount = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1 style="color:white;">Cart</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            <a href="cart.php">Cart</a>
        </nav>
    </header>
    <div class="cart-items">
        <?php
        if (isset($result) && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $quantity = $_SESSION['cart'][$row['id']];
                $itemTotal = $row['price'] * $quantity;
                $totalAmount += $itemTotal; 
                echo "<p>Product: " . $row['name'] . ", Quantity: " . $quantity . ", Price: rs " . $itemTotal . "</p>";
            }
        } else {
            echo "Your cart is empty.";
        }
        ?>
    </div>

    <center>
   
        <h3>Total Amount: rs <?php echo $totalAmount; ?></h3>

        <?php if (count($product_ids) > 0): ?>
            <a href="checkout.php"><button>Checkout</button></a>
        <?php else: ?>
            <button onclick="alert('Your cart is empty! Please add some items before proceeding to checkout.');">Checkout</button>
        <?php endif; ?>
    </center>
    <center><a href="index.php"><button>Go back and shop</button></a></center>
</body>
</html>

<?php $conn->close(); ?>
