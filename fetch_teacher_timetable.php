<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$conn = mysqli_connect("localhost", "root", "", "smartcampus_db");

// Check connection
if (!$conn) {
    die(json_encode(["error" => "Connection failed: " . mysqli_connect_error()]));
}

// Get the teacher ID (ensure it's received correctly)
if (!isset($_GET['teacher_id'])) {
    die(json_encode(["error" => "Teacher ID is required"]));
}

$teacher_id = intval($_GET['teacher_id']); // Ensure it's an integer to prevent SQL injection

// Fetch timetable for the given teacher ID
$query = "SELECT * FROM teacher_timetable WHERE teacher_id = ?";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die(json_encode(["error" => "SQL Prepare Error: " . mysqli_error($conn)]));
}

// Bind parameter and execute
mysqli_stmt_bind_param($stmt, "i", $teacher_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die(json_encode(["error" => "SQL Execution Error: " . mysqli_error($conn)]));
}

// Fetch all timetable records
$timetableData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $timetableData[] = $row;
}

// Close connections
mysqli_stmt_close($stmt);
mysqli_close($conn);

// Return JSON response
header("Content-Type: application/json");
echo json_encode($timetableData);
