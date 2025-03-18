<?php
session_start();
if (!isset($_SESSION['teacher_name'])) {
    header("Location: teacher_login.html");
    exit;
}

include "db_connect.php";

// Fetch teacher details from session
$course = $_SESSION["course"];
$semester = $_SESSION["semester"];

// Fetch timetable for teacher
$sql = "SELECT timetable_file FROM timetables 
        WHERE course='$course' AND semester='$semester' AND role='teacher'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="styles_admin_student_teacher_timetable.css">

</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['teacher_name']; ?></h1>
    <h2>Your Timetable</h2>

    <?php
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo "<a href='" . $row['timetable_file'] . "' target='_blank'>View Timetable</a>";
    } else {
        echo "<p>No timetable uploaded yet.</p>";
    }
    ?>
</body>
</html>
