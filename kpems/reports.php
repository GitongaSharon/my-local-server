<?php
session_start();

// Database connection
$host = 'localhost';
$user = 'root';
$password = 'R0ygb!v@96';
$database = 'kpems';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user input
$student_admission_number = $_POST['student_admission_number'];
$grade_subject_code = $_POST['grade_subject_code'];

// SQL query to retrieve exam results for the student and subject, including student name
$sql = "SELECT gs.grade_subject_code, gs.grade_subject_name, et.examination_type_code, er.examination_score, 
        CONCAT(t.first_name, ' ', t.last_name) AS teacher_name, 
        CONCAT(st.first_name, ' ', st.last_name) AS student_name
        FROM examination_results er
        JOIN grade_subjects gs ON er.grade_subject_code = gs.grade_subject_code
        LEFT JOIN examination_types et ON er.examination_type_code = et.examination_type_code
        JOIN teachers t ON er.teacher_id = t.teacher_id
        JOIN students st ON er.student_admission_number = st.admission_number
        WHERE er.student_admission_number = ? AND er.grade_subject_code = ?
        ORDER BY et.examination_type_id";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $student_admission_number, $grade_subject_code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the first row to get the student name
    $first_row = $result->fetch_assoc();
    $student_name = $first_row['student_name'];

    // Display the title with the full student name and admission number on two lines
    echo "<h2>Exam Results for $student_name<br>Admission Number: $student_admission_number</h2>";
    
    // Rewind the result set to the beginning
    $result->data_seek(0);
    
    echo "<table border='1'>";
    echo "<tr><th>Subject Code</th><th>Subject Name</th><th>Exam Type</th><th>Score</th><th>Teacher</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $examination_type_name = $row['examination_type_name'] ?? 'Unknown Exam Type';

        echo "<tr>
                <td>{$row['grade_subject_code']}</td>
                <td>{$row['grade_subject_name']}</td>
                <td>{$row['examination_type_code']}</td>
                <td>{$row['examination_score']}</td>
                <td>{$row['teacher_name']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No results found for the provided details.</p>";
}

$stmt->close();
$conn->close();
?>
