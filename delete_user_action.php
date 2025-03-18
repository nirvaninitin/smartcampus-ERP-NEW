<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartcampus_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $userType = $_POST['userType'];

    if ($userType == "student") {
        $sql = "DELETE FROM student WHERE id = ?";
    } else {
        $sql = "DELETE FROM teacher WHERE id = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo htmlspecialchars(ucfirst($userType)) . " deleted successfully!";
    } else {
        echo "Error deleting " . $userType . ": " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
