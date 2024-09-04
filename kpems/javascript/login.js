// Wait until the DOM is fully loaded before executing the script
document.addEventListener('DOMContentLoaded', function() {
    // JavaScript to provide hints and validation for the input fields
    
    // Get references to the input fields by their IDs
    const firstNameField = document.getElementById('first_name');
    const lastNameField = document.getElementById('last_name');
    const passwordField = document.getElementById('password');
    
    // Set tooltips (hints) for the input fields to guide the user
    firstNameField.setAttribute('title', 'Enter first name. Only alphabetic characters, no space.');
    lastNameField.setAttribute('title', 'Enter last name. Only alphabetic characters, no space.');
    passwordField.setAttribute('title', 'Enter your password.');

    // Add an event listener to the form to handle submission
    document.getElementById('login-form').addEventListener('submit', function(event) {
        // Basic validation before submission

        // Validate the first name field: must be alphabetic characters with no spaces
        if (!firstNameField.value.match(/^[A-Za-z]+$/)) {
            alert("First name should be alphabetic characters without space.");
            event.preventDefault(); // Prevent form submission if validation fails
        }

        // Validate the last name field: must be alphabetic characters with no spaces
        if (!lastNameField.value.match(/^[A-Za-z]+$/)) {
            alert("Last name should be alphabetic characters without space.");
            event.preventDefault(); // Prevent form submission if validation fails
        }

        // Validate the password field: must not be empty
        if (passwordField.value.trim() === "") {
            alert("Password cannot be empty.");
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
    
    // Define a function to redirect the user to the home page
    window.goHome = function() {
        window.location.href = 'home_page.html'; // Redirect to the home page, adjust the path if necessary
    };
});
