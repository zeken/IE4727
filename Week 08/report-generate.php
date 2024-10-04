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

// Determine the type of report based on URL parameter (either 'product' or 'category')
$type = $_GET['type'] ?? '';

// Initialize arrays to store the interpretation data for products and categories
$interpretationData = [];
$categoryData = [];

// If the report is by product, calculate sales grouped by product and size
if ($type === 'product') {
    // SQL query to group the sales by product (without the size), summing the total price and quantity for each product
    $sql = "SELECT product_name, SUM(total_price) AS total_sales, SUM(quantity) AS total_quantity 
            FROM orders 
            GROUP BY product_name
            ORDER BY product_name ASC";  // Removed size grouping for the product report
}

// If the report is by category (size), calculate sales grouped by size only
elseif ($type === 'category') {
    // SQL query to group by size (Single, Double, etc.), summing the total sales and quantities
    $sql = "SELECT size, SUM(total_price) AS total_sales, SUM(quantity) AS total_quantity 
            FROM orders 
            GROUP BY size
            ORDER BY total_sales DESC";
}

// Execute the SQL query and fetch the result
$result = $conn->query($sql);

// Start HTML output for the report page
echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";

// Change the title based on the report type
if ($type === 'product') {
    echo "<title>JavaJam Coffee House - Sales Report by Products</title>";
} elseif ($type === 'category') {
    echo "<title>JavaJam Coffee House - Sales Report by Categories</title>";
}

echo "<link rel='stylesheet' href='styles.css'>";
echo "</head>";
echo "<body>";
echo "<div class='container'>";

// Header and navigation
echo "<header>";
echo "<img src='images/javajam-all-javalogo.png' alt='JavaJam Coffee House' class='logo'>";
echo "</header>";

echo "<nav>";
echo "<ul>";
echo "<li><a href='index.html'>Home</a></li>";
echo "<li><a href='page-menu.php'>Menu</a></li>";
echo "<li><a href='page-music.html'>Music</a></li>";
echo "<li><a href='page-jobs.html'>Jobs</a></li>";
echo "<li><a href='page-price-update.php'>Product Price Update</a></li>";
echo "<li><a href='page-sales-report.php'>Sales Report</a></li>";
echo "</ul>";
echo "</nav>";

echo "<div class='main-content'>";

// Change the heading based on the report type
if ($type === 'product') {
    echo "<h2>Sales Report - By Products</h2>";
} elseif ($type === 'category') {
    echo "<h2>Sales Report - By Categories</h2>";
}

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

        // Loop through the result set and display each row in the table
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['product_name']}</td>
                    <td>" . number_format($row['total_sales'], 2) . "</td>
                    <td>{$row['total_quantity']}</td>
                  </tr>";
            
            // Store the data for interpretation breakdown dynamically (to later display by size)
            $interpretationData[$row['product_name']] = [
                'total_quantity' => $row['total_quantity'],
                'total_sales' => $row['total_sales'] // Store as a numeric value
            ];
        }

        echo "</table>";

        // Display detailed interpretation dynamically based on the actual data
        echo "<p><strong>Detailed Interpretation of Products by Size</strong></p>";

        // Dynamically generate interpretation for each product by sizes (e.g., Single, Double)
        $productSizeSql = "SELECT product_name, size, SUM(total_price) AS total_sales, SUM(quantity) AS total_quantity 
                           FROM orders 
                           GROUP BY product_name, size
                           ORDER BY product_name ASC, size ASC";
        
        $sizeResult = $conn->query($productSizeSql);

        if ($sizeResult->num_rows > 0) {
            $sizeInterpretationData = [];
            while ($sizeRow = $sizeResult->fetch_assoc()) {
                // Group data by product name and size
                $sizeInterpretationData[$sizeRow['product_name']][$sizeRow['size']] = [
                    'quantity' => $sizeRow['total_quantity'],
                    'total_sales' => $sizeRow['total_sales']
                ];
            }

            // Output detailed interpretation for each product and size
            foreach ($sizeInterpretationData as $product => $sizes) {
                echo "<p>{$product} – ";
                $sizeDescriptions = [];
                foreach ($sizes as $size => $data) {
                    $sizeDescriptions[] = "{$data['quantity']} {$size} ($" . number_format($data['total_sales'], 2) . ")";
                }
                echo implode(", ", $sizeDescriptions);
                echo "</p>";
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

        // Loop through the result set and display each row in the table
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['size']}</td>
                    <td>" . number_format($row['total_sales'], 2) . "</td>
                    <td>{$row['total_quantity']}</td>
                  </tr>";
            
            // Store the data for category interpretation dynamically
            $categoryData[$row['size']] = [
                'quantity' => $row['total_quantity'],
                'total_sales' => $row['total_sales']
            ];
        }

        echo "</table>";

        // Display detailed interpretation for categories dynamically
        echo "<p><strong>Detailed Interpretation of Categories</strong></p>";
        foreach ($categoryData as $size => $data) {
            echo "<p>{$size} – {$data['quantity']} items sold for a total of $" . number_format($data['total_sales'], 2) . "</p>";
        }
    }

} else {
    // If no data is available for the report
    echo "<p>No sales data available for the selected report.</p>";
}

// Footer section
echo "</div>";
echo "<footer>";
echo "<p>Copyright &copy; 2014 JavaJam Coffee House<br>";
echo "<a href='mailto:abig005@e.ntu.edu.sg'>Abigail@Lim.com</a>";
echo "</p>";
echo "</footer>";

echo "</div>"; // End of container
echo "</body>";
echo "</html>";

// Close the database connection
$conn->close();

