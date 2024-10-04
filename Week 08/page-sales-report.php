<?php
// Connection to the database
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'javajam';

// Create connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to find all products with the highest total quantity sold
$sql = "SELECT product_name, size, SUM(quantity) AS total_quantity
        FROM orders
        GROUP BY product_name, size
        HAVING total_quantity = (
            SELECT MAX(total_quantity)
            FROM (SELECT SUM(quantity) AS total_quantity FROM orders GROUP BY product_name, size) AS subquery
        )
        ORDER BY total_quantity DESC";

$result = $conn->query($sql);

// Initialize arrays for sizes and product names
$mostPopularSizes = [];
$mostPopularDrinks = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Store size and product name separately
        $mostPopularSizes[] = $row['size'];
        $mostPopularDrinks[] = $row['product_name'];
    }
} else {
    $mostPopularSizes[] = 'No size data available';
    $mostPopularDrinks[] = 'No product data available';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JavaJam Coffee House - Sales Report</title>
    <link rel="stylesheet" href="styles.css">
    <script src="sales-report.js" defer></script>
</head>
<body>
    <div class="container">
        <header>
            <img src="images/javajam-all-javalogo.png" alt="JavaJam Coffee House" class="logo">
        </header>

        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="page-menu.php">Menu</a></li>
                <li><a href="page-music.html">Music</a></li>
                <li><a href="page-jobs.html">Jobs</a></li>
                <li><a href="page-price-update.php">Product Price Update</a></li>
                <li><a href="page-sales-report.php">Sales Report</a></li>
            </ul>
        </nav>

        <div class="main-content">
            <h2>Daily Sales Report</h2>

            <p>Click to generate daily sales report:</p>

            <!-- Button 1: Total dollar and quantity sales by products -->
            <button id="salesByProducts" class="report-button">Generate Sales Report - <strong>by Products</strong></button>

            <!-- Button 2: Total dollar and quantity sales by categories -->
            <button id="salesByCategories" class="report-button">Generate Sales Report - <strong>by Categories</strong></button>

            <!-- Display the most popular option and best-selling product -->
            <p>Most popular product(s):</p>
            
            <!-- Add message if more than one product is shown -->
            <?php if (count($mostPopularSizes) > 1) { ?>
                <p><em>More than one product is being displayed because they have the same quantity sold.</em></p>
            <?php } ?>

            <div id="bestSellingProduct">
                <?php
                // Loop through sizes and products to display each pair
                for ($i = 0; $i < count($mostPopularSizes); $i++) {
                    echo '<div class="product-line">';
                    echo '<strong><span class="size-blue">' . htmlspecialchars($mostPopularSizes[$i]) . '</span></strong> of ';
                    echo '<strong><span class="product-red">' . htmlspecialchars($mostPopularDrinks[$i]) . '</span></strong>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>

        <footer>
            <p>Copyright &copy; 2014 JavaJam Coffee House<br>
                <a href="mailto:abig005@e.ntu.edu.sg">Abigail@Lim.com</a>
            </p>
        </footer>
    </div>
</body>
</html>
