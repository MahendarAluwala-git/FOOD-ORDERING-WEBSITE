<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    

   
    $conn = new mysqli('localhost', 'root', '', 'grocery_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
    } else {
        echo "Invalid login details";
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
        <h1 style="color:white;">Login</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            <a href="cart.php">Cart</a>
        </nav>
    </header>
    <h2>Login</h2>
    <div class = "login">
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
