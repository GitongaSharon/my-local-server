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

$post_data = json_decode(file_get_contents("php://input"), true);

if (!isset($post_data['table']) || !isset($post_data['data']) || !isset($post_data['primary_key_value'])) {
    die("Required parameters are missing.");
}

$table = $post_data['table'];
$data = $post_data['data'];
$primary_key_value = $post_data['primary_key_value'];

$primary_key_column = '';
switch ($table) {
/*    
    case 'students':
        $primary_key_column = 'student_id';
        break;
    case 'parents':
        $primary_key_column = 'parent_id';
        break;
    case 'teachers':
        $primary_key_column = 'teacher_id';
        break;
    case 'users':
        $primary_key_column = 'user_id';
        break;
    case 'counties':
        $primary_key_column = 'county_id';
        break;
*/
    case 'users':
        $primary_key_column = 'user_id';
        break;
    case 'students':
        $primary_key_column = 'student_id';
        break;
    case 'teachers':
        $primary_key_column = 'teacher_id';
        break;
    case 'subjects':
        $primary_key_column = 'subject_id';
        break;
    case 'parents':
        $primary_key_column = 'parent_id';
        break;
    case 'counties':
        $primary_key_column = 'county_id';
        break;
    case 'grades':
        $primary_key_column = 'grade_id';
        break;
    case 'streams':
        $primary_key_column = 'stream_id';
        break;
    case 'grade_subject':
        $primary_key_column = 'grade_subject_id';
        break;
    case 'subject_teachers':
        $primary_key_column = 'subject_teacher_id';
        break;
    case 'examination_results':
        $primary_key_column = 'examination_result_id';
        break;
    default:
        die("Unknown table");
}

$set_clause = [];
foreach ($data as $column => $value) {
    $set_clause[] = "$column = '" . $conn->real_escape_string($value) . "'";
}
$set_clause = implode(', ', $set_clause);

$sql = "UPDATE $table SET $set_clause WHERE $primary_key_column = '" . $conn->real_escape_string($primary_key_value) . "'";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
