<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartcampus_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch courses from the database
$courseQuery = "SELECT DISTINCT course FROM student";
$courseResult = $conn->query($courseQuery);

$courses = [];
if ($courseResult->num_rows > 0) {
    while ($row = $courseResult->fetch_assoc()) {
        $courses[] = $row['course'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- jQuery (for AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="delete_style.css">
</head>
<body>

    <!-- Sidebar -->
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

    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-4">
            <div class="alert alert-light shadow-sm">
                <h2 class="fw-bold">Delete Student or Teacher</h2>
            </div>

            <div class="card p-4">
                <!-- Dropdown to Select Student or Teacher -->
                <label for="userType" class="form-label">Select User Type:</label>
                <select id="userType" class="form-select">
                    <option value="">Select User Type</option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                </select>

                <!-- Course Dropdown (Hidden Initially) -->
                <div id="courseSelection" class="mt-3" style="display: none;">
                    <label for="courseSelect" class="form-label">Select Course:</label>
                    <select id="courseSelect" class="form-select">
                        <option value="">Select Course</option>
                        <?php foreach ($courses as $course) { ?>
                            <option value="<?= $course; ?>"><?= $course; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <!-- Table to Display Students/Teachers -->
            <div class="mt-4" id="userTable"></div>
        </div>
    </div>

    <script>
    $(document).ready(function(){
        // When user type is selected
        $("#userType").change(function(){
            var userType = $(this).val();
            if (userType === "student") {
                $("#courseSelection").show(); // Show course dropdown
                $("#userTable").html(""); // Clear table
            } else {
                $("#courseSelection").hide();
                fetchUsers(userType, ""); // Fetch teachers
            }
        });

        // When course is selected
        $("#courseSelect").change(function(){
            var course = $(this).val();
            fetchUsers("student", course); // Fetch students by course
        });

        // Function to fetch users and display table
        function fetchUsers(userType, course) {
            $.ajax({
                url: "fetch_users.php",
                type: "POST",
                data: { userType: userType, course: course },
                success: function(response) {
                    $("#userTable").html(response);
                }
            });
        }

        // Delete user
        $(document).on("click", ".deleteBtn", function(){
            var userId = $(this).data("id");
            var userType = $("#userType").val();

            if (confirm("Are you sure you want to delete this " + userType + "?")) {
                $.ajax({
                    url: "delete_user_action.php",
                    type: "POST",
                    data: { id: userId, userType: userType },
                    success: function(response) {
                        alert(response);
                        $("#userType").change(); // Refresh table
                    }
                });
            }
        });
    });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
