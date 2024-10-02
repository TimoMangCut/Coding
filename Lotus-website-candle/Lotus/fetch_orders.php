<?php
include 'db.php';

// Fetch pending orders
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
        WHERE orders.status = 'pending'
        ORDER BY orders.order_date DESC";

$result = $conn->query($sql);

$orders = array();
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

header('Content-Type: application/json');
echo json_encode($orders);

$conn->close();
?>
