// Event registration for all menu items
document.addEventListener("DOMContentLoaded", function () {
    setupListeners();
});

function setupListeners() {
    // Register event listeners for each menu item
    var items = [
        { qtyInput: "QtyJava", priceDisplay: "Price_Java", radioName: "javaSize" },
        { qtyInput: "QtyCafeaulait", priceDisplay: "Price_Cafeaulait", radioName: "cafeaulaitSize" },
        { qtyInput: "QtyCappuccino", priceDisplay: "Price_Cappuccino", radioName: "cappuccinoSize" }
    ];

    items.forEach(function (item) {
        var qtyInputNode = document.getElementById(item.qtyInput);
        var radios = document.getElementsByName(item.radioName);

        // Listen for changes in the quantity input
        qtyInputNode.addEventListener("change", function () {
            validateNumericInput(qtyInputNode);
            updateSubtotal(item.qtyInput, item.priceDisplay, item.radioName);
        });

        // Listen for changes in the radio buttons
        radios.forEach(function (radio) {
            radio.addEventListener("change", function () {
                updateSubtotal(item.qtyInput, item.priceDisplay, item.radioName);
            });
        });
    });
}

// Validation function to ensure only numeric input
// May not need because already have "number" attribute in html
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
function updateSubtotal(qtyInputId, priceDisplayId, radioName) {
    var qty = document.getElementById(qtyInputId).value || 0;
    var selectedSize = document.querySelector(`input[name="${radioName}"]:checked`);

    // Validation: If quantity is greater than 1 and no size is selected, show an alert
    if (qty > 0 && !selectedSize) {
        alert("Please select a size for the item.");
        return;
    }
    
    if (selectedSize) {
        var price = parseFloat(selectedSize.value) * parseInt(qty);
        document.getElementById(priceDisplayId).innerText = price.toFixed(2);
    }

    // Trigger total calculation after updating subtotal
    calculateTotal();
}

// Calculate the total price for all items
function calculateTotal() {
    var javaSubtotal = parseFloat(document.getElementById("Price_Java").innerText) || 0;
    var cafeSubtotal = parseFloat(document.getElementById("Price_Cafeaulait").innerText) || 0;
    var capSubtotal = parseFloat(document.getElementById("Price_Cappuccino").innerText) || 0;    

    var total = javaSubtotal + cafeSubtotal + capSubtotal;
    
    document.getElementById("totalPrice").innerText = "$" + total.toFixed(2);
}
