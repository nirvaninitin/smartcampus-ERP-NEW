<?php
session_start();

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    echo "Student not logged in.";
    exit;
}

// Database connection
$conn = new mysqli("localhost", "root", "", "smartcampus_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch student data for pre-filling form
$student_id = $_SESSION['student_id'];
$query = "SELECT * FROM student WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

// Initialize variables for messages
$message = "";
$isSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and fetch form inputs
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $dob = $_POST['dob'];
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $section = htmlspecialchars($_POST['section']);  // Added section field

    // Handle file uploads
    $photo = $student['photo'];
    if (!empty($_FILES['photo']['name'])) {
        $photo = "uploads/" . uniqid() . "_" . basename($_FILES['photo']['name']);
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photo)) {
            $message = "Failed to upload profile photo.";
        }
    }

    $signature = $student['signature'];
    if (!empty($_FILES['signature']['name'])) {
        $signature = "uploads/" . uniqid() . "_" . basename($_FILES['signature']['name']);
        if (!move_uploaded_file($_FILES['signature']['tmp_name'], $signature)) {
            $message = "Failed to upload signature.";
        }
    }

    $documents = $student['documents'];
    if (!empty($_FILES['documents']['name'][0])) {
        try {
            $uploadedDocs = array_map(function ($key) {
                $fileName = uniqid() . "_" . basename($_FILES['documents']['name'][$key]);
                $target = "uploads/" . $fileName;
                if (move_uploaded_file($_FILES['documents']['tmp_name'][$key], $target)) {
                    return $target;
                } else {
                    throw new Exception("Failed to upload document: " . $_FILES['documents']['name'][$key]);
                }
            }, array_keys($_FILES['documents']['name']));
            $documents = implode(",", $uploadedDocs);
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
    }

    // Update student table including section
    $query = "UPDATE student SET first_name = ?, last_name = ?, dob = ?, email = ?, phone = ?, address = ?, photo = ?, signature = ?, documents = ?, section = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssssi", $first_name, $last_name, $dob, $email, $phone, $address, $photo, $signature, $documents, $section, $student_id);

    if ($stmt->execute()) {
        $message = "Profile updated successfully!";
        $isSuccess = true;
    } else {
        $message = "Error updating profile: " . $stmt->error;
    }
}

// Close database connections
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Update</title>
    <link rel="stylesheet" href="profile-update.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- <div class="student-info">
            <h2><?php echo htmlspecialchars($_SESSION['student_name']); ?></h2>
            <p><strong>Class:</strong> <?php echo htmlspecialchars($_SESSION['course']); ?> - Semester <?php echo htmlspecialchars($_SESSION['semester']); ?></p>
            <p><strong>Roll No:</strong> <?php echo htmlspecialchars($_SESSION['student_id']); ?></p>
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
            <h1>Profile Update</h1>
            <p>Keep your profile updated with the latest information.</p>
        </header>

        <section class="content">
            <!-- Display Message -->
            <?php if (!empty($message)): ?>
                <p style="color: <?php echo $isSuccess ? 'green' : 'red'; ?>;"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>

            <!-- Profile Update Form -->
            <form action="profile-update.php" method="POST" enctype="multipart/form-data" class="profile-form">
                <!-- Personal Details -->
                <h3>Personal Details</h3>
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($student['dob']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>" pattern="[0-9]{10}" required>
                </div>

                <!-- Address -->
                <h3>Address</h3>
                <div class="form-group">
                    <label for="address">Full Address</label>
                    <textarea id="address" name="address" rows="4" required><?php echo htmlspecialchars($student['address']); ?></textarea>
                </div>

                <!-- Section Field -->
                <h3>Section</h3>
                <div class="form-group">
                    <label for="section">Section</label>
                    <input type="text" id="section" name="section" value="<?php echo htmlspecialchars($student['section']); ?>" required>
                </div>

                <!-- Upload Documents -->
                <h3>Upload Documents</h3>
                <div class="form-group">
                    <label for="photo">Profile Photo</label>
                    <input type="file" id="photo" name="photo" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="signature">Signature</label>
                    <input type="file" id="signature" name="signature" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="documents">Relevant Documents</label>
                    <input type="file" id="documents" name="documents[]" multiple>
                </div>

                <button type="submit" class="btn">Update Profile</button>
            </form>
        </section>
    </div>
</body>
</html>
