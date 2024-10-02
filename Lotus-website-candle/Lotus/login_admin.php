<?php
session_start();
include 'db.php';  // Đảm bảo tệp này chứa kết nối cơ sở dữ liệu

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra nếu người dùng là admin
    if ($username === 'admin_lotus@gmail.com' && $password === 'adminpro') {
        // Bắt đầu phiên và thiết lập người dùng đã đăng nhập
        $_SESSION['user_id'] = 5;
        $_SESSION['username'] = $username;
        header("Location: admin.php");
        exit();
    } else {
        $error_message = "Tên đăng nhập hoặc mật khẩu không đúng";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="login_admin.css">
</head>
<body>
<div class="login">
    <div class="heading">
        <h2>Đăng nhập</h2>
        <form method="POST" action="login_admin.php">
            <div class="input-group input-group-lg">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" name="username" placeholder="Tên đăng nhập hoặc email" required>
            </div>

            <div class="input-group input-group-lg">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" name="password" placeholder="Mật khẩu" required>
            </div>

            <button type="submit" class="float">Đăng nhập</button>
        </form>
        <?php
        if (isset($error_message)) {
            echo '<div class="error">' . $error_message . '</div>';
        }
        ?>
    </div>
</div>
</body>
</html>
