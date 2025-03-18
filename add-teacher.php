<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartcampus_db"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $teacher_name = $_POST['teacher_name'];
    $experience = $_POST['experience'];
    $education = $_POST['education'];
    $subject = $_POST['subject'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // SQL query to insert teacher data
    $sql = "INSERT INTO teacher (username, password, teacher_name, experience, education, subject, email, phone, address)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisssss", $username, $password, $teacher_name, $experience, $education, $subject, $email, $phone, $address);

    if ($stmt->execute()) {
        echo "Teacher added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
}

// Close the connection
$conn->close();
echo "<br><a href='admin.html'>Back To Admin Dashboard</a>";
?>
