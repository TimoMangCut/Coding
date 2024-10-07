<?php
include 'db.php';

$order_id = filter_input(INPUT_GET, 'order_id', FILTER_VALIDATE_INT);

if ($order_id === null || $order_id === false) {
    die("Invalid or missing order ID.");
}

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
            addresses.house_number
        FROM orders
        JOIN order_items ON orders.id = order_items.order_id
        JOIN addresses ON orders.user_id = addresses.user_id
        WHERE orders.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    die("Order not found.");
}

?>

<h2>Order Details</h2>
<p>Order ID: <?php echo htmlspecialchars($order['order_id']); ?></p>
<p>User ID: <?php echo htmlspecialchars($order['user_id']); ?></p>
<p>Total Cost: <?php echo htmlspecialchars($order['total_cost']); ?></p>
<p>Order Date: <?php echo htmlspecialchars($order['order_date']); ?></p>
<p>Status: <?php echo htmlspecialchars($order['status']); ?></p>
<p>Product ID: <?php echo htmlspecialchars($order['product_id']); ?></p>
<p>Quantity: <?php echo htmlspecialchars($order['quantity']); ?></p>
<p>City: <?php echo htmlspecialchars($order['city']); ?></p>
<p>District: <?php echo htmlspecialchars($order['district']); ?></p>
<p>Ward: <?php echo htmlspecialchars($order['ward']); ?></p>
<p>House Number: <?php echo htmlspecialchars($order['house_number']); ?></p>

<?php
$conn->close();
?>
