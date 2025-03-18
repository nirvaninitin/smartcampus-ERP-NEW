<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        echo "<script>alert('Username or password cannot be empty.'); window.location.href='login.html';</script>";
        exit;
    }

    $conn = new mysqli("localhost", "root", "", "smartcampus_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM student WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();

        if ($password === $student['password']) { // Plain text password check
            $_SESSION['student_id'] = $student['id'];
            $_SESSION['student_name'] = $student['first_name'] . " " . $student['last_name'];
            $_SESSION['course'] = $student['course'];
            $_SESSION['semester'] = $student['semester'];
            $_SESSION['section'] = $student['section'];

            // Store student ID in JavaScript localStorage
            echo "<script>
                localStorage.setItem('student_id', " . $student['id'] . ");
                window.location.href = 'student-dashboard.php';
            </script>";
            exit;
        } else {
            echo "<script>alert('Invalid password.'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('Invalid username.'); window.location.href='login.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
