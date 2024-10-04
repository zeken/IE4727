document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.price-checkbox input');
    const form = document.getElementById('price-update-form');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            if (checkbox.checked) {
                let item = checkbox.id; // Get the ID of the checkbox (item)
                let size;

                // Automatically set size to "Endless" for Just Java, otherwise ask for size
                if (item === 'justJava') {
                    size = "endless"; // Automatically set to "endless" for Just Java
                } else {
                    // Ask for size for other items
                    let validSizes = ['single', 'double']; // For cafeAuLait and icedCappuccino
                    size = prompt(`Which size do you want to update? (${validSizes.join('/')})`);
                }

                console.log(`Item: ${item}, Size: ${size}`);

                // Validate size input
                if ((item === 'justJava' && size === 'endless') || 
                    (size && (size.toLowerCase() === 'single' || size.toLowerCase() === 'double'))) {
                    
                    // Dynamically create the prompt message with item and size
                    let formattedItem = item.replace(/([A-Z])/g, ' $1').trim(); // Format the item ID to be more readable
                    let newPrice = prompt(`Enter the new price for ${formattedItem} (${size.charAt(0).toUpperCase() + size.slice(1)}):`);

                    // Ensure input is numeric
                    if (!isNaN(newPrice) && newPrice > 0) {
                        // Update hidden input
                        let priceInput;
                        if (item === 'justJava') {
                            priceInput = document.getElementById('justJavaPriceInput'); // No size for Just Java
                        } else {
                            priceInput = document.getElementById(`${item}${size.charAt(0).toUpperCase() + size.slice(1)}PriceInput`); // Size included for others
                        }

                        if (priceInput) {
                            priceInput.value = parseFloat(newPrice).toFixed(2); // Set the new price in the hidden input
                            console.log(`Updated ${priceInput.id} with new price: ${newPrice}`);
                        } else {
                            console.log(`Error: No hidden input found for ${item} - ${size}`);
                        }

                        // update the display element
                        let priceElement;
                        if (item === 'justJava') {
                            priceElement = document.getElementById('justJavaPrice'); // No size for Just Java
                        } else {
                            priceElement = document.getElementById(`${item}${size.charAt(0).toUpperCase() + size.slice(1)}Price`); // Size included for others
                        }

                        if (priceElement) {
                            priceElement.textContent = parseFloat(newPrice).toFixed(2); // Show the updated price in the table
                        }

                    } else {
                        alert('Invalid input. Please enter a valid number.');
                        checkbox.checked = false; // Uncheck the checkbox
                    }
                } else {
                    alert('Invalid size. Please select either Single, Double, or Endless.');
                    checkbox.checked = false; // Uncheck the checkbox
                }
            }
        });
    });

    // Prevent form submission until after the new prices are confirmed
    form.addEventListener('submit', function (event) {
        let updated = false;
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                updated = true;
            }
        });
        if (!updated) {
            alert('No prices updated.');
            event.preventDefault(); // Prevent form submission if no prices were updated
        } else {
            // Show an alert confirming that the form has been submitted successfully
            alert('Form has been submitted successfully with the updated prices.');
        }
    });
});
