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
    if (empty($course)) {
        echo "<p class='text-danger'>Please select a course.</p>";
        exit;
    }
    
    $sql = "SELECT id, username, first_name, email, course FROM student WHERE course = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $course);
} else {
    $sql = "SELECT id, username, teacher_name, email, subject FROM teacher";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table class='table table-bordered mt-3'>";
    echo "<tr>";
    
    if ($userType == "student") {
        echo "<th>ID</th><th>Username</th><th>Name</th><th>Email</th><th>Course</th><th>Action</th></tr>";
    } else {
        echo "<th>ID</th><th>Username</th><th>Name</th><th>Email</th><th>Subject</th><th>Action</th></tr>";
    }

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['username']}</td>
                <td>" . ($userType == "student" ? $row['first_name'] : $row['teacher_name']) . "</td>
                <td>{$row['email']}</td>";
        if ($userType == "student") {
            echo "<td>{$row['course']}</td>";
        } else {
            echo "<td>{$row['subject']}</td>";
        }
        echo "<td><button class='btn btn-danger deleteBtn' data-id='{$row['id']}'>Delete</button></td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "<p class='text-danger'>No records found.</p>";
}

$stmt->close();
$conn->close();
?>
