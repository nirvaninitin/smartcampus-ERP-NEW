<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $sql = "DELETE FROM results WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        echo "Result deleted successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
