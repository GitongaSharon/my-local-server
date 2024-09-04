<?php
// Database connection details
$host = 'localhost'; // Hostname of the database server
$user = 'root'; // Database username
$password = 'R0ygb!v@96'; // Database password
$database = 'kpems'; // Name of the database

// Establish a connection to the MySQL database using MySQLi
$conn = new mysqli($host, $user, $password, $database);

// Check if the connection to the database was successful
if ($conn->connect_error) {
    // If the connection failed, stop the script and output an error message
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user input from the form
$first_name = $_POST['first_name']; // User's first name
$last_name = $_POST['last_name']; // User's last name
$user_type_id = $_POST['user_type_id']; // User type (e.g., Admin, Teacher, etc.)
$email = $_POST['email']; // User's email
$telephone = $_POST['telephone']; // User's telephone number
$password = $_POST['password']; // User's raw password input

// Hash the user-provided password using SHA-256 for security
$hashed_password = hash('sha256', $password);

// Check if a user with the provided email already exists in the database
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql); // Prepare the SQL statement to prevent SQL injection
$stmt->bind_param("s", $email); // Bind the email parameter to the prepared statement
$stmt->execute(); // Execute the query
$result = $stmt->get_result(); // Get the result of the query

// If a user with the same email already exists, handle accordingly
if ($result->num_rows > 0) {
    // User already exists, alert the user and redirect back to the registration page
    echo "<script>alert('A user with this email already exists.'); window.location.href='register_user.html';</script>";
} else {
    // If no user exists with the same email, proceed to insert the new user into the database
    $insert_sql = "INSERT INTO users (first_name, last_name, user_type_id, email, telephone, password)
                   VALUES (?, ?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql); // Prepare the insert statement
    $insert_stmt->bind_param("ssisss", $first_name, $last_name, $user_type_id, $email, $telephone, $hashed_password); // Bind parameters to the statement

    // Execute the insert statement and check if the operation was successful
    if ($insert_stmt->execute()) {
        // If successful, alert the user and redirect to the home page
        echo "<script>alert('Registration successful!'); window.location.href='home_page.html';</script>";
    } else {
        // If the insertion failed, alert the user and redirect back to the registration page
        echo "<script>alert('Registration failed. Please try again.'); window.location.href='register_user.html';</script>";
    }

    $insert_stmt->close(); // Close the insert statement
}

$stmt->close(); // Close the select statement
$conn->close(); // Close the database connection
?>
