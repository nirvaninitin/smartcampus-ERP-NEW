<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartcampus_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userType = $_POST['userType'];
$course = isset($_POST['course']) ? $_POST['course'] : "";

if ($userType == "student") {
    $sql = "SELECT id, username, first_name AS name, email, course AS extraField FROM student WHERE course = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $course);
} else {
    $sql = "SELECT id, username, teacher_name AS name, email, subject AS extraField FROM teacher";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Username</th><th>Name</th><th>Email</th><th>Course/Subject</th><th>Action</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['username']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['extraField']}</td>
                <td><button class='updateBtn' data-id='{$row['id']}'>Update</button></td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}

$stmt->close();
$conn->close();
?>
