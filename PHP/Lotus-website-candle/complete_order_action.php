<?php
// Kết nối tới cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lotus";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $action = $_POST['action'];

    if ($action === 'complete') {
        // Xử lý hoàn tất đơn hàng (cập nhật trạng thái đơn hàng)
        $stmt = $conn->prepare("UPDATE orders SET status = 'completed' WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        echo "Order has been completed.";
    } elseif ($action === 'cancel') {
        // Xử lý hủy đơn hàng (cập nhật trạng thái đơn hàng)
        $stmt = $conn->prepare("UPDATE orders SET status = 'cancelled' WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        echo "Order has been cancelled.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
