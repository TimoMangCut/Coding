<?php
include 'db.php';

// Fetch completed and canceled orders
$sql = "SELECT 
            orders.id AS order_id,
            orders.user_id,
            orders.total_cost,
            orders.order_date,
            orders.status,
            order_items.product_id,
            order_items.quantity,
            addresses.city,
            addresses.district,
            addresses.ward,
            addresses.house_number,
            users.phone_number
        FROM orders
        JOIN order_items ON orders.id = order_items.order_id
        JOIN addresses ON orders.user_id = addresses.user_id
        JOIN users ON orders.user_id = users.id
        WHERE orders.status IN ('complete', 'cancel')
        ORDER BY orders.order_date DESC";

$result = $conn->query($sql);

$orders = array();
while ($row = $result->fetch_assoc()) {
    $order_id = $row['order_id'];
    if (!isset($orders[$order_id])) {
        $orders[$order_id] = array(
            'order_id' => $order_id,
            'user_id' => $row['user_id'],
            'total_cost' => $row['total_cost'],
            'order_date' => $row['order_date'],
            'status' => $row['status'],
            'city' => $row['city'],
            'district' => $row['district'],
            'ward' => $row['ward'],
            'house_number' => $row['house_number'],
            'phone_number' => $row['phone_number'],
            'products' => array()
        );
    }
    $orders[$order_id]['products'][] = array(
        'product_id' => $row['product_id'],
        'quantity' => $row['quantity']
    );
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Orders</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Order History</h2>
        <p class="mb-0"><a href="admin.php" class="text-body">Back to Admin-Page</a></p> <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Total Cost</th>
                    <th>Product ID</th>
                    <th>Quantity</th>
                    <th>City</th>
                    <th>District</th>
                    <th>Ward</th>
                    <th>House Number</th>
                    <th>Order Date</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <?php 
                        // Display the order information once
                        $first = true; 
                        foreach ($order['products'] as $product): 
                    ?>
                    <tr>
                        <?php if ($first): ?>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['total_cost']); ?></td>
                            <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                            <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($order['city']); ?></td>
                            <td><?php echo htmlspecialchars($order['district']); ?></td>
                            <td><?php echo htmlspecialchars($order['ward']); ?></td>
                            <td><?php echo htmlspecialchars($order['house_number']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td><?php echo htmlspecialchars($order['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                            <?php $first = false; ?>
                        <?php else: ?>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                            <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
