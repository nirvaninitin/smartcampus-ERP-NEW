<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartcampus_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$username = $_POST['username'];
$name = $_POST['name'];
$email = $_POST['email'];
$extraField = $_POST['extraField'];
$userType = $_POST['userType'];

if ($userType == "student") {
    $sql = "UPDATE student SET username = ?, first_name = ?, email = ?, course = ? WHERE id = ?";
} else {
    $sql = "UPDATE teacher SET username = ?, teacher_name = ?, email = ?, subject = ? WHERE id = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $username, $name, $email, $extraField, $id);

if ($stmt->execute()) {
    echo "User updated successfully!";
} else {
    echo "Error updating user: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
