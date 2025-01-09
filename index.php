<?php 
session_start(); 
?>

<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'grocery_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Shopping</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
      
        <div style="display: flex; align-items: center;">
            <img src="images/logo2.jpg" alt="Grocery Logo" style="width: 120px; height: auto; margin-right: 310px; padding-top:20px;">
            <h1 style="color:white;">Welcome to Sahyog Grocery Shopping Services</h1>
        </div>
        
        <?php 
        if (isset($_SESSION['username'])): 
            ?>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! <a href="logout.php">Logout</a></p>
        <?php 
        endif; 
        ?>
        
       
        <nav>
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            <a href="cart.php">Cart</a>
        </nav>
    </header>

    <main>
        <h2>Products</h2>
        <form class="Main" method="POST" action="cart.php">
            <div class="product-list">
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='product'>";
                        echo "<img src='images/" . $row['image'] . "' alt='" . $row['name'] . "'>";
                        echo "<h3>" . $row['name'] . "</h3>";
                        echo "<p>" . $row['description'] . "</p>";
                        echo "<p>Price: " . $row['price'] . " rs</p>";
                        echo "<input type='checkbox' name='products[]' value='" . $row['id'] . "'>";
                        echo "<label for='quantity_" . $row['id'] . "'>Quantity:</label>";
                        echo "<input type='number' id='quantity_" . $row['id'] . "' name='quantities[" . $row['id'] . "]' min='1' value='1'>";
                        echo "</div>";
                    }
                } else {
                    echo "No products available.";
                }
                $conn->close();
                ?>
            </div>
            <h1><button type="submit">Add to Cart</button></h1>
        </form>
    </main>
</body>
</html>
