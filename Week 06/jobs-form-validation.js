// Wait until the DOM content is fully loaded before attaching event listeners
document.addEventListener('DOMContentLoaded', function () {

    // Get references to the form elements
    const form = document.querySelector('form');
    const nameField = document.getElementById('name');
    const emailField = document.getElementById('email');
    const startDateField = document.getElementById('startdate');
    const experienceField = document.getElementById('experience');

    // Regular expression for name validation (only alphabets and spaces)
    const namePattern = /^[A-Za-z\s]+$/;

    // Regular expression for email validation
    const emailPattern = /^[\w.-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,3}$/;

    // Name validation: only alphabet characters and spaces
    nameField.addEventListener('input', function () {
        if (!namePattern.test(nameField.value)) {
            nameField.setCustomValidity('Name should contain only letters and spaces.');
        } else {
            nameField.setCustomValidity('');
        }
        nameField.reportValidity(); // Force validation display
    });

    // Email validation: checks the format for username and domain name
    emailField.addEventListener('input', function () {
        if (!emailPattern.test(emailField.value)) {
            emailField.setCustomValidity('Please enter a valid email address (e.g., user.name@domain.com).');
        } else {
            emailField.setCustomValidity('');
        }
        emailField.reportValidity(); // Force validation display
    });

    // Start Date validation: ensure the date is not today or in the past
    startDateField.addEventListener('input', function () {
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Set current date to midnight

        const selectedDate = new Date(startDateField.value);
        selectedDate.setHours(0, 0, 0, 0); // Set the selected date to midnight

        if (selectedDate <= today) {
            startDateField.setCustomValidity('Start date must be in the future.');
        } else {
            startDateField.setCustomValidity('');
        }
        startDateField.reportValidity(); // Force validation display
    });

    // Experience field: HTML5 'required' attribute ensures this field is not left empty.
    experienceField.addEventListener('input', function () {
        if (experienceField.value.trim() === "") {
            experienceField.setCustomValidity('Experience cannot be empty.');
        } else {
            experienceField.setCustomValidity('');
        }
        experienceField.reportValidity(); // Force validation display
    });

    // Add form submission event listener to check validation before submission
    form.addEventListener('submit', function (event) {
        // Prevent form submission if any fields are invalid
        if (!nameField.checkValidity() || !emailField.checkValidity() ||
            !startDateField.checkValidity() || !experienceField.checkValidity()) {

            event.preventDefault(); // Prevent form submission

            // Alert the user to fill the form correctly
            alert("Please fill out the form correctly before submitting.");

            // Additionally, force the browser to display validation error messages
            nameField.reportValidity();
            emailField.reportValidity();
            startDateField.reportValidity();
            experienceField.reportValidity();
        }
    });
});
