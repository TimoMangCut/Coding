<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
    if(isset($_SERVER["REQUEST_METHOD"])&& $_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        if (!empty($username)&& !empty( $password)) {
            $checkUser = "SELECT * FROM username WHERE username = '$username' AND password = '$password';";
            $result = $conn->query($checkUser);
            if ($result->num_rows > 0) {
                $_SESSION["username"] = $username;
                // $success = "Chuc mung ban da dang nhap thanh cong";
                header("Location:web.php");
                exit();
            }
            else{
                $error = "Invalid username or password";
            }
            
        }
        
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dang nhap</title>
</head>
<body>
    <h2>Dang nhap</h2>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Dang nhap</button>
        <p>Ban chua co tai khoan? <a href="register.php">Dang ky</a></p>
    </form>
</body>
</html>