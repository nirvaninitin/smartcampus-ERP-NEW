<?php
session_start();

// Check if teacher is logged in
if (!isset($_SESSION['teacher_id'])) {
    echo json_encode(["error" => "Unauthorized access. Please log in."]);
    exit;
}

// Database connection
$conn = new mysqli("localhost", "root", "", "smartcampus_db");

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

$teacher_id = $_SESSION['teacher_id'];

// Fetch timetable for the logged-in teacher
$query = "SELECT day, start_time, end_time, course, section, subject, room 
          FROM teacher_timetable 
          WHERE teacher_id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die(json_encode(["error" => "SQL Error: " . $conn->error]));
}

$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

$timetable = [];
while ($row = $result->fetch_assoc()) {
    $timetable[] = $row;
}

// Close connections
$stmt->close();
$conn->close();

// Return JSON response
header("Content-Type: application/json");
echo json_encode($timetable);
