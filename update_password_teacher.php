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
    if (isset($_POST['username']) && !empty($_POST['username'])) {
        $username = $_POST['username'];

        $sql = "SELECT * FROM teacher WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Update Password</title>
                    <style>
                        body{
                            font-family: Arial, sans-serif;
                            text-align: center;
                            margin-top: 50px;
                            background: url('image/homepage_bg.jpg') no-repeat center center/cover;
                            height: 100vh;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            flex-direction: column;
                            overflow-y: hidden;
                        }
                        form {
                            width: 300px;
                            margin: 0 auto;
                            padding: 20px;
                            background: white;
                            border-radius: 8px;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        }
                        input[type='password'], input[type='submit'] {
                            margin-top: 10px;
                            width: 100%;
                            padding: 8px;
                            border: 1px solid #ccc;
                            border-radius: 4px;
                            box-sizing: border-box;
                        }
                        input[type='submit'] {
                            background-color: #8672FF;
                            color: white;
                            border: none;
                            cursor: pointer;
                        }
                        input[type='submit']:hover {
                            background-color: #7c67f9;
                        }
                    </style>
                </head>
                <body>
                    <form action='update_password_teacher_action.php' method='POST'>
                        <input type='hidden' name='username' value='$username'>
                        <label for='password'>New Password:</label><br>
                        <input type='password' id='password' name='password' required><br>
                        <input type='submit' value='Update Password'>
                    </form>
                </body>
                </html>";
        } else {
            echo "Username not found.";
        }
        $stmt->close();
    } else {
        echo "Username field is empty.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
