<?php
session_start();
include "db_connect.php";
if (!isset($_SESSION['student_name'])) {
    header("Location: login.html");
    exit;
}
// Fetch student details from session
$course = $_SESSION["course"];
$section = $_SESSION["section"];
$semester = $_SESSION["semester"];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Assignments</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
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

        .sidebar ul li a:hover {
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
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background: #007bff;
            color: white;
            font-size: 1rem;
            text-transform: uppercase;
        }

        td {
            background: #f9f9f9;
            font-size: 1rem;
        }

        tr:nth-child(even) td {
            background: #eef2f3;
        }

        /* Download Link */
        a {
            color: #1abc9c;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease-in-out;
        }

        a:hover {
            color: #16a085;
            text-decoration: underline;
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
        <h2>Assignments</h2>
        <table>
            <tr>
                <th>Teacher</th>
                <th>Course</th>
                <th>Semester</th>
                <th>Section</th>
                <th>Deadline</th>
                <th>Download</th>
            </tr>
            <?php
            include 'db_connect.php'; 
            
            $query = "SELECT * FROM assignments ORDER BY uploaded_at DESC";
            $result = mysqli_query($conn, $query);
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>".$row['teacher_name']."</td>
                        <td>".$row['course']."</td>
                        <td>".$row['semester']."</td>
                        <td>".$row['section']."</td>
                        <td>".$row['deadline']."</td>
                        <td><a href='".$row['file_path']."' download='".$row['file_name']."'>Download</a></td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
