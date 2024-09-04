document.addEventListener("DOMContentLoaded", function () {
  // JavaScript to provide hints and validation

  // Get references to the input fields by their IDs
  const firstNameField = document.getElementById("first_name");
  const lastNameField = document.getElementById("last_name");
  const emailField = document.getElementById("email");
  const telephoneField = document.getElementById("telephone");
  const passwordField = document.getElementById("password");

  // Set tooltips (hints) for each input field
  firstNameField.setAttribute(
    "title",
    "Enter first name. Only alphabetic characters, no space."
  );
  lastNameField.setAttribute(
    "title",
    "Enter last name. Only alphabetic characters, no space."
  );
  emailField.setAttribute("title", "Enter email. Includes @ and end with .com");
  telephoneField.setAttribute(
    "title",
    "Enter telephone. Start with +Code, then 9 numeric characters."
  );
  passwordField.setAttribute("title", "Enter a memorable secure password.");

  // Add an event listener for the form submission
  document
    .getElementById("registration-form")
    .addEventListener("submit", function (event) {
      // Basic validation before submission

      // Validate first name (only alphabetic characters, no space)
      if (!firstNameField.value.match(/^[A-Za-z]+$/)) {
        alert("First name should be alphabetic characters without space.");
        event.preventDefault(); // Prevent form submission if validation fails
      }

      // Validate last name (only alphabetic characters, no space)
      if (!lastNameField.value.match(/^[A-Za-z]+$/)) {
        alert("Last name should be alphabetic characters without space.");
        event.preventDefault(); // Prevent form submission if validation fails
      }

      // Validate email format (must include @ and end with .com)
      if (!emailField.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
        alert("Email should include @ and end with .com.");
        event.preventDefault(); // Prevent form submission if validation fails
      }

      // Validate telephone format (must start with + and be followed by 12 numeric characters)
      if (!telephoneField.value.match(/^\+\d{12}$/)) {
        alert(
          "Telephone should start with + and be followed by 12 numeric characters."
        );
        event.preventDefault(); // Prevent form submission if validation fails
      }

      // Validate password (must not be empty)
      if (passwordField.value.trim() === "") {
        alert("Password cannot be empty.");
        event.preventDefault(); // Prevent form submission if validation fails
      }
    });

  // Function to redirect the user to the home page
  window.goHome = function () {
    window.location.href = "home_page.html"; // Adjust the path if needed
  };
});
