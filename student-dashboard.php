<?php
session_start();
if (!isset($_SESSION['student_name'])) {
    header("Location: login.html");
    exit;
}

// Fetch session data
$studentName = $_SESSION['student_name'];
$course = $_SESSION['course'];
$semester = $_SESSION['semester'];
// $photo = $_SESSION['photo'];
// $rollNumber = $_SESSION['roll_number'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="student-dashboard.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="student-info">
            <!-- <?php if ($photo): ?>
                <img src="uploads/<?php echo $photo; ?>" alt="Student Photo" class="student-photo">
            <?php endif; ?> -->
            <h2><?php echo $studentName; ?></h2>
            <p><strong>Course:</strong> <?php echo $course; ?></p>
            <p><strong>Semester:</strong> <?php echo $semester; ?></p>
            <!-- <p><strong>Roll No:</strong> <?php echo $rollNumber; ?></p> -->
        </div>
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
            <h1>Welcome, <?php echo $studentName; ?></h1>
            <p>Select an option from the menu to get started.</p>
        </header>
        <section class="quick-links">
            <h2>Dashboard</h2>
            <div class="links">
                <a href="events.php" class="card">Events</a>
                <a href="view_assignment.php" class="card">Assignments</a>
                <a href="profile-update.php" class="card">Profile Update</a>
                <a href="view_attendance.php" class="card">Attendance</a>
                <a href="view_timtable_student.php" class="card">Time-table</a>
                <a href="student_view_result.html" class="card">Result</a>
            </div>
        </section>
    </div>

    <script>
    let student_id = localStorage.getItem("student_id");
    if (!student_id) {
        alert("Error: Student ID is missing.");
        window.location.href = "login.html";
    } else {
        console.log("Student ID:", student_id);
    }
</script>
</body>
</html>
