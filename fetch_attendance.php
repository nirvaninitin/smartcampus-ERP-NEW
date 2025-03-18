<?php
session_start();
include("db_connect.php");

$student_id = $_SESSION['student_id']; // Assuming student logs in and session holds ID

$sql = "SELECT attendance_date, status FROM attendance WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
?>
