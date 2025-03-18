<?php
session_start();

if (!isset($_SESSION['student_name'])) {
    header("Location: login.html");
    exit;
}

include "db_connect.php";

// Fetch student details from session
$course = $_SESSION["course"];
$section = $_SESSION["section"];
$semester = $_SESSION["semester"];

// Fetch timetable for student
$sql = "SELECT timetable_file FROM timetables 
        WHERE course='$course' AND section='$section' AND semester='$semester' AND role='student'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
        }

        .sidebar .student-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar .student-info h2 {
            font-size: 1.5rem;
            color: #ecf0f1;
        }

        .sidebar .student-info p {
            font-size: 1rem;
            color: #bdc3c7;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: white;
            font-size: 1.1rem;
            display: block;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s, transform 0.2s;
        }

        .sidebar ul li a:hover, .sidebar ul li a.active {
            background-color: #1abc9c;
            transform: scale(1.05);
        }

        /* Main Container */
        .container {
            width: 70%;
            margin: 90px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            margin-top: 50px;
            position: relative;
            left: 270px;
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        h2 {
            color: #007bff;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        /* Timetable Link */
        .download-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            font-size: 1.1rem;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }

        .download-btn:hover {
            background-color:rgb(47, 141, 203);
        }

        /* No Timetable Message */
        .no-timetable {
            color: red;
            font-size: 1.2rem;
            font-weight: bold;
        }


    </style>
</head>
<body>
    <div class="sidebar">
        <!-- <div class="student-info">
            <h2><?php echo $_SESSION['student_name']; ?></h2>
            <p><strong>Course:</strong> <?php echo $course; ?></p>
            <p><strong>Semester:</strong> <?php echo $semester; ?></p>
        </div> -->
        <h2 style="color: white;">Student Dashboard</h2>
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

    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['student_name']; ?></h1>
        <h2>Your Timetable</h2>

        <?php
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo "<a class='download-btn' href='" . $row['timetable_file'] . "' target='_blank'>📄 View Timetable</a>";
        } else {
            echo "<p class='no-timetable'>No timetable uploaded yet.</p>";
        }
        ?>
    </div>
</body>
</html>
