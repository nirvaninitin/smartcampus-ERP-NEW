<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <link rel="stylesheet" href="attendance.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="sidebar">
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
<div class="main-content">
    <div class="graph-container">
        <h2>My Attendance Record</h2>
        <canvas id="attendanceChart"></canvas>
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch("fetch_attendance.php")
                .then(response => response.json())
                .then(data => {
                    let dates = [];
                    let attendanceStatus = [];

                    data.forEach(record => {
                        dates.push(record.attendance_date);
                        attendanceStatus.push(record.status === "P" ? 1 : 0);
                    });

                    let ctx = document.getElementById("attendanceChart").getContext("2d");
                    new Chart(ctx, {
                        type: "bar",  // Changed to 'bar' for bar chart
                        data: {
                            labels: dates,
                            datasets: [{
                                label: "Attendance",
                                data: attendanceStatus,
                                backgroundColor: attendanceStatus.map(status => status === 1 ? "green" : "red"),
                                borderColor: attendanceStatus.map(status => status === 1 ? "darkgreen" : "darkred"),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    ticks: {
                                        callback: function(value) {
                                            return value === 1 ? "Present" : "Absent";
                                        }
                                    },
                                    min: 0,
                                    max: 1
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error("Error fetching attendance:", error));
        });
    </script>
    </div>
</div>
</body>
</html>
