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
    <title>Update User</title>
    <link rel="stylesheet" href="update_style.css"> <!-- Link to CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
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
    <h2>Update Student or Teacher</h2>

    <!-- Dropdown to Select Student or Teacher -->
    <select id="userType">
        <option value="">Select User Type</option>
        <option value="student">Student</option>
        <option value="teacher">Teacher</option>
    </select>

    <!-- Course Dropdown (Initially Hidden) -->
    <select id="courseSelect" style="display:none;">
        <option value="">Select Course</option>
        <?php foreach ($courses as $course) { ?>
            <option value="<?= htmlspecialchars($course); ?>"><?= htmlspecialchars($course); ?></option>
        <?php } ?>
    </select>

    <!-- Table to Display Users -->
    <div id="userTable"></div>

    <!-- Update Form (Hidden Initially) -->
    <div id="updateFormContainer" style="display:none;">
        <h3>Update User</h3>
        <form id="updateForm">
            <input type="hidden" id="userId">
            <label for="username">Username:</label>
            <input type="text" id="username" required>

            <label for="name">Full Name:</label>
            <input type="text" id="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" required>

            <label for="extraField">Course/Subject:</label>
            <input type="text" id="extraField" required>

            <button type="submit">Update</button>
        </form>
    </div>
</div>

<script>
$(document).ready(function(){
    // When user type is selected
    $("#userType").change(function(){
        var userType = $(this).val();
        if (userType === "student") {
            $("#courseSelect").show(); // Show course dropdown
            $("#userTable").html(""); // Clear table
        } else {
            $("#courseSelect").hide();
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
            url: "update_fetch_users.php",
            type: "POST",
            data: { userType: userType, course: course },
            success: function(response) {
                $("#userTable").html(response);
            }
        });
    }

    // Open update form with user data
    $(document).on("click", ".updateBtn", function(){
        var userId = $(this).data("id");
        var userType = $("#userType").val();

        $.ajax({
            url: "get_user_details.php",
            type: "POST",
            data: { id: userId, userType: userType },
            success: function(response) {
                var user = JSON.parse(response);
                $("#userId").val(user.id);
                $("#username").val(user.username);
                $("#name").val(user.name);
                $("#email").val(user.email);
                $("#extraField").val(user.extraField);
                $("#updateFormContainer").show();
            }
        });
    });

    // Submit update form
    $("#updateForm").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: "update_user_action.php",
            type: "POST",
            data: {
                id: $("#userId").val(),
                username: $("#username").val(),
                name: $("#name").val(),
                email: $("#email").val(),
                extraField: $("#extraField").val(),
                userType: $("#userType").val()
            },
            success: function(response) {
                alert(response);
                $("#updateFormContainer").hide();
                $("#userType").change(); // Refresh table
            }
        });
    });
});
</script>

</body>
</html>
