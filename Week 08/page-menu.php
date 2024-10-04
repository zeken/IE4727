<?php
// Include the fetch_prices.php file to retrieve prices
include 'price-fetch.php'; // or use 'require' if you want the script to fail if the file is missing

// Now you can use the variables fetched in fetch_prices.php
?>

<script>
    // JavaScript variables to store the fetched prices from the database
    const prices = {
        java: <?php echo json_encode($justJavaPrice); ?>, // Example price for Just Java (endless cup)
        cafeaulaitSingle: <?php echo json_encode($cafeAuLaitSinglePrice); ?>, // Single Cafe au Lait
        cafeaulaitDouble: <?php echo json_encode($cafeAuLaitDoublePrice); ?>, // Double Cafe au Lait
        cappuccinoSingle: <?php echo json_encode($icedCappuccinoSinglePrice); ?>, // Single Iced Cappuccino
        cappuccinoDouble: <?php echo json_encode($icedCappuccinoDoublePrice); ?>, // Double Iced Cappuccino
    };
</script>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JavaJam Coffee House - Menu</title>
    <link rel="stylesheet" href="styles.css">
    <script src="menu-price.js" defer></script>
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

        <!-- Added a form to wrap the menu and handle order submission -->
        <form method="POST" action="menu-Submitorder.php">
            <div class="main-content">
                <h2>Coffee at JavaJam</h2>
                <div class="content-wrapper">
                    <table class="menu-table">
                        <!-- Just Java Row -->
                        <tr>
                            <td class="menu-item"><strong>Just Java</strong></td>
                            <td class="menu-description">
                                Regular house blend, decaffeinated coffee, or flavor of the day.<br>
                                <label><input type="radio" name="javaSize" value="2.00"> Endless Cup
                                    $<?php echo htmlspecialchars($justJavaPrice); ?></label>
                                <!-- Radio button for selecting size -->
                            </td>
                            <td class="menu-qty"><input type="number" id="QtyJava" value="0" min="0" max="99"></td>
                            <!-- Input field for quantity -->
                            <td class="menu-price"><span id="Price_Java">$0.00</span></td>
                            <!-- Placeholder to display calculated price -->
                        </tr>

                        <!-- Cafe au Lait Row -->
                        <tr>
                            <td class="menu-item"><strong>Cafe au Lait</strong></td>
                            <td class="menu-description">
                                House blended coffee infused into a smooth, steamed milk.<br>
                                <div class="menu-radio-inline">
                                    <label><input type="radio" name="cafeaulaitSize" value="2.00"> Single
                                        $<?php echo htmlspecialchars($cafeAuLaitSinglePrice); ?></label>
                                    <label><input type="radio" name="cafeaulaitSize" value="3.00"> Double
                                        $<?php echo htmlspecialchars($cafeAuLaitDoublePrice); ?></label>
                                </div> <!-- Radio buttons for selecting single/double size -->
                            </td>
                            <td class="menu-qty"><input type="number" id="QtyCafeaulait" value="0" min="0" max="99">
                            </td>
                            <td class="menu-price"><span id="Price_Cafeaulait">$0.00</span></td>
                        </tr>

                        <!-- Iced Cappuccino Row -->
                        <tr>
                            <td class="menu-item"><strong>Iced Cappuccino</strong></td>
                            <td class="menu-description">
                                Sweetened espresso blended with icy-cold milk and served in a chilled glass.<br>
                                <div class="menu-radio-inline">
                                    <label><input type="radio" name="cappuccinoSize" value="4.75"> Single
                                        $<?php echo htmlspecialchars($icedCappuccinoSinglePrice); ?></label>
                                    <label><input type="radio" name="cappuccinoSize" value="5.75"> Double
                                        $<?php echo htmlspecialchars($icedCappuccinoDoublePrice); ?></label>
                                </div>
                            </td>
                            <td class="menu-qty"><input type="number" id="QtyCappuccino" value="0" min="0" max="99">
                            </td> <!-- Quantity field for Iced Cappuccino -->
                            <td class="menu-price"><span id="Price_Cappuccino">$0.00</span></td>
                        </tr>
                    </table>

                    <!-- Total Amount Section -->
                    <div class="menu-total-container">
                        <strong class="menu-total-text">Total: <span id="totalPrice">$0.00</span></strong>
                        <!-- Displays the total price for all items -->
                    </div>

                    <!-- Hidden input to store order details before submission -->
                    <input type="hidden" name="orderDetails" id="orderDetails">

                    <!-- Submit Button container -->
                    <div class="menu-submit-container">
                        <button type="submit" class="menu-submit-order">Submit Order</button>
                    </div>
                    <!-- Button to submit the form and send the order details to the server -->
                </div>
            </div>
        </form>

        <footer>
            <p>Copyright &copy; 2014 JavaJam Coffee House<br>
                <a href="mailto:abig005@e.ntu.edu.sg">Abigail@Lim.com</a>
            </p>
        </footer>
    </div>
</body>

</html>