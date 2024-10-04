document.addEventListener("DOMContentLoaded", function () {
    setupListeners(); // Set up event listeners when the page is fully loaded
});

function setupListeners() {
    var items = [
        { qtyInput: "QtyJava", priceDisplay: "Price_Java", radioName: "javaSize", product: "Just Java" },
        { qtyInput: "QtyCafeaulait", priceDisplay: "Price_Cafeaulait", radioName: "cafeaulaitSize", product: "Cafe au Lait" },
        { qtyInput: "QtyCappuccino", priceDisplay: "Price_Cappuccino", radioName: "cappuccinoSize", product: "Iced Cappuccino" }
    ];

    items.forEach(function (item) {
        var qtyInputNode = document.getElementById(item.qtyInput);
        var radios = document.getElementsByName(item.radioName);
    
        if (qtyInputNode) {
            qtyInputNode.addEventListener("change", function () {
                validateNumericInput(qtyInputNode);
                updateSubtotal(item.qtyInput, item.priceDisplay, item.radioName, item.product);
            });
        }
    
        if (radios.length > 0) {
            radios.forEach(function (radio) {
                radio.addEventListener("change", function () {
                    updateSubtotal(item.qtyInput, item.priceDisplay, item.radioName, item.product);
                });
            });
        }
    });
}

function validateNumericInput(inputField) {
    var value = inputField.value;

    if (!/^\d*$/.test(value)) {
        alert("Please enter a valid number.");
        inputField.value = ""; 
        inputField.focus();     
    }
}

function updateSubtotal(qtyInputId, priceDisplayId, radioName, product) {
    var qty = document.getElementById(qtyInputId).value || 0;
    var selectedSize = document.querySelector(`input[name="${radioName}"]:checked`);

    if (qty > 0 && !selectedSize) {
        alert("Please select a size for the item.");
        return;
    }
    
    let price = 0;
    let size = "";

    if (selectedSize) {
        switch (radioName) {
            case "javaSize":
                price = prices.java * parseInt(qty);
                size = "Endless Cup";
                break;
            case "cafeaulaitSize":
                size = selectedSize.value == "2.00" ? "Single" : "Double";
                price = size === "Single" ? prices.cafeaulaitSingle * parseInt(qty) : prices.cafeaulaitDouble * parseInt(qty);
                break;
            case "cappuccinoSize":
                size = selectedSize.value == "4.75" ? "Single" : "Double";
                price = size === "Single" ? prices.cappuccinoSingle * parseInt(qty) : prices.cappuccinoDouble * parseInt(qty);
                break;
        }
        document.getElementById(priceDisplayId).innerText = "$" + price.toFixed(2);
    }

    calculateTotal();
}

function calculateTotal() {
    var javaSubtotal = parseFloat(document.getElementById("Price_Java").innerText.replace("$", "")) || 0;
    var cafeaulaitSubtotal = parseFloat(document.getElementById("Price_Cafeaulait").innerText.replace("$", "")) || 0;
    var cappuccinoSubtotal = parseFloat(document.getElementById("Price_Cappuccino").innerText.replace("$", "")) || 0;

    var total = javaSubtotal + cafeaulaitSubtotal + cappuccinoSubtotal;
    
    document.getElementById("totalPrice").innerText = "$" + total.toFixed(2);
}

// Function to gather order details
function gatherOrderDetails() {
    let orderDetails = [];

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

    return orderDetails;
}

// Form submission handler
document.querySelector('form').addEventListener('submit', function (e) {
    alert('Form has been submitted!'); // Simple alert to confirm submission
});
