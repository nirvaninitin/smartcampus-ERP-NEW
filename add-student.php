<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartcampus_db"; 

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data from admin
    $username = $_POST['username'];
    $password = $_POST['password']; // Plain text password (should be hashed)
    $first_name = $_POST['first_name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $section = $_POST['section'];

    // Prepare SQL statement
    $sql = "INSERT INTO student (username, password, first_name, email, course, semester, section)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssis", $username, $password, $first_name, $email, $course, $semester, $section);

    if ($stmt->execute()) {
        echo "Student added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
}

$conn->close();
echo "<br><a href='admin.html'>Back To Admin Dashboard</a>";

?>
