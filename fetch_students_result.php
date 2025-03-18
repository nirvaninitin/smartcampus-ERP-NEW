<?php
include "db_connect.php";

// Ensure Content-Type is JSON
header("Content-Type: application/json");

$course = isset($_GET['course']) ? trim($_GET['course']) : "";
$semester = isset($_GET['semester']) ? trim($_GET['semester']) : "";
$section = isset($_GET['section']) ? trim($_GET['section']) : "";

if (empty($course) || empty($semester) || empty($section)) {
    echo json_encode([]);
    exit;
}

// Fetch students based on course, semester, and section
$query = "SELECT id, first_name, last_name FROM student WHERE course=? AND semester=? AND section=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sis", $course, $semester, $section);
$stmt->execute();
$result = $stmt->get_result();

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

// Return JSON response
echo json_encode($students);
?>
