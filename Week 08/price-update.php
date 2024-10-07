<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Print incoming form data (remove after debugging)
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
// Remove the exit after confirming that the form is sending data correctly.
// exit();

// Connection to the database
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'javajam';

// Create a new connection object to the MySQL database using the credentials
$db = new mysqli($servername, $username, $password, $dbname);

// Check the connection to the database
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check if the user has selected to update the price for "Just Java"
if (isset($_POST['justJava'])) {
    $newPrice = $_POST['justJavaPrice'];

    $stmt = $db->prepare("UPDATE products SET endless_price = ? WHERE product_name = 'Just Java'");
    $stmt->bind_param("d", $newPrice);

    if (!$stmt->execute()) {
        echo "Error updating Just Java: " . $stmt->error;
    } else {
        echo "Just Java price updated successfully.";
    }
}

// Check if the user has selected to update the price for "Cafe au Lait"
if (isset($_POST['cafeAuLait'])) {
    // Update single price
    if (isset($_POST['cafeAuLaitSinglePrice'])) {
        $newPriceSingle = $_POST['cafeAuLaitSinglePrice'];
        $stmt = $db->prepare("UPDATE products SET single_price = ? WHERE product_name = 'Cafe au Lait'");
        $stmt->bind_param("d", $newPriceSingle);

        if (!$stmt->execute()) {
            echo "Error updating Cafe au Lait (Single): " . $stmt->error;
        } else {
            echo "Cafe au Lait (Single) price updated successfully.";
        }
    }

    // Update double price
    if (isset($_POST['cafeAuLaitDoublePrice'])) {
        $newPriceDouble = $_POST['cafeAuLaitDoublePrice'];
        $stmt = $db->prepare("UPDATE products SET double_price = ? WHERE product_name = 'Cafe au Lait'");
        $stmt->bind_param("d", $newPriceDouble);

        if (!$stmt->execute()) {
            echo "Error updating Cafe au Lait (Double): " . $stmt->error;
        } else {
            echo "Cafe au Lait (Double) price updated successfully.";
        }
    }
}

// Check if the user has selected to update the price for "Iced Cappuccino"
if (isset($_POST['icedCappuccino'])) {
    // Update single price
    if (isset($_POST['icedCappuccinoSinglePrice'])) {
        $newPriceSingle = $_POST['icedCappuccinoSinglePrice'];
        $stmt = $db->prepare("UPDATE products SET single_price = ? WHERE product_name = 'Iced Cappuccino'");
        $stmt->bind_param("d", $newPriceSingle);

        if (!$stmt->execute()) {
            echo "Error updating Iced Cappuccino (Single): " . $stmt->error;
        } else {
            echo "Iced Cappuccino (Single) price updated successfully.";
        }
    }

    // Update double price
    if (isset($_POST['icedCappuccinoDoublePrice'])) {
        $newPriceDouble = $_POST['icedCappuccinoDoublePrice'];
        $stmt = $db->prepare("UPDATE products SET double_price = ? WHERE product_name = 'Iced Cappuccino'");
        $stmt->bind_param("d", $newPriceDouble);

        if (!$stmt->execute()) {
            echo "Error updating Iced Cappuccino (Double): " . $stmt->error;
        } else {
            echo "Iced Cappuccino (Double) price updated successfully.";
        }
    }
}

// Close the database connection after all updates have been processed
$db->close();

// Redirect the user back to the admin price update page after successful execution
header("Location: page-price-update.php");
exit();
