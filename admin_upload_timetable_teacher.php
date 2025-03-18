<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "smartcampus_db");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Retrieve form data
$teacher_id = $_POST['teacher_id'];
$day = $_POST['day'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$course = $_POST['course'];
$section = $_POST['section'];
$subject = $_POST['subject'];
$room = $_POST['room'];

// Prepare SQL statement
$sql = "INSERT INTO teacher_timetable (teacher_id, day, start_time, end_time, course, section, subject, room) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error); // Debugging line
}

$stmt->bind_param("isssssss", $teacher_id, $day, $start_time, $end_time, $course, $section, $subject, $room);

if ($stmt->execute()) {
    echo "<script>alert('Timetable uploaded successfully!'); window.location.href='admin_upload_timetable_teacher.html';</script>";
} else {
    echo "<script>alert('Error uploading timetable!'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
