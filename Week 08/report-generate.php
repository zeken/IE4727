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
// The above block establishes a connection to the MySQL database using the given credentials.
// If the connection fails, the script stops and prints the error message.

// Determine the type of report based on URL parameter (either 'product' or 'category')
$type = $_GET['type'] ?? '';
// The $type variable retrieves the value from the URL's query string (e.g., ?type=product or ?type=category).
// The null coalescing operator '??' ensures $type is an empty string if 'type' is not passed in the URL.

// Initialize arrays to store the interpretation data for products and categories
$interpretationData = [];
$categoryData = [];
// These arrays will hold the sales data for products and categories, which will be used for detailed interpretations later.

// If the report is by product, calculate sales grouped by product and size
if ($type === 'product') {
    // SQL query to group the sales by product (without the size), summing the total price and quantity for each product
    $sql = "SELECT product_name, SUM(total_price) AS total_sales, SUM(quantity) AS total_quantity 
            FROM orders 
            GROUP BY product_name
            ORDER BY product_name ASC";  // Removed size grouping for the product report
}
// This block checks if the report type is 'product'. If so, it runs a SQL query that groups sales by 'product_name'.
// The query sums up the 'total_price' and 'quantity' for each product and orders them alphabetically by product name.

// If the report is by category (size), calculate sales grouped by size only
elseif ($type === 'category') {
    // SQL query to group by size (Single, Double, etc.), summing the total sales and quantities
    $sql = "SELECT size, SUM(total_price) AS total_sales, SUM(quantity) AS total_quantity 
            FROM orders 
            GROUP BY size
            ORDER BY total_sales DESC";
}
// This block checks if the report type is 'category'. If so, it runs a SQL query that groups sales by 'size'.
// The query sums the 'total_price' and 'quantity' for each size and orders the results by total sales (highest first).

// Execute the SQL query and fetch the result
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <?php
    // Change the title based on the report type
    if ($type === 'product') {
        echo "<title>JavaJam Coffee House - Sales Report by Products</title>";
    } elseif ($type === 'category') {
        echo "<title>JavaJam Coffee House - Sales Report by Categories</title>";
    }
    // Dynamically setting the <title> of the HTML page based on whether the report is for products or categories.
    ?>
    <link rel='stylesheet' href='styles.css'>
</head>
<body>
    <div class='container'>
        <!-- Header and navigation -->
        <header>
            <img src='images/javajam-all-javalogo.png' alt='JavaJam Coffee House' class='logo'>
        </header>
        <nav>
            <ul>
                <li><a href='index.html'>Home</a></li>
                <li><a href='page-menu.php'>Menu</a></li>
                <li><a href='page-music.html'>Music</a></li>
                <li><a href='page-jobs.html'>Jobs</a></li>
                <li><a href='page-price-update.php'>Product Price Update</a></li>
                <li><a href='page-sales-report.php'>Sales Report</a></li>
            </ul>
        </nav>

        <div class='main-content'>
            <?php
            // Change the heading based on the report type
            if ($type === 'product') {
                echo "<h2>Sales Report - By Products</h2>";
            } elseif ($type === 'category') {
                echo "<h2>Sales Report - By Categories</h2>";
            }
            // Dynamically changing the heading based on the report type (either 'by products' or 'by categories').
            
            // Check if the query returned any results
            if ($result->num_rows > 0) {
                // Table for displaying sales by product (without the size column)
                if ($type === 'product') {
                    echo "<table border='1' cellpadding='10' cellspacing='0'>";
                    echo "<tr>
                            <th>Product</th>
                            <th>Total Dollar Sales ($)</th>
                            <th>Quantity Sales</th>
                          </tr>";
                    // If the report is 'by product', generate a table with columns for Product, Total Sales, and Quantity Sold.
            
                    // Loop through the result set and display each row in the table
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['product_name']}</td>
                                <td>" . number_format($row['total_sales'], 2) . "</td>
                                <td>{$row['total_quantity']}</td>
                              </tr>";
                        // Loop through each row of the result and output the product name, total sales, and quantity sold.
                        // number_format() is used to format the total sales as a number with two decimal places.
            
                        // Store the data for interpretation breakdown dynamically (to later display by size)
                        $interpretationData[$row['product_name']] = [
                            'total_quantity' => $row['total_quantity'],
                            'total_sales' => $row['total_sales'] // Store as a numeric value
                        ];
                    }
                    echo "</table>";
                    // Close the HTML table tag.
            
                    // Display detailed interpretation dynamically based on the actual data
                    echo "<p><strong>Detailed Interpretation of Products by Size</strong></p>";

                    // Dynamically generate interpretation for each product by sizes (e.g., Single, Double)
                    $productSizeSql = "SELECT product_name, size, SUM(total_price) AS total_sales, SUM(quantity) AS total_quantity 
                                       FROM orders 
                                       GROUP BY product_name, size
                                       ORDER BY product_name ASC, size ASC";
                    $sizeResult = $conn->query($productSizeSql);
                    // This SQL query groups the data by both product name and size, so we can display breakdowns by size for each product.
            
                    if ($sizeResult->num_rows > 0) {
                        $sizeInterpretationData = [];
                        while ($sizeRow = $sizeResult->fetch_assoc()) {
                            // Group data by product name and size
                            $sizeInterpretationData[$sizeRow['product_name']][$sizeRow['size']] = [
                                'quantity' => $sizeRow['total_quantity'],
                                'total_sales' => $sizeRow['total_sales']
                            ];
                        }
                        // For each product and size, store the quantity sold and total sales into the $sizeInterpretationData array.
            
                        // Output detailed interpretation for each product and size
                        foreach ($sizeInterpretationData as $product => $sizes) {
                            echo "<p>{$product} – ";
                            $sizeDescriptions = [];
                            foreach ($sizes as $size => $data) {
                                $sizeDescriptions[] = "{$data['quantity']} {$size} ($" . number_format($data['total_sales'], 2) . ")";
                            }
                            echo implode(", ", $sizeDescriptions);
                            echo "</p>";
                            // Output a human-readable breakdown of sales for each size of the product.
                        }
                    }
                }

                // Table for displaying sales by category (with dynamic detailed interpretation)
                elseif ($type === 'category') {
                    echo "<table border='1' cellpadding='10' cellspacing='0'>";
                    echo "<tr>
                            <th>Size</th>
                            <th>Total Dollar Sales ($)</th>
                            <th>Quantity Sales</th>
                          </tr>";
                    // If the report is 'by category', generate a table with columns for Size, Total Sales, and Quantity Sold.
            
                    // Loop through the result set and display each row in the table
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['size']}</td>
                                <td>" . number_format($row['total_sales'], 2) . "</td>
                                <td>{$row['total_quantity']}</td>
                              </tr>";
                        // Loop through each row of the result and output the size, total sales, and quantity sold.
            
                        // Store the data for category interpretation dynamically
                        $categoryData[$row['size']] = [
                            'quantity' => $row['total_quantity'],
                            'total_sales' => $row['total_sales']
                        ];
                    }
                    echo "</table>";
                    // Close the HTML table tag.
            
                    // Display detailed interpretation for categories dynamically
                    echo "<p><strong>Detailed Interpretation of Categories</strong></p>";
                    foreach ($categoryData as $size => $data) {
                        echo "<p>{$size} – {$data['quantity']} items sold for a total of $" . number_format($data['total_sales'], 2) . "</p>";
                    }
                    // Output a human-readable breakdown of sales for each size category (e.g., Single, Double).
                }
            } else {
                // If no data is available for the report
                echo "<p>No sales data available for the selected report.</p>";
            }
            ?>
        </div>

        <footer>
            <p>Copyright &copy; 2014 JavaJam Coffee House<br>
                <a href='mailto:abig005@e.ntu.edu.sg'>Abigail@Lim.com</a>
            </p>
        </footer>
    </div>
</body>

</html>
<?php

// Close the database connection
$conn->close();
// Close the database connection to clean up resources after all operations have been completed.
?>