<?php
// auth/register.php
include('../include/db.php');
include('../include/handle.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (register($username, $password)) {
        echo "Đăng ký thành công!";
    } else {
        echo "Đăng ký thất bại!";
    }
}
?>
