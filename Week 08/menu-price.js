document.addEventListener("DOMContentLoaded", function () {
    // Check if the URL contains the 'success' parameter and show a success message
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        alert("Your order has been submitted successfully!");

        // Remove the 'success' parameter from the URL after displaying the alert
        urlParams.delete('success');
        const newUrl = window.location.pathname + '?' + urlParams.toString();
        window.history.replaceState(null, '', newUrl); // Update the URL without reloading the page
    }
    
    setupListeners(); // Initialize event listeners when the DOM is fully loaded
});

function setupListeners() {
    // Define the menu items, their respective quantity inputs, price display IDs, and product names
    var items = [
        { qtyInput: "QtyJava", priceDisplay: "Price_Java", radioName: "javaSize", product: "Just Java" },
        { qtyInput: "QtyCafeaulait", priceDisplay: "Price_Cafeaulait", radioName: "cafeaulaitSize", product: "Cafe au Lait" },
        { qtyInput: "QtyCappuccino", priceDisplay: "Price_Cappuccino", radioName: "cappuccinoSize", product: "Iced Cappuccino" }
    ];

    // Set up event listeners for each menu item to listen for changes in quantity and size
    items.forEach(function (item) {
        var qtyInputNode = document.getElementById(item.qtyInput); // Get the quantity input field
        var radios = document.getElementsByName(item.radioName);   // Get the radio buttons for size selection
    
        if (qtyInputNode) {
            // Add an event listener for changes in quantity input
            qtyInputNode.addEventListener("change", function () {
                validateNumericInput(qtyInputNode); // Validate numeric input
                updateSubtotal(item.qtyInput, item.priceDisplay, item.radioName, item.product); // Update subtotal when quantity changes
            });
        }
    
        if (radios.length > 0) {
            // Add an event listener for changes in the radio buttons (size selection)
            radios.forEach(function (radio) {
                radio.addEventListener("change", function () {
                    updateSubtotal(item.qtyInput, item.priceDisplay, item.radioName, item.product); // Update subtotal when size changes
                });
            });
        }
    });
}

// Validation function to ensure only numeric input
function validateNumericInput(inputField) {
    var value = inputField.value;

    // Use a regular expression to allow only numeric characters
    if (!/^\d*$/.test(value)) {
        alert("Please enter a valid number.");
        inputField.value = ""; // Clear the invalid input
        inputField.focus();     // Focus back on the input field
    }
}

// Calculate the subtotal for any item
function updateSubtotal(qtyInputId, priceDisplayId, radioName, product) {
    var qty = document.getElementById(qtyInputId).value || 0; // Get the current quantity value
    var selectedSize = document.querySelector(`input[name="${radioName}"]:checked`); // Get the selected size

    if (qty > 0 && !selectedSize) {
        alert("Please select a size for the item."); // Alert if no size is selected
        return;
    }
    
    let price = 0;
    let size = "";

    // Determine the price based on the selected size and product
    if (selectedSize) {
        switch (radioName) {
            case "javaSize":
                price = prices.java * parseInt(qty); // Calculate price for Just Java
                size = "Endless Cup"; // Set size as "Endless Cup"
                break;
            case "cafeaulaitSize":
                size = selectedSize.value == "2.00" ? "Single" : "Double"; // Set size based on selected value
                price = size === "Single" ? prices.cafeaulaitSingle * parseInt(qty) : prices.cafeaulaitDouble * parseInt(qty); // Calculate price for Cafe au Lait
                break;
            case "cappuccinoSize":
                size = selectedSize.value == "4.75" ? "Single" : "Double"; // Set size for Cappuccino
                price = size === "Single" ? prices.cappuccinoSingle * parseInt(qty) : prices.cappuccinoDouble * parseInt(qty); // Calculate price for Cappuccino
                break;
        }
        document.getElementById(priceDisplayId).innerText = "$" + price.toFixed(2); // Display the updated price in the respective element
    }

    // Trigger total calculation after updating subtotal
    calculateTotal();
}

// Calculate the total price for all items
function calculateTotal() {
    var javaSubtotal = parseFloat(document.getElementById("Price_Java").innerText.replace("$", "")) || 0;
    var cafeaulaitSubtotal = parseFloat(document.getElementById("Price_Cafeaulait").innerText.replace("$", "")) || 0;
    var cappuccinoSubtotal = parseFloat(document.getElementById("Price_Cappuccino").innerText.replace("$", "")) || 0;

    var total = javaSubtotal + cafeaulaitSubtotal + cappuccinoSubtotal; // Sum the subtotals to get the total price
    
    document.getElementById("totalPrice").innerText = "$" + total.toFixed(2); // Display the total price
}

// Function to gather order details and submit the form
function gatherOrderDetails() {
    let orderDetails = [];

    // Just Java order
    let javaQty = document.getElementById('QtyJava').value;
    let javaSize = document.querySelector('input[name="javaSize"]:checked');
    if (javaQty > 0 && javaSize) {
        orderDetails.push({
            product_name: 'Just Java',
            size: "Endless Cup",
            quantity: javaQty,
            unit_price: prices.java,
            total_price: (prices.java * javaQty).toFixed(2)
        });
    }

    // Cafe au Lait order
    let cafeaulaitQty = document.getElementById('QtyCafeaulait').value;
    let cafeaulaitSize = document.querySelector('input[name="cafeaulaitSize"]:checked');
    if (cafeaulaitQty > 0 && cafeaulaitSize) {
        let size = cafeaulaitSize.value == "2.00" ? "Single" : "Double";
        let price = size === "Single" ? prices.cafeaulaitSingle : prices.cafeaulaitDouble;
        orderDetails.push({
            product_name: 'Cafe au Lait',
            size: size,
            quantity: cafeaulaitQty,
            unit_price: price,
            total_price: (price * cafeaulaitQty).toFixed(2)
        });
    }

    // Iced Cappuccino order
    let cappuccinoQty = document.getElementById('QtyCappuccino').value;
    let cappuccinoSize = document.querySelector('input[name="cappuccinoSize"]:checked');
    if (cappuccinoQty > 0 && cappuccinoSize) {
        let size = cappuccinoSize.value == "4.75" ? "Single" : "Double";
        let price = size === "Single" ? prices.cappuccinoSingle : prices.cappuccinoDouble;
        orderDetails.push({
            product_name: 'Iced Cappuccino',
            size: size,
            quantity: cappuccinoQty,
            unit_price: price,
            total_price: (price * cappuccinoQty).toFixed(2)
        });
    }

    // Convert the order details to JSON and submit them via a hidden form field
    document.getElementById('orderDetails').value = JSON.stringify(orderDetails);
}

// Call gatherOrderDetails before form submission
document.querySelector('form').addEventListener('submit', function (e) {
    gatherOrderDetails(); // Populate the order details before submitting the form
    // alert('Order has been submitted!'); // Simple alert to confirm submission
});
