<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("localhost", "root", "", "smartcampus_db");

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Correct SQL query with actual column name
$query = "SELECT id, teacher_name FROM teacher"; 
$result = $conn->query($query);

// Check if query executed successfully
if (!$result) {
    die("SQL Query Failed: " . $conn->error);
}

// Generate dropdown options
$options = "<option value=''>Select a teacher</option>";
while ($row = $result->fetch_assoc()) {
    $options .= "<option value='{$row['id']}'>{$row['teacher_name']} (ID: {$row['id']})</option>";
}

// Output options for AJAX request
echo $options;

// Close connection
$conn->close();
?>
