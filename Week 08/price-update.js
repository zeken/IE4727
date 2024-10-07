// Wait for the DOM to be fully loaded before running this script
document.addEventListener('DOMContentLoaded', function () {
    // Select all checkboxes inside elements with the 'price-checkbox' class
    const checkboxes = document.querySelectorAll('.price-checkbox input');
    
    // Select the form element where the price update occurs
    const form = document.getElementById('price-update-form');

    // Iterate over each checkbox and add a change event listener to it
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            // Check if the checkbox was checked (i.e., selected by the user)
            if (checkbox.checked) {
                let item = checkbox.id; // Get the ID of the checkbox, representing the product
                let size;

                // Automatically set size to "Endless" for Just Java, otherwise ask for size
                if (item === 'justJava') {
                    size = "endless"; // Just Java always has "endless" as its size
                } else {
                    // Prompt the user to select either "single" or "double" for other items
                    let validSizes = ['single', 'double']; // Valid sizes for products like cafeAuLait and icedCappuccino
                    size = prompt(`Which size do you want to update? (${validSizes.join('/')})`);
                }

                console.log(`Item: ${item}, Size: ${size}`); // Log the selected item and size for debugging

                // Validate the size input (e.g., "endless" for Just Java or "single/double" for other products)
                if ((item === 'justJava' && size === 'endless') || 
                    (size && (size.toLowerCase() === 'single' || size.toLowerCase() === 'double'))) {
                    
                    // Dynamically create a prompt to ask for the new price of the selected item and size
                    let formattedItem = item.replace(/([A-Z])/g, ' $1').trim(); // Convert camelCase IDs to readable names (e.g., "justJava" -> "Just Java")
                    let newPrice = prompt(`Enter the new price for ${formattedItem} (${size.charAt(0).toUpperCase() + size.slice(1)}):`);

                    // Ensure the new price entered is a valid number and greater than zero
                    if (!isNaN(newPrice) && newPrice > 0) {
                        // Identify the corresponding hidden input field for storing the new price
                        let priceInput;
                        if (item === 'justJava') {
                            priceInput = document.getElementById('justJavaPriceInput'); // No size for Just Java
                        } else {
                            // Other products have both size and item in their input ID
                            priceInput = document.getElementById(`${item}${size.charAt(0).toUpperCase() + size.slice(1)}PriceInput`);
                        }

                        // Update the hidden input with the new price
                        if (priceInput) {
                            priceInput.value = parseFloat(newPrice).toFixed(2); // Ensure the price is formatted with two decimal places
                            console.log(`Updated ${priceInput.id} with new price: ${newPrice}`); // Log the update for debugging
                        } else {
                            console.log(`Error: No hidden input found for ${item} - ${size}`); // Log an error if the input field wasn't found
                        }

                        // Update the display element showing the price on the page
                        let priceElement;
                        if (item === 'justJava') {
                            priceElement = document.getElementById('justJavaPrice'); // For Just Java (no size)
                        } else {
                            priceElement = document.getElementById(`${item}${size.charAt(0).toUpperCase() + size.slice(1)}Price`); // For other products, update based on item and size
                        }

                        if (priceElement) {
                            priceElement.textContent = parseFloat(newPrice).toFixed(2); // Display the new price in the appropriate field
                        }

                    } else {
                        // If an invalid price is entered, show an alert and uncheck the checkbox
                        alert('Invalid input. Please enter a valid number.');
                        checkbox.checked = false; // Uncheck the checkbox as the update was invalid
                    }
                } else {
                    // If an invalid size is selected, show an alert and uncheck the checkbox
                    alert('Invalid size. Please select either Single, Double, or Endless.');
                    checkbox.checked = false; // Uncheck the checkbox as the size was invalid
                }
            }
        });
    });

    // Prevent form submission unless at least one price was updated
    form.addEventListener('submit', function (event) {
        let updated = false; // Initialize a flag to check if any checkbox was updated
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                updated = true; // If a checkbox was checked, set the flag to true
            }
        });
        if (!updated) {
            // If no checkboxes were checked, show an alert and prevent form submission
            alert('No prices updated.');
            event.preventDefault(); // Stop form submission
        } else {
            // Show an alert confirming successful form submission
            alert('Form has been submitted successfully with the updated prices.');
        }
    });
});
