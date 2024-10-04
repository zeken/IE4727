<?php
// Include the fetch_prices.php file to retrieve prices
include 'price-fetch.php'; // or use 'require' if you want the script to fail if the file is missing

// Now you can use the variables fetched in fetch_prices.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JavaJam Coffee House - Product Price Update</title>
    <link rel="stylesheet" href="styles.css">
    <script src="price-update.js" defer></script>
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
            <h2>Click to update product prices:</h2>
            <div class="content-wrapper">
                <form id="price-update-form" action="price-update.php" method="POST">
                    <table class="menu-table">
                        <!-- Just Java Row -->
                        <tr>
                            <td class="price-checkbox">
                                <input type="checkbox" class="input-large-checkbox" id="justJava" name="justJava">
                            </td>
                            <td class="menu-item"><strong>Just Java</strong></td>
                            <td class="menu-description">
                                Regular house blend, decaffeinated coffee, or flavor of the day.<br>
                                Endless Cup: $<span id="justJavaPrice"><?php echo htmlspecialchars($justJavaPrice); ?></span>
                                <!-- Hidden input for just java price -->
                                <input type="hidden" id="justJavaPriceInput" name="justJavaPrice" value="<?php echo htmlspecialchars($justJavaPrice); ?>">
                            </td>
                        </tr>
                
                        <!-- Cafe au Lait Row -->
                        <tr>
                            <td class="price-checkbox">
                                <input type="checkbox" class="input-large-checkbox" id="cafeAuLait" name="cafeAuLait">
                            </td>
                            <td class="menu-item"><strong>Cafe au Lait</strong></td>
                            <td class="menu-description">
                                House blended coffee infused into a smooth, steamed milk.<br>
                                Single: $<span id="cafeAuLaitSinglePrice"><?php echo htmlspecialchars($cafeAuLaitSinglePrice); ?></span>
                                Double: $<span id="cafeAuLaitDoublePrice"><?php echo htmlspecialchars($cafeAuLaitDoublePrice); ?></span>
                                <!-- Hidden inputs for cafe au lait prices -->
                                <input type="hidden" id="cafeAuLaitSinglePriceInput" name="cafeAuLaitSinglePrice" value="<?php echo htmlspecialchars($cafeAuLaitSinglePrice); ?>">
                                <input type="hidden" id="cafeAuLaitDoublePriceInput" name="cafeAuLaitDoublePrice" value="<?php echo htmlspecialchars($cafeAuLaitDoublePrice); ?>">
                            </td>
                        </tr>
                
                        <!-- Iced Cappuccino Row -->
                        <tr>
                            <td class="price-checkbox">
                                <input type="checkbox" class="input-large-checkbox" id="icedCappuccino" name="icedCappuccino">
                            </td>
                            <td class="menu-item"><strong>Iced Cappuccino</strong></td>
                            <td class="menu-description">
                                Sweetened espresso blended with icy-cold milk and served in a chilled glass.<br>
                                Single: $<span id="icedCappuccinoSinglePrice"><?php echo htmlspecialchars($icedCappuccinoSinglePrice); ?></span>
                                Double: $<span id="icedCappuccinoDoublePrice"><?php echo htmlspecialchars($icedCappuccinoDoublePrice); ?></span>
                                <!-- Hidden inputs for iced cappuccino prices -->
                                <input type="hidden" id="icedCappuccinoSinglePriceInput" name="icedCappuccinoSinglePrice" value="<?php echo htmlspecialchars($icedCappuccinoSinglePrice); ?>">
                                <input type="hidden" id="icedCappuccinoDoublePriceInput" name="icedCappuccinoDoublePrice" value="<?php echo htmlspecialchars($icedCappuccinoDoublePrice); ?>">
                            </td>
                        </tr>
                    </table>
                
                    <input type="submit" class="submit-update-price" value="Update Prices">
                </form>                
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
