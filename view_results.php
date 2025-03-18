<?php
include "db_connect.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(["error" => "Missing student ID"]);
    exit;
}

$student_id = $_GET['id'];

$query = "SELECT file_path FROM results WHERE student_id='$student_id'";  // Ensure column exists
$result = mysqli_query($conn, $query);

$results = array();
while ($row = mysqli_fetch_assoc($result)) {
    $results[] = $row;
}

echo json_encode($results);
?>
