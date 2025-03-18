<?php
include 'db_connect.php'; 

if(isset($_POST['submit'])) {
    $teacher_name = $_POST['teacher_name'];
    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $section = $_POST['section'];
    $deadline = $_POST['deadline'];

    $file_name = $_FILES['assignment_file']['name'];
    $file_tmp = $_FILES['assignment_file']['tmp_name'];
    $upload_dir = "uploads/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_path = $upload_dir . basename($file_name);
    
    if (move_uploaded_file($file_tmp, $file_path)) {
        $query = "INSERT INTO assignments (teacher_name, course, semester, section, file_name, file_path, deadline) 
                  VALUES ('$teacher_name', '$course', '$semester', '$section', '$file_name', '$file_path', '$deadline')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>alert('Assignment uploaded successfully!'); window.location.href='upload_assignment.html';</script>";
        } else {
            echo "<script>alert('Database error!'); window.location.href='upload_assignment.html';</script>";
        }
    } else {
        echo "<script>alert('File upload failed!'); window.location.href='upload_assignment.html';</script>";
    }
}
?>
