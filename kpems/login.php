<?php
// Start a new session or resume the existing session
session_start();

// Database connection parameters
$host = 'localhost'; // Database host
$user = 'root'; // Database username
$password = 'R0ygb!v@96'; // Database password
$database = 'kpems'; // Database name

// Create a new MySQLi connection instance
$conn = new mysqli($host, $user, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    // If there is a connection error, terminate the script and output the error
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user input from the login form using POST method
$first_name = $_POST['first_name']; // First name entered by the user
$last_name = $_POST['last_name']; // Last name entered by the user
$password = $_POST['password']; // Password entered by the user

// Hash the user-provided password using SHA-256 for secure comparison
$hashed_password = hash('sha256', $password);

// SQL query to validate user credentials against the database
$sql = "SELECT * FROM users WHERE first_name = ? AND last_name = ? AND password = ?";
$stmt = $conn->prepare($sql); // Prepare the SQL statement
$stmt->bind_param("sss", $first_name, $last_name, $hashed_password); // Bind parameters to the SQL query
$stmt->execute(); // Execute the query
$result = $stmt->get_result(); // Get the result of the query

// Check if any matching user record was found
if ($result->num_rows > 0) {
    // Fetch the user data from the result set
    $user = $result->fetch_assoc();

    // SQL query to fetch the user type based on user_type_id
    $user_type_sql = "SELECT user_type_name FROM user_types WHERE user_type_id = ?";
    $user_type_stmt = $conn->prepare($user_type_sql); // Prepare the SQL statement
    $user_type_stmt->bind_param("i", $user['user_type_id']); // Bind the user_type_id parameter
    $user_type_stmt->execute(); // Execute the query
    $user_type_result = $user_type_stmt->get_result(); // Get the result of the query
    $user_type = $user_type_result->fetch_assoc()['user_type_name']; // Fetch the user type name

    // Store the user's name and user type in session variables for later use
    $_SESSION['user'] = $first_name . " " . $last_name;
    $_SESSION['user_type'] = $user_type;

    // Determine the correct modules page to load based on user type
    switch ($user_type) {
        case 'System Admin':
            $redirect_page = 'modules_admin.html';
            break;
        case 'Management':
            $redirect_page = 'modules_management.html';
            break;
        case 'Teacher':
            $redirect_page = 'modules_teacher.html';
            break;
        case 'Student':
            $redirect_page = 'modules_student.html';
            break;
        case 'Parent':
        case 'Guardian':
        case 'Others':
            $redirect_page = 'modules_parent-guardian.html';
            break;
        default:
            $redirect_page = 'modules.html';
            break;
    }

    // Display a success message to the user and redirect to the appropriate modules page
    echo "<script>alert('Welcome $first_name $last_name. You are logged in to the Examinations Management system as a $user_type.'); window.location.href='$redirect_page';</script>";
} else {
    // If no matching user record was found, display an error message and redirect to the login page
    echo "<script>alert('Login failed. Please check your credentials.'); window.location.href='login.html';</script>";
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>
