# FOOD-ORDERING-WEBSITE

This PHP project is a grocery shopping website where users can view products, register, log in, add products to their cart, and proceed to checkout. I'll explain each page in detail, covering the HTML, PHP, and database interactions.

### 1. **index.php** (Homepage)

#### Functionality:
- Displays a list of products available in the database.
- Allows users to select products and add them to the cart.

#### Breakdown:

1. **Database Connection**:
   ```php
   $conn = new mysqli('localhost', 'root', '', 'grocery_db');
   ```
   - Connects to the MySQL database `grocery_db` using `mysqli`.
   - If the connection fails, an error message is displayed.

2. **Fetching Products**:
   ```php
   $sql = "SELECT * FROM products";
   $result = $conn->query($sql);
   ```
   - Retrieves all products from the `products` table.

3. **HTML Structure**:
   - The page contains a header with navigation links to Home, Login, Register, and Cart.
   - Displays a list of products using a `while` loop to iterate through the fetched results.
   - Each product displays:
     - Image, name, description, price
     - Checkbox to select the product
     - Input field to set the quantity.

4. **Form Submission**:
   ```html
   <form method="POST" action="cart.php">
   ```
   - When the "Add to Cart" button is clicked, the form submits the selected product IDs and quantities to `cart.php`.

### 2. **register.php** (Registration Page)

#### Functionality:
- Allows new users to register by providing a username and password.

#### Breakdown:

1. **HTML Form**:
   - The form collects `username` and `password`.
   - Uses `POST` method to send the data back to `register.php`.

2. **Processing Registration**:
   ```php
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       $username = $_POST['username'];
       $password = $_POST['password'];
   }
   ```
   - Checks if the form is submitted via POST.
   - Inserts the new user’s data into the `users` table using:
     ```php
     $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
     ```
   - Displays a success or error message based on whether the insertion was successful.

### 3. **login.php** (Login Page)

#### Functionality:
- Allows existing users to log in with their credentials.

#### Breakdown:

1. **Session Management**:
   ```php
   session_start();
   ```
   - Starts a session, enabling user login persistence across pages.

2. **HTML Form**:
   - Collects `username` and `password`.
   - Submits data using POST method.

3. **Authentication**:
   - Checks user credentials in the `users` table:
     ```php
     $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
     ```
   - If credentials match, the username is stored in the session, and the user is redirected to `index.php`.
   - Displays an error message for incorrect credentials.

### 4. **cart.php** (Cart Page)

#### Functionality:
- Displays products that the user added to the cart.
- Allows the user to proceed to checkout.

#### Breakdown:

1. **Session Management**:
   - Starts a session and initializes the `cart` session array if it doesn't exist.

2. **Handling Form Submission**:
   - When a user adds products from `index.php`, this page updates the cart with selected products and quantities:
     ```php
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $products = $_POST['products'];
         $quantities = $_POST['quantities'];
     }
     ```
   - Stores product IDs as keys and their quantities as values in the `$_SESSION['cart']` array.

3. **Displaying Cart Items**:
   - Retrieves selected product details from the `products` table:
     ```php
     $sql = "SELECT * FROM products WHERE id IN ($ids)";
     ```
   - Displays the product name, quantity, and total price for each item in the cart.

4. **Checkout and Navigation**:
   - Provides a "Checkout" button linking to `checkout.php` and a "Go back and shop" button to return to `index.php`.

### 5. **checkout.php** (Checkout Page)

#### Functionality:
- Displays a summary of items in the cart, acting as the final step before completing the purchase.

#### Breakdown:

1. **Session Handling**:
   - The session array `$_SESSION['cart']` is used to manage cart contents.

2. **Product Information**:
   - Uses the same logic as `cart.php` to display the cart items:
     ```php
     $sql = "SELECT * FROM products WHERE id IN ($ids)";
     ```
   - Shows the total price and quantity for each product.

3. **Checkout Option**:
   - Contains "Checkout" and "Go back and shop" buttons, although the checkout process is not fully implemented in this code.

### Additional Notes:

- **Database**:
  - `grocery_db` database has at least two tables: `products` and `users`.
    - `products`: Stores product details such as `id`, `name`, `description`, `price`, and `image`.
    - `users`: Stores user registration details (`username` and `password`).

- **Security Issues**:
  - The code is vulnerable to SQL injection because it directly inserts user inputs into SQL queries. Use prepared statements to mitigate this risk.
  - Passwords are stored in plain text, which is a security risk. Hash passwords using `password_hash()` and verify with `password_verify()`.

- **Styling**:
  - The website uses a `styles.css` file for styling, but details of this file are not provided.

### How It Works Together

1. Users visit `index.php` to browse products.
2. They register via `register.php` or log in using `login.php`.
3. Authenticated users add products to their cart.
4. The cart's contents are managed via `cart.php`.
5. Users proceed to checkout on `checkout.php`.

This is a functional grocery shopping website with basic features, demonstrating user authentication, product listing, and a simple cart system. Further improvements can include implementing payment integration, password security, and enhanced error handling.

It looks like you shared your CSS file for the grocery shopping website, which helps define the styling for various elements of your webpage. Let's go through the main parts of this CSS and explain how they contribute to the appearance and behavior of your site.

### Overview of the CSS Styles

#### 1. **Global Styles (`body`)**
   ```css
   body {
       font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
       background-color: #f4f4f4;
       color: #333;
       margin: 0;
       padding: 0;
   }
   ```
   - This sets a uniform font and background color for the entire webpage.
   - It removes any default margin or padding that might be added by the browser.

#### 2. **Header Styling (`header` and `nav a`)**
   ```css
   header {
       background-color: #ff6347;
       color: white;
       padding: 1rem;
       text-align: center;
       box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
   }
   
   nav a {
       margin: 0 1rem;
       color: white;
       text-decoration: none;
       transition: color 0.3s ease;
   }
   
   nav a:hover {
       color: #ffcccb;
   }
   ```
   - The `header` section has a red background with white text and a slight shadow to make it stand out.
   - The `nav a` styles define how the links in the navigation menu look and how they change color when hovered over.

#### 3. **Headings (`h1` and `h2`)**
   ```css
   h1, h2 {
       color: #ff6347;
       text-align: center;
   }
   ```
   - Both `h1` and `h2` elements are given the same red color (#ff6347) and centered alignment, making them prominent on the page.

#### 4. **Product List (`.product-list` and `.product-list div`)**
   ```css
   .product-list {
       display: flex;
       flex-wrap: wrap;
       justify-content: space-around;
       padding: 2rem;
   }
   
   .product-list div {
       background-color: #fff;
       border: 1px solid #ddd;
       margin: 1rem;
       padding: 1rem;
       width: 200px;
       text-align: center;
       box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
       transition: transform 0.3s ease, box-shadow 0.3s ease;
   }
   
   .product-list div:hover {
       transform: translateY(-10px);
       box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
   }
   ```
   - The product list container (`.product-list`) is designed as a flexible container that wraps its items and evenly spaces them.
   - Individual product items have a card-like appearance with subtle hover effects to make them interactive.

#### 5. **Product Images (`.product-list img`)**
   ```css
   .product-list img {
       width: 100%;
       height: auto;
       object-fit: cover;
       border-radius: 8px;
       box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
       transition: transform 0.3s ease, box-shadow 0.3s ease;
   }
   ```
   - Product images are styled to fit their containers with a smooth transition effect, giving them a polished look.

#### 6. **Button Styling (`button`)**
   ```css
   button {
       background-color: #ff6347;
       color: white;
       border: none;
       padding: 0.5rem 1rem;
       cursor: pointer;
       transition: background-color 0.3s ease;
       margin-top: 1rem;
       display: block;
   }
   
   button:hover {
       background-color: #ff4500;
   }
   ```
   - Buttons are given a vibrant red color with white text. When hovered, they change to a darker red, providing a clear visual feedback.

#### 7. **Form Styling (`form`, `form label`, `form input`)**
   ```css
   form {
       display: flex;
       flex-direction: column;
       align-items: center;
       padding: 2rem;
   }
   
   form label {
       margin: 0.5rem 0;
   }
   
   form input {
       padding: 0.2rem;
       margin: 0.5rem 0;
       border: 1px solid #ddd;
       border-radius: 4px;
       width: 100%;
       max-width: 300px;
   }
   ```
   - The form layout is vertically aligned with a simple and clean style.

#### 8. **Cart and Checkout Items (`.cart-items`, `.checkout-items`, `.cart-items p`, `.checkout-items p`)**
   ```css
   .cart-items, .checkout-items {
       display: flex;
       flex-direction: column;
       align-items: center;
       padding: 2rem;
   }
   
   .cart-items p, .checkout-items p {
       background-color: #fff;
       border: 1px solid #ddd;
       padding: 1rem;
       margin: 0.5rem 0;
       width: 100%;
       max-width: 500px;
       text-align: left;
       box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
   }
   ```
   - These classes style the cart and checkout item containers, ensuring that each item has its own card-like appearance.

#### 9. **Footer Styling (`footer`)**
   ```css
   footer {
       background-color: #333;
       color: white;
       text-align: center;
       padding: 0.5rem;
       position: fixed;
       width: 100%;
       bottom: 0;
   }
   ```
   - The footer is styled to stick to the bottom of the page, with white text on a dark background.

### Conclusion
- This CSS gives your grocery shopping website a modern, responsive, and user-friendly appearance.
- The layout is designed to be clean and visually appealing, making good use of hover effects, shadows, and transitions.

If you'd like further customization or explanations about any specific part, feel free to ask!
