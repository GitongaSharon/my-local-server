document.addEventListener("DOMContentLoaded", function () {
  // Handle the end session action
  document
    .getElementById("end-session")
    .addEventListener("click", function (event) {
      event.preventDefault(); // Prevent default link behavior
      // Add any necessary cleanup or logout actions here, e.g., clearing session storage
      alert("Ending session..."); // Optional: Confirm session end with the user

      // Redirect to login page or simply close the tab/window
      window.location.href = "login.html"; // Redirect to login page (or another page)
      // Or use window.close() to close the window/tab if appropriate
      // window.close();
    });
});
