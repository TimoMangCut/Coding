<?php
session_start();

// Kiểm tra nếu người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Kết nối cơ sở dữ liệu
require_once 'db.php'; 

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param("i", $user_id);

if (!$stmt->execute()) {
    die('Execute failed: ' . htmlspecialchars($stmt->error));
}

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die('No user found with that ID.');
}

// Lấy thông tin đơn hàng
$order_stmt = $conn->prepare("
    SELECT o.id as order_id, o.total_cost, o.order_date, o.status, oi.product_id, oi.quantity, p.name 
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON oi.product_id = p.id
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC
");
if ($order_stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$order_stmt->bind_param("i", $user_id);

if (!$order_stmt->execute()) {
    die('Execute failed: ' . htmlspecialchars($order_stmt->error));
}

$order_result = $order_stmt->get_result();
$orders = [];
while ($order = $order_result->fetch_assoc()) {
    $order['expected_delivery_date'] = date('Y-m-d', strtotime($order['order_date'] . ' + 3 days'));
    
    // Thay đổi trạng thái đơn hàng
    switch ($order['status']) {
        case 'pending':
            $order['status'] = 'Đơn hàng đang chờ xử lí';
            break;
        case 'cancle':
            $order['status'] = 'Đơn hàng bị huỷ';
            break;
        case 'complete':
            $order['status'] = 'Đơn hàng đang được giao';
            break;
    }
    
    $orders[$order['order_id']][] = $order;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        body {
            background-image: url('https://images.pexels.com/photos/1831234/pexels-photo-1831234.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');
            background-size: cover;
            background-position: center;
        }
    </style>
    <script>
        function confirmLogout() {
            $('#logoutModal').modal('show');
        }

        function handleLogout(action) {
            if (action === 'yes') {
                window.location.href = 'logout.php';
            } else {
                $('#logoutModal').modal('hide');
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h1>Profile Page</h1>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        <button class="btn btn-primary" onclick="window.location.href = 'index.php';">Trở về Trang chủ</button>
        <button class="btn btn-primary" onclick="confirmLogout()">Đăng xuất</button>
        <br>
        <br>

        <h2>Đơn hàng của bạn</h2>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá tiền</th>
                    <th>Ngày đặt hàng</th>
                    <th>Trạng thái đơn hàng</th>
                    <th>Thời gian dự kiến nhận hàng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order_id => $order_items): ?>
                    <?php foreach ($order_items as $index => $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['name']); ?></td>
                        <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                        <?php if ($index === 0): ?>
                        <td rowspan="<?php echo count($order_items); ?>"><?php echo htmlspecialchars($order['total_cost']); ?></td>
                        <td rowspan="<?php echo count($order_items); ?>"><?php echo htmlspecialchars($order['order_date']); ?></td>
                        <td rowspan="<?php echo count($order_items); ?>"><?php echo htmlspecialchars($order['status']); ?></td>
                        <td rowspan="<?php echo count($order_items); ?>"><?php echo htmlspecialchars($order['expected_delivery_date']); ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal HTML -->
    <div class="modal" id="logoutModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Đăng xuất?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn đăng xuất?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="handleLogout('yes')">Có</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="handleLogout('no')">Không</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
