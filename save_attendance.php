<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartcampus_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$attendance_date = $_POST['attendance_date'] ?? null;
$class_type = $_POST['class_type'] ?? null;
$topic_covered = $_POST['topic_covered'] ?? null;
$subject_name = $_POST['subject_name'] ?? null;
$default_status = $_POST['default_status'] ?? null;
$course = $_POST['course'] ?? null;
$section = $_POST['section'] ?? null;
$attendance = $_POST['attendance'] ?? [];

if (!$attendance_date || !$class_type || !$subject_name || !$course || !$section) {
    die("Error: Missing required fields!");
}

foreach ($attendance as $student_id => $status) {
    $sql = "INSERT INTO attendance (student_id, attendance_date, class_type, topic_covered, subject_name, status, course, section) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssss", $student_id, $attendance_date, $class_type, $topic_covered, $subject_name, $status, $course, $section);
    $stmt->execute();
}

echo "Attendance saved successfully!";
echo "<br><a href='teacher_dashboard.php'>Go to Dashboard</a>";
$stmt->close();
$conn->close();
?>
