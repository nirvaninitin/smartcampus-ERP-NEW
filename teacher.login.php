<?php
session_start();  // Start the session at the top of the file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch email (username) and password from the form
    $email = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check if the fields are not empty
    if (empty($email) || empty($password)) {
        echo "Email or password cannot be empty.";
        exit;
    }

    // Proceed with login logic
    $conn = new mysqli("localhost", "root", "", "smartcampus_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to validate login using email
    $query = "SELECT * FROM teacher WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);  // Bind email to the query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $teacher = $result->fetch_assoc();
        
        // Check if the password matches (assuming the password is stored in plain text; consider hashing passwords for security)
        if ($password === $teacher['password']) {  // Change this line if you want to match against password field
            // Set session variables for teacher info
            $_SESSION['teacher_id'] = $teacher['id'];
            $_SESSION['teacher_name'] = $teacher['teacher_name'];  // Use teacher_name from the table
            $_SESSION['email'] = $teacher['email'];

            // Redirect to teacher dashboard
            header("Location: teacher_dashboard.php");
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid email.";
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
