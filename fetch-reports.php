<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartcampus_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
    $table = $_POST['table'];
    $query = "SELECT * FROM $table";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<table border='1'><tr>";

        while ($field = $result->fetch_field()) {
            echo "<th>{$field->name}</th>";
        }

        echo "</tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>{$value}</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No data found in this table.";
    }
}

$conn->close();
?>
