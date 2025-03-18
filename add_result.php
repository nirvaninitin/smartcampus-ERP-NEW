<?php
include 'db_connect.php'; // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $subject = $_POST['subject'];
    $marks_obtained = $_POST['marks_obtained'];
    $total_marks = $_POST['total_marks'];

    // Calculate grade
    $percentage = ($marks_obtained / $total_marks) * 100;
    if ($percentage >= 90) {
        $grade = "A+";
    } elseif ($percentage >= 80) {
        $grade = "A";
    } elseif ($percentage >= 70) {
        $grade = "B";
    } elseif ($percentage >= 60) {
        $grade = "C";
    } elseif ($percentage >= 50) {
        $grade = "D";
    } else {
        $grade = "F";
    }

    $sql = "INSERT INTO results (student_id, course, semester, subject, marks_obtained, total_marks, grade)
            VALUES ('$student_id', '$course', '$semester', '$subject', '$marks_obtained', '$total_marks', '$grade')";

    if (mysqli_query($conn, $sql)) {
        echo "Result added successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
