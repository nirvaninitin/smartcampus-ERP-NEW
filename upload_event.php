<?php
session_start();  // Start the session to check if the teacher is logged in

// Check if the user is logged in and is a teacher
if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch the form data
    $title = $_POST['title'] ?? '';
    $host = $_POST['host'] ?? '';
    $date = $_POST['date'] ?? '';
    $description = $_POST['description'] ?? '';

    // Check if any field is empty
    if (empty($title) || empty($host) || empty($date) || empty($description)) {
        $error = "All fields are required!";
    } else {
        // Connect to the database
        $conn = new mysqli("localhost", "root", "", "smartcampus_db");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL query to insert event
        $query = "INSERT INTO events (title, host, date, description) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $title, $host, $date, $description);

        // Execute the query and check if insertion is successful
        if ($stmt->execute()) {
            $success_message = "Event uploaded successfully!";
        } else {
            $error = "Failed to upload event. Please try again.";
        }

        // Close connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Event</title>
    <link rel="stylesheet" href="upload_event.css">
</head>
<body>
    <div class="sidebar">
        <!-- <div class="student-info">
            <h2><?php echo htmlspecialchars($_SESSION['teacher_name']); ?></h2>
        </div> -->
        <ul>
        <li><a href="teacher_dashboard.php">Dashboard</a></li>
            <li><a href="attendance.html">Mark Attendance</a></li>
            <li><a href="upload_assignment.html">Upload Assignment</a></li>
            <li><a href="upload_event.php" class="active">Events</a></li>
            <li><a href="teacher_view_timetable.html">View Timetable</a></li>
            <li><a href="forget_password_teacher.html">Forget or Update Password</a></li>
            <li><a href="logout.html">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h1>Upload Event</h1>
        </header>

        <div class="form-container">
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
            <?php if (isset($success_message)) { echo "<p class='success'>$success_message</p>"; } ?>

            <form action="upload_event.php" method="POST">
                <label for="title">Event Title</label>
                <input type="text" id="title" name="title" required>

                <label for="host">Event Host</label>
                <input type="text" id="host" name="host" required>

                <label for="date">Event Date</label>
                <input type="date" id="date" name="date" required>

                <label for="description">Event Description</label>
                <textarea id="description" name="description" rows="5" required></textarea>

                <button type="submit">Upload Event</button>
            </form>
        </div>
    </div>
</body>
</html>
