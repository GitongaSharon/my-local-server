<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    // If the user chose "No", terminate the process
    if ($action == "no") {
        echo "<h2>Process terminated by user.</h2>";
        exit();
    }

    // If the user chose "Yes", proceed with compiling results
    if ($action == "yes") {
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "R0ygb!v@96";
        $dbname = "kpems";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Function to generate a random score between 35 and 95
        function generateRandomScore() {
            return rand(35, 95);
        }

        // Main function to compile examination results
        function compileExaminationResults($conn) {
            // Step 1: Select all students
            $sqlStudents = "SELECT admission_number, stream_id FROM students";
            $resultStudents = $conn->query($sqlStudents);

            if ($resultStudents->num_rows > 0) {
                // Loop1: Main outer loop for each student
                while ($rowStudent = $resultStudents->fetch_assoc()) {
                    $strAdmissionNumber = $rowStudent['admission_number'];
                    $intStream = $rowStudent['stream_id'];

                    // Step 2: Get stream code to determine grade code
                    $sqlStream = "SELECT stream_code FROM streams WHERE stream_id = $intStream";
                    $resultStream = $conn->query($sqlStream);
                    if ($resultStream->num_rows > 0) {
                        $rowStream = $resultStream->fetch_assoc();
                        $strGradeCode = substr($rowStream['stream_code'], 0, 3);

                        // Step 3: Get subjects for this grade
                        $sqlSubjects = "SELECT grade_subject_code FROM grade_subjects WHERE grade_code = '$strGradeCode'";
                        $resultSubjects = $conn->query($sqlSubjects);

                        if ($resultSubjects->num_rows > 0) {
                            // Loop3: Inner loop for each subject
                            while ($rowSubject = $resultSubjects->fetch_assoc()) {
                                $strGradeSubject = $rowSubject['grade_subject_code'];

                                // Step 4: Get teacher for this subject
                                $sqlTeacher = "SELECT teacher_id FROM subject_teachers WHERE grade_subject_code = '$strGradeSubject'";
                                $resultTeacher = $conn->query($sqlTeacher);
                                if ($resultTeacher->num_rows > 0) {
                                    $rowTeacher = $resultTeacher->fetch_assoc();
                                    $intTeacher = $rowTeacher['teacher_id'];

                                    // Step 5: Get examination types
                                    $sqlExaminationTypes = "SELECT examination_type_code FROM examination_types";
                                    $resultExaminationTypes = $conn->query($sqlExaminationTypes);

                                    if ($resultExaminationTypes->num_rows > 0) {
                                        // Loop4: Inner loop for each examination type
                                        while ($rowExaminationType = $resultExaminationTypes->fetch_assoc()) {
                                            $strExaminationType = $rowExaminationType['examination_type_code'];
                                            $intScore = generateRandomScore();

                                            // Step 6: Insert examination result
                                            $sqlInsertResult = "INSERT INTO examination_results (student_admission_number, grade_subject_code, teacher_id, examination_type_code, examination_score)
                                                                VALUES ('$strAdmissionNumber', '$strGradeSubject', $intTeacher, '$strExaminationType', $intScore)";
                                            if ($conn->query($sqlInsertResult) !== TRUE) {
                                                echo "Error: " . $sqlInsertResult . "<br>" . $conn->error;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // Call the main function
        compileExaminationResults($conn);

        // Close connection
        $conn->close();

        // Display completion message
        echo "<h2>Examination results successfully compiled and database updated.</h2>";
    }
}
?>
