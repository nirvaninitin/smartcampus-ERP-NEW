<?php
session_start();
// if (!isset($_SESSION['admin_name'])) {
//     header("Location: admin_login.php");
//     exit;
// }

include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course = $_POST["course"];
    $section = $_POST["section"];
    $semester = $_POST["semester"];
    $role = $_POST["role"]; // 'student' or 'teacher'

    // File Upload
    $targetDir = "uploads/timetables/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = basename($_FILES["timetable"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["timetable"]["tmp_name"], $targetFilePath)) {
        // Store in database
        $sql = "INSERT INTO timetables (course, section, semester, role, timetable_file) 
                VALUES ('$course', '$section', '$semester', '$role', '$targetFilePath')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Timetable uploaded successfully!'); window.location.href='admin_upload_timetable.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "File upload failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Timetable</title>
    <style>
        /* General Styling */
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

        .sidebar h2 {
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #ecf0f1;
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

        /* Main Content */
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

        h2 {
            color: #007bff;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        /* Form Styling */
        form {
            width: 100%;
            max-width: 500px;
            margin: auto;
            background: #ecf0f1;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            font-size: 1.1rem;
            margin-bottom: 5px;
            color: #333;
            text-align: left;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        input[type="file"] {
            border: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #3498db;
            color: white;
            font-size: 1.2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
        <li><a href="admin.html">Dashboard</a></li>
            <li><a href="add-student.html">Add Student</a></li>
            <li><a href="add-teacher.html">Add Teacher</a></li>
            <li><a href="delete_user.php">Delete User</a></li>
            <li><a href="update_user.php">Update User</a></li>
            <li><a href="admin_upload_timetable.php">Upload Time-table Student</a></li>
            <li><a href="admin_upload_timetable_teacher.html">Upload Time-table Teacher</a></li>
            <li><a href="admin_upload_result.html">Upload Result</a></li>
            <li><a href="admin-reports.html">View Reports</a></li>
            <li><a href="forget_password_admin.html">Forget or Update Password</a></li>
            <li><a href="logout.html">Logout</a></li>

        </ul>
    </div>

    <div class="container">
        <h2>Upload Timetable</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <label>Course:</label>
            <input type="text" name="course" required>

            <label>Section:</label>
            <input type="text" name="section" required>

            <label>Semester:</label>
            <input type="text" name="semester" required>

            <label>Upload Timetable (PDF, Image):</label>
            <input type="file" name="timetable" accept=".pdf, .jpg, .png" required>

            <label>For:</label>
            <select name="role">
                <option value="student">Student</option>
                <!-- <option value="teacher">Teacher</option> -->
            </select>

            <button type="submit">Upload</button>
        </form>
    </div>
</body>
</html>
