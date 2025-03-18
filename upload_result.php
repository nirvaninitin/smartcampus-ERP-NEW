<?php
include "db_connect.php";

$student_id = $_POST['student_id'];

$uploadDir = "uploads/";
$fileName = basename($_FILES["result_file"]["name"]);
$filePath = $uploadDir . time() . "_" . $fileName;

if (move_uploaded_file($_FILES["result_file"]["tmp_name"], $filePath)) {
    $query = "INSERT INTO results (student_id, file_path) VALUES ('$student_id', '$filePath')";
    mysqli_query($conn, $query);
    echo "Result uploaded successfully!";
} else {
    echo "Error uploading file.";
}
?>
