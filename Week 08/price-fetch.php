<?php
ini_set('display_errors', 1); // display any runtime errors
ini_set('display_startup_errors', 1); // display errors that occur during PHP's startup sequence
error_reporting(E_ALL); // sets the error reporting level to display all types of errors

// Print incoming form data (remove after debugging)
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

// Connection to the database
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'javajam';

// Create a new connection 
$db = new mysqli($servername, $username, $password, $dbname);

// Check the connection to the database
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Initialize variables with empty strings to avoid undefined warnings
$justJavaPrice = $cafeAuLaitSinglePrice = $cafeAuLaitDoublePrice = $icedCappuccinoSinglePrice = $icedCappuccinoDoublePrice = '';

// Fetch logic: Retrieve updated prices from the database
$query = "SELECT product_name, endless_price, single_price, double_price FROM products";
$result = $db->query($query);

// Check if the query was successful and if rows were returned
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Assign values based on the product name
        if ($row['product_name'] == 'Just Java') {
            $justJavaPrice = $row['endless_price'];
        } elseif ($row['product_name'] == 'Cafe au Lait') {
            $cafeAuLaitSinglePrice = $row['single_price'];
            $cafeAuLaitDoublePrice = $row['double_price'];
        } elseif ($row['product_name'] == 'Iced Cappuccino') {
            $icedCappuccinoSinglePrice = $row['single_price'];
            $icedCappuccinoDoublePrice = $row['double_price'];
        }
    }
// handle errors
} else {
    echo "Error fetching data: " . $db->error;
}

// Close the database connection after fetching
$db->close();
