<?php
// Connection to the database
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'javajam';

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data has been submitted (via POST request)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Fetch form data from the POST request
    $orderDetails = json_decode($_POST['orderDetails'], true); // Assuming the details are in JSON format from the form
    
    // Iterate through each item in the order details
    foreach ($orderDetails as $item) {
        // Extract individual details
        $product_name = $conn->real_escape_string($item['product_name']);  // Protect against SQL injection
        $size = $conn->real_escape_string($item['size']);  // Size of the product
        $quantity = intval($item['quantity']);  // Ensure quantity is an integer
        $unit_price = floatval($item['unit_price']);  // Ensure unit price is a float
        $total_price = floatval($item['total_price']);  // Ensure total price is a float
        
        // Prepare SQL statement to insert the order into the orders table
        $sql = "INSERT INTO orders (product_name, size, quantity, unit_price, total_price) 
                VALUES ('$product_name', '$size', $quantity, $unit_price, $total_price)";
        
        // Execute the SQL query
        if ($conn->query($sql) !== TRUE) {
            // In case of an error, display an error message
            echo "Error: " . $sql . "<br>" . $conn->error;
            // Optionally, you could handle errors differently (e.g., redirect back with an error query parameter)
        }
    }
    
    // Redirect back to page-menu.php after successful order submission
    header("Location: page-menu.php?success=1");
    exit(); // Ensure no further code is executed after the redirect
}

// Close the database connection
$conn->close();

