<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "smartcampus_db";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'], $_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $new_password = $_POST['password'];

        // Password Validation (At least 8 characters, 1 uppercase, 1 lowercase, 1 number, 1 special character)
        if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $new_password)) {
            echo "Cannot update password. Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
            echo "<br><a href='javascript:history.back()'>Go Back</a>";
            exit;
        }

        // Update password in the database (WITHOUT hashing)
        $sql = "UPDATE admins SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $new_password, $username);

        if ($stmt->execute()) {
            echo "Password updated successfully.";
        } else {
            echo "Error updating password: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Please fill in all required fields.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
echo "<br><a href='admin_login.php'>LOGIN AGAIN</a>";
?>
