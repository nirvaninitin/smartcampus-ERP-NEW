<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "smartcampus_db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get login details from form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to fetch admin details
    $query = "SELECT * FROM admins WHERE email = '$username' AND password = '$password'";
    
    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if query execution was successful
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Check if any rows are returned (valid login)
    if (mysqli_num_rows($result) > 0) {
        // Admin login successful, proceed to dashboard
        echo "Login successful";
        // Redirect to the admin dashboard
        header("Location: admin.html"); // Uncomment this when you have the dashboard page
    } else {
        // Invalid login details
        echo "Invalid username or password.";
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!-- HTML Form for Admin Login -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>

    <div class="login-container">
        <div class="login-box">
            <h2>Admin Login</h2>
            <form method="POST" action="admin_login.php">
                <div class="input-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="login-btn">Login</button>
            </form>
        </div>
    </div>

</body>
</html>
