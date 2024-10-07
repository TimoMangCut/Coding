<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submit Without Reload</title>
</head>
<body>

<form action="process.php" method="post">
    <!-- Đặt các trường input của bạn ở đây -->
    <input type="text" name="name" placeholder="Name">
    <input type="email" name="email" placeholder="Email">
    <button type="submit">Submit</button>
</form>

<!-- Kết quả sẽ được hiển thị ở đây -->
<div id="result">
    <?php
    var_dump($_SESSION['result']);
    if (isset($_SESSION['result'])) {
        echo $_SESSION['result'];
        unset($_SESSION['result']); // Xóa biến session sau khi hiển thị
    }
    ?>
</div>

</body>
</html>
