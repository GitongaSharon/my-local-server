<?php
// Database connection parameters
$host = 'localhost';
$user = 'root';
$password = 'R0ygb!v@96';
$database = 'kpems';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$table = $_GET['table'] ?? null;

if ($table) {
    // Ensure the table name is valid to avoid SQL injection
    $allowed_tables = ['users', 'students', 'teachers', 'subjects', 'parents', 'counties', 'grades', 'streams', 'grade_subjects', 'subject_teachers', 'examination_results'];
    if (!in_array($table, $allowed_tables)) {
        die(json_encode([]));
    }

    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);

    $data = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    echo json_encode($data);
} else {
    echo json_encode([]);
}

$conn->close();
?>

