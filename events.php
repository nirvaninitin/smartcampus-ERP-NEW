<?php
session_start();  // Start the session at the top of the file

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// If the student is logged in, proceed with displaying the events page
// Connect to the database
$conn = new mysqli("localhost", "root", "", "smartcampus_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch events from the database
$query = "SELECT * FROM events ORDER BY date ASC"; // Adjust query if needed
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Events</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="events.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- <div class="student-info">
            <h2><?php echo htmlspecialchars($_SESSION['student_name']); ?></h2>
            <p><?php echo htmlspecialchars($_SESSION['course']) . ' - ' . $_SESSION['semester']; ?></p>
        </div> -->
        <h2>Student Dashboard</h2>
        <ul>
        <li><a href="student-dashboard.php">Dashboard</a></li>
            <li><a href="events.php">Events</a></li>
            <li><a href="view_assignment.php">Assignments</a></li>
            <li><a href="profile-update.php">Profile Update</a></li>
            <li><a href="view_attendance.php">Attendance</a></li>
            <li><a href="view_timtable_student.php">Time-table</a></li>
            <li><a href="student_view_result.html">Result</a></li>
            <li><a href="forgot_password_student.html">Forget or Update Password</a></li>
            <li><a href="logout.html">Logout</a></li>

        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['student_name']); ?>!</h1>
            <p>Check out the upcoming events</p>
        </header>

        <div class="event-list">
            <h2>Upcoming Events</h2>

            <?php
            // Check if there are any events to display
            if ($result->num_rows > 0) {
                // Output each event
                while ($event = $result->fetch_assoc()) {
                    echo "<div class='event'>";
                    echo "<h3>" . htmlspecialchars($event['title']) . "</h3>";
                    echo "<p><strong>Host:</strong> " . htmlspecialchars($event['host']) . "</p>";
                    echo "<p><strong>Date:</strong> " . htmlspecialchars($event['date']) . "</p>";
                    echo "<p>" . nl2br(htmlspecialchars($event['description'])) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No upcoming events.</p>";
            }

            // Close the connection
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
