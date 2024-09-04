document.addEventListener("DOMContentLoaded", function () {
  /* JavaScript to handle any dynamic actions
    console.log("Dashboard page loaded"); */
  // Handle the logout action
  document.getElementById("logout").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default link behavior
    // Add any necessary cleanup or logout actions here, e.g., clearing session storage
    alert("Logging out..."); // Optional: Confirm logout with the user

    // Redirect to login page or simply close the tab/window
    window.location.href = "home_page.html"; // Redirect to login page (or another page)
    // Or use window.close() to close the window/tab if appropriate
    // window.close();
  });
});
