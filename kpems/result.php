<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "R0ygb!v@96";
$dbname = "primary_school_assesment_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query
$sql = "
SELECT 
    s.Student_id,
    s.First_Name,
    s.Second_Name,
    s.Class_id,
    a.year,
    a.term,
    a.class_subject_id,
    a.Opener,
    a.CAT_1,
    a.CAT_2,
    a.Midterm,
    a.End_term
FROM 
    students s
INNER JOIN 
    assessment a ON s.Student_id = a.student_id
";

// Execute query
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Output data of each row
    echo "<table border='1'>";
    echo "<tr><th>Student ID</th><th>First Name</th><th>Second Name</th><th>Class ID</th><th>Year</th><th>Term</th><th>Class Subject ID</th><th>Opener</th><th>CAT 1</th><th>CAT 2</th><th>Midterm</th><th>End-term</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Student_id"] . "</td>";
        echo "<td>" . $row["First_Name"] . "</td>";
        echo "<td>" . $row["Second_Name"] . "</td>";
        echo "<td>" . $row["Class_id"] . "</td>";
        echo "<td>" . $row["year"] . "</td>";
        echo "<td>" . $row["term"] . "</td>";
        echo "<td>" . $row["class_subject_id"] . "</td>";
        echo "<td>" . $row["Opener"] . "</td>";
        echo "<td>" . $row["CAT_1"] . "</td>";
        echo "<td>" . $row["CAT_2"] . "</td>";
        echo "<td>" . $row["Midterm"] . "</td>";
        echo "<td>" . $row["End_term"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
